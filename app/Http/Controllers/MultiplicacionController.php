<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Multiplicacion;
use App\Models\Practico;
use App\Models\Ejercicio;
use App\Models\Operando;

class MultiplicacionController extends Controller
{
    public function create()
    {
        return view('multiplicacion.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'cantidad' => 'required|integer|min:1',
            'digitos_multiplicando' => 'required|integer|min:1',
            'digitos_multiplicador' => 'required|integer|min:1',
            'grado' => 'required|string',
        ]);
        $cantidad = $request->cantidad;
        $digitosMultiplicando = $request->digitos_multiplicando;
        $digitosMultiplicador = $request->digitos_multiplicador;
        $grado = $request->grado;
        $practico_id = $request->practico_id ?? null;
        // Definir dígitos permitidos según grado
        $grados = [
            'FACILINGO' => [0,1,2],
            'FACIL' => [2,3],
            'NORMAL' => [2,3,4],
            'DIFICIL' => [3,4,5],
            'SUPERDIFICIL' => [4,5,6],
            'ULTRADIFICIL' => [6,7,8],
            'TIPOEXAMEN' => [7,8,9],
        ];
        $digitosPermitidos = $grados[$grado] ?? range(0,9);
        // Crear un nuevo Practico y asociar los ejercicios
        $user = auth()->user();
        $practico = Practico::create([
            'nombre' => 'Multiplicaciones ' . now()->format('Y-m-d H:i:s'),
            'descripcion' => 'Práctico generado automáticamente para multiplicaciones',
            'user_id' => $user ? $user->id : null,
        ]);
        for ($i = 0; $i < $cantidad; $i++) {
            // Generar multiplicando (dígitos 0-9)
            $multiplicandoArr = [];
            for ($d = 0; $d < $digitosMultiplicando; $d++) {
                $choices = range(0,9);
                if ($d == 0) $choices = array_diff($choices, [0]);
                $multiplicandoArr[] = $choices[array_rand($choices)];
            }
            $multiplicando = (int)implode('', $multiplicandoArr);
            // Generar multiplicador (según grado)
            $multiplicadorArr = [];
            for ($d = 0; $d < $digitosMultiplicador; $d++) {
                $choices = $digitosPermitidos;
                if ($d == 0) $choices = array_diff($choices, [0]);
                $multiplicadorArr[] = $choices[array_rand($choices)];
            }
            $multiplicador = (int)implode('', $multiplicadorArr);
            $enunciado = $multiplicando . ' × ' . $multiplicador;
            $respuesta = $multiplicando * $multiplicador;
            $ejercicio = Ejercicio::create([
                'tipo' => 'multiplicacion',
                'enunciado' => $enunciado,
                'respuesta' => $respuesta,
                'grado' => $grado,
                'practico_id' => $practico->id,
            ]);
            Operando::create([
                'ejercicio_id' => $ejercicio->id,
                'valor' => $multiplicando,
            ]);
            Operando::create([
                'ejercicio_id' => $ejercicio->id,
                'valor' => $multiplicador,
            ]);
        }
        return redirect()->route('practicos.index')->with('success', 'Multiplicaciones generadas correctamente.');
    }
}
