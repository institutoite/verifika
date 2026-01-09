<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DivisionNuevaController extends Controller
{
    public function create()
    {
        return view('division.formdivision');
    }

    public function generar(Request $request)
    {
        $request->validate([
            'dificultad' => 'required|string',
            'digitos_dividendo' => 'required|integer|min:1',
            'digitos_divisor' => 'required|integer|min:1',
            'cantidad' => 'required|integer|min:1|max:50',
        ]);

        $dificultad = $request->input('dificultad');
        $digitosDividendo = $request->input('digitos_dividendo');
        $digitosDivisor = $request->input('digitos_divisor');
        $cantidad = $request->input('cantidad');

        $user = auth()->user();
        $practico = \App\Models\Practico::create([
            'nombre' => 'División: dividendo ' . $digitosDividendo . ' dígitos, divisor ' . $digitosDivisor . ' dígitos, nivel ' . $dificultad,
            'descripcion' => 'Práctico generado automáticamente para divisiones',
            'user_id' => $user ? $user->id : null,
        ]);

        // Lógica para generar divisiones según dificultad
        $grados = [
            'FACILINGO' => range(2, 9),
            'FACIL' => range(2, 9),
            'NORMAL' => range(2, 9),
            'DIFICIL' => range(2, 9),
            'SUPERDIFICIL' => range(2, 9),
            'ULTRADIFICIL' => range(2, 9),
            'TIPOEXAMEN' => range(2, 9),
        ];
        $digitosPermitidos = $grados[$dificultad] ?? range(2, 9);

        for ($i = 0; $i < $cantidad; $i++) {
            // Generar dividendo
            $dividendoArr = [];
            for ($d = 0; $d < $digitosDividendo; $d++) {
                $choices = range(0,9);
                if ($d == 0) $choices = array_diff($choices, [0]);
                $dividendoArr[] = $choices[array_rand($choices)];
            }
            $dividendo = (int)implode('', $dividendoArr);

            // Generar divisor
            $divisorArr = [];
            for ($d = 0; $d < $digitosDivisor; $d++) {
                $choices = $digitosPermitidos;
                if ($d == 0) $choices = array_diff($choices, [0]);
                $divisorArr[] = $choices[array_rand($choices)];
            }
            $divisor = (int)implode('', $divisorArr);
            if ($divisor == 0) $divisor = 1; // Evitar división por cero

            // Enunciado: dividendo a la izquierda, símbolo L con solo el divisor dentro
            $enunciado = '
            <span style="display:inline-flex;align-items:center;vertical-align:middle;">
                <span style="min-width:2.5em;text-align:right;font-family:monospace;font-size:1.2em;">' . $dividendo . '</span>
                <span style="display:inline-block;position:relative;width:2.2em;height:1.7em;margin-left:0.2em;">
                    <span style="position:absolute;left:0;top:0;border-left:2px solid #222;height:1.6em;"></span>
                    <span style="position:absolute;left:0;bottom:0;border-bottom:2px solid #222;width:2em;"></span>
                    <span style="position:absolute;left:0.3em;top:0.1em;width:1.6em;text-align:left;font-family:monospace;font-size:1.2em;">' . $divisor . '</span>
                </span>
            </span>';
            $cociente = $divisor != 0 ? intdiv($dividendo, $divisor) : 0;
            $resto = $divisor != 0 ? $dividendo % $divisor : 0;
            $ejercicio = \App\Models\Ejercicio::create([
                'tipo' => 'division',
                'enunciado' => $enunciado,
                'respuesta' => '',
                'grado' => $dificultad,
                'practico_id' => $practico->id,
                'cociente' => $cociente,
                'resto' => $resto,
            ]);
            \App\Models\Operando::create([
                'ejercicio_id' => $ejercicio->id,
                'valor' => $dividendo,
            ]);
            \App\Models\Operando::create([
                'ejercicio_id' => $ejercicio->id,
                'valor' => $divisor,
            ]);
        }

        return redirect()->route('practicos.index')->with('success', 'Divisiones generadas correctamente.');
    }
}
