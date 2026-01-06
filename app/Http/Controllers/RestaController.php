<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RestaController extends Controller
{
    // Muestra el formulario para generar restas
    public function create()
    {
        return view('resta.form');
    }

    // Genera y guarda restas en la base de datos
    public function store(Request $request)
    {
        $request->validate([
            'digitos_minuendo' => 'required|integer|min:1',
            'cantidad_restas' => 'required|integer|min:1',
            'dificultad' => 'required|string',
        ]);

        $practico = \App\Models\Practico::create([
            'nombre' => 'Práctico de restas '.now()->format('Y-m-d H:i:s'),
            'fecha' => now(),
            'user_id' => \Auth::id(),
        ]);

        $config = [
            'FACILINGO' => ['digs' => [1,2,3], 'acarreos' => 0, 'min_digs' => 1],
            'FACIL' => ['digs' => [1,2,3,4], 'acarreos' => 0, 'min_digs' => 1],
            'NORMAL' => ['digs' => [1,2,3,4,5], 'acarreos' => 0, 'min_digs' => 1],
            'DIFICIL' => ['digs' => [1,2,3,4,5,6], 'acarreos' => 1, 'min_digs' => 2],
            'SUPERDIFICIL' => ['digs' => [1,2,3,4,5,6,7], 'acarreos' => 2, 'min_digs' => 3],
            'ULTRADIFICIL' => ['digs' => [1,2,3,4,5,7,8], 'acarreos' => 3, 'min_digs' => 4],
            'TIPOEXAMEN' => ['digs' => [0,1,2,3,4,5,6,7,8,9], 'acarreos' => -1, 'min_digs' => 5],
        ];
        $dif = $request->dificultad;
        $conf = $config[$dif] ?? $config['FACILINGO'];
        $digitosPermitidos = $conf['digs'];
        $acarreos = $conf['acarreos'];
        $minDigitos = $conf['min_digs'];

        $digitos_minuendo = max($request->digitos_minuendo, $minDigitos);
        $digitos_sustraendo = $digitos_minuendo; // Siempre igual

        for ($i = 0; $i < $request->cantidad_restas; $i++) {
            foreach (['a', 'b'] as $inciso) {
                $minuendoArr = [];
                $sustraendoArr = [];
                $acarreoCount = 0;
                $acarreoPos = [];
                if ($acarreos > 0) {
                    $acarreoPos = range($digitos_minuendo-1, 0);
                    shuffle($acarreoPos);
                    $acarreoPos = array_slice($acarreoPos, 0, $acarreos);
                    // Para DIFICIL, garantizar acarreo en unidades (posición más a la derecha)
                    if ($acarreos === 1) {
                        $acarreoPos = [$digitos_minuendo-1];
                    }
                } else if ($acarreos === -1) {
                    $acarreoPos = range(1, $digitos_minuendo-1);
                }
                $intentos = 0; $maxIntentos = 30;
                do {
                    $minuendoArr = [];
                    $sustraendoArr = [];
                    // 1. Generar acarreos (de derecha a izquierda)
                    for ($d = $digitos_minuendo-1; $d >= $digitos_minuendo-count($acarreoPos); $d--) {
                        do {
                            $minuendoChoices = $digitosPermitidos;
                            if ($d == 0) $minuendoChoices = array_diff($minuendoChoices, [0]);
                            $minuendoDig = $minuendoChoices[array_rand($minuendoChoices)];
                            $sustraendoChoices = array_filter($digitosPermitidos, function($x) use ($minuendoDig) { return $x > $minuendoDig; });
                            if ($d == 0) $sustraendoChoices = array_diff($sustraendoChoices, [0]);
                            $sustraendoDig = $sustraendoChoices ? $sustraendoChoices[array_rand($sustraendoChoices)] : $minuendoDig+1;
                        } while ($minuendoDig >= $sustraendoDig);
                        array_unshift($minuendoArr, $minuendoDig);
                        array_unshift($sustraendoArr, $sustraendoDig);
                    }
                    // 2. Generar dígitos de más peso (sin acarreo)
                    for ($d = $digitos_minuendo-count($acarreoPos)-1; $d >= 0; $d--) {
                        do {
                            $minuendoChoices = $digitosPermitidos;
                            if ($d == 0) $minuendoChoices = array_diff($minuendoChoices, [0]);
                            $minuendoDig = $minuendoChoices[array_rand($minuendoChoices)];
                            $sustraendoChoices = array_filter($digitosPermitidos, function($x) use ($minuendoDig) { return $x < $minuendoDig; });
                            if ($d == 0) $sustraendoChoices = array_diff($sustraendoChoices, [0]);
                            $sustraendoDig = $sustraendoChoices ? $sustraendoChoices[array_rand($sustraendoChoices)] : ($minuendoDig > 0 ? $minuendoDig-1 : 0);
                        } while ($minuendoDig <= $sustraendoDig);
                        array_unshift($minuendoArr, $minuendoDig);
                        array_unshift($sustraendoArr, $sustraendoDig);
                    }
                    $minuendo = (int)implode('', $minuendoArr);
                    $sustraendo = (int)implode('', $sustraendoArr);
                    $intentos++;
                    $condSustraendoMayor = $sustraendo >= $minuendo;
                    $condSustraendoDigitos = strlen((string)$sustraendo) < $digitos_minuendo;
                    $condSustraendoCero = $sustraendoArr[0] == 0;
                } while (($condSustraendoMayor || $condSustraendoDigitos || $condSustraendoCero) && $intentos < $maxIntentos);
                // Si no se logra, forzar el acarreo en unidades y que el número sea válido
                if ((in_array($digitos_minuendo-1, $acarreoPos) && $minuendoArr[$digitos_minuendo-1] >= $sustraendoArr[$digitos_minuendo-1])
                    || $sustraendo >= $minuendo
                    || strlen((string)$sustraendo) < $digitos_minuendo
                    || $sustraendoArr[0] == 0) {
                    $minuendoArr[$digitos_minuendo-1] = 3;
                    $sustraendoArr[$digitos_minuendo-1] = 5;
                    if ($minuendoArr[0] == 0) $minuendoArr[0] = 1;
                    if ($sustraendoArr[0] == 0) $sustraendoArr[0] = 1;
                    $minuendo = (int)implode('', $minuendoArr);
                    $sustraendo = (int)implode('', $sustraendoArr);
                    if ($sustraendo >= $minuendo) {
                        $minuendoArr[0] = $minuendoArr[0]+1;
                        $minuendo = (int)implode('', $minuendoArr);
                    }
                }
                $enunciado = $minuendo . ' - ' . $sustraendo;
                $respuesta = $minuendo - $sustraendo;
                $ejercicio = \App\Models\Ejercicio::create([
                    'tipo' => 'resta',
                    'enunciado' => $enunciado,
                    'respuesta' => $respuesta,
                    'grado' => $dif,
                    'practico_id' => $practico->id,
                ]);
                \App\Models\Operando::create([
                    'ejercicio_id' => $ejercicio->id,
                    'valor' => $minuendo,
                ]);
                \App\Models\Operando::create([
                    'ejercicio_id' => $ejercicio->id,
                    'valor' => $sustraendo,
                ]);
            }
        }
        return redirect()->route('practicos.index')->with('success', 'Práctico de restas creado correctamente.');
    }
}