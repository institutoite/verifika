<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SumaRequest;
use App\Http\Controllers\SumController;
use Mpdf\Mpdf;


use App\Models\Ejercicio;
use App\Models\Practico;
use App\Models\Operando;
use Illuminate\Support\Facades\Auth;

class SumaController extends Controller
{
    // Muestra el formulario para generar sumas
    public function create()
    {
        return view('suma.form');
    }

    // Genera y guarda sumas en la base de datos
    public function store(Request $request)
    {
        $request->validate([
            'cantidad_sumandos' => 'required|integer|min:2',
            'digitos_sumandos' => 'required|integer|min:1',
            'cantidad_sumas' => 'required|integer|min:1',
            'dificultad' => 'required|string',
        ]);

        // Crear un práctico asociado al usuario logueado
        $practico = Practico::create([
            'nombre' => 'Suma: sumandos ' . $request->digitos_sumandos . ' dígitos, nivel ' . $request->dificultad,
            'fecha' => now(),
            'user_id' => Auth::id(),
        ]);

        $ejercicios = [];
        // Definir los dígitos permitidos según la dificultad
        $digitosPorDificultad = [
            'FACILINGO' => [0,1],
            'FACIL' => [0,1,2],
            'NORMAL' => [1,2,3],
            'DIFICIL' => [3,4,5],
            'SUPERDIFICIL' => [5,6,7],
            'ULTRADIFICIL' => [7,8,9],
            'TIPOEXAMEN' => [8,9],
        ];
        $dificultad = $request->dificultad;
        $digitosPermitidos = $digitosPorDificultad[$dificultad] ?? [0,1,2,3,4,5,6,7,8,9];

        for ($i = 0; $i < $request->cantidad_sumas; $i++) {
            $sumandos = [];
            for ($j = 0; $j < $request->cantidad_sumandos; $j++) {
                $numero = '';
                for ($k = 0; $k < $request->digitos_sumandos; $k++) {
                    if ($k === 0) {
                        // Primer dígito: no puede ser 0
                        $digitosSinCero = array_diff($digitosPermitidos, [0]);
                        // Si solo hay 0, forzar 1
                        if (empty($digitosSinCero)) {
                            $digito = 1;
                        } else {
                            $digito = $digitosSinCero[array_rand($digitosSinCero)];
                        }
                    } else {
                        $digito = $digitosPermitidos[array_rand($digitosPermitidos)];
                    }
                    $numero .= $digito;
                }
                $sumandos[] = (int)$numero;
            }
            $enunciado = implode(' + ', $sumandos);
            $respuesta = array_reduce($sumandos, function($carry, $item) { return $carry + (int)$item; }, 0);
            $ejercicio = Ejercicio::create([
                'tipo' => 'suma',
                'enunciado' => $enunciado,
                'respuesta' => $respuesta,
                'grado' => $request->dificultad,
                'practico_id' => $practico->id,
            ]);
            // Guardar operandos
            foreach ($sumandos as $valor) {
                Operando::create([
                    'ejercicio_id' => $ejercicio->id,
                    'valor' => $valor,
                ]);
            }
            $ejercicios[] = $ejercicio;
        }

        // Redirigir a la lista de prácticos
        return redirect()->route('practicos.index')->with('success', 'Práctico creado correctamente.');
    }
}
