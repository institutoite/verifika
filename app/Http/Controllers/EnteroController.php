<?php

namespace App\Http\Controllers;

use App\Models\Entero;
use Illuminate\Http\Request;
use Mpdf\Mpdf;

class EnteroController extends Controller
{
    public function index()
    {
        $ejercicios = Entero::all();
        return view('enteros.index', compact('ejercicios'));
    }

    public function generate(Request $request)
    {
        // (Código existente para generar ejercicios aleatorios según el nivel)
        // ...
    }

    public function generatePdf(Request $request)
    {
        $nivel = $request->input('nivel');
        $cantidad = 10; // Cambiar la cantidad de ejercicios a generar
        $ejerciciosGenerados = [];
    
        for ($i = 0; $i < $cantidad; $i++) {
            switch ($nivel) {
                case 1: // Ejercicios con números positivos
                    $num1 = rand(1, 20);
                    $num2 = rand(1, 20);
                    $ejerciciosGenerados[] = "$num1 + $num2"; // Formato: 5 + 6
                    break;
                case 2: // Ejercicios con números negativos
                    $num1 = rand(-1, -20);
                    $num2 = rand(-1, -20);
                    $ejerciciosGenerados[] = "$num1 + $num2"; // Formato: -4 + -7
                    break;
                case 3: // Ejercicios con signo contrario, positivo primero
                    $num1 = rand(1, 20);
                    $num2 = rand(1, 20) * -1; // Asegura que el número sea negativo
                    $ejerciciosGenerados[] = "$num1 + $num2"; // Formato: 8 + -4
                    break;
                case 4: // Ejercicios donde el negativo es mayor
                    $num1 = rand(-1, -20);
                    $num2 = rand(1, 20); // Mantener un número positivo
                    $ejerciciosGenerados[] = "$num1 + $num2"; // Formato: -8 + 3
                    break;
                case 5: // Combinación de más de tres números
                    $ejercicio = [];
                    for ($j = 0; $j < 5; $j++) {
                        $num = rand(1, 10);
                        if ($j === 0) {
                            // Primer número sin signo
                            $ejercicio[] = $num;
                        } else {
                            // Selecciona aleatoriamente un signo
                            $signo = rand(0, 1) === 0 ? '+' : '-';
    
                            // Evitar doble signo
                            if ($signo === '-' && end($ejercicio) < 0) {
                                $num = rand(1, 10); // Generar un positivo si el último número es negativo
                                $signo = '+'; // Cambiar el signo a positivo
                            }
    
                            $ejercicio[] = "$signo $num";
                        }
                    }
                    $ejerciciosGenerados[] = implode(" ", $ejercicio); // Formato: -4 + 5 - 8 - 9 + 3
                    break;
                case 6: // Mezcla de todos los niveles
                    $ejercicio = [];
                    $signos = ['+', '-']; // Posibles signos
                    for ($j = 0; $j < 10; $j++) { // Cambié la cantidad a 10 como ejemplo
                        // Generar un número aleatorio
                        $num = rand(1, 20);
                        
                        // Verificar si es el primer número o no
                        if ($j === 0) {
                            $ejercicio[] = $num; // Primer número sin signo
                        } else {
                            // Seleccionar un signo aleatorio
                            $signo = $signos[array_rand($signos)];
                            
                            // Evitar que dos negativos se unan
                            if ($signo === '-' && end($ejercicio) < 0) {
                                $num = rand(1, 20); // Generar un número positivo si el último número es negativo
                                $signo = '+'; // Cambiar el signo a positivo
                            }
    
                            $ejercicio[] = "$signo $num"; // Agregar el signo y el número
                        }
                    }
                    $ejerciciosGenerados[] = implode(" ", $ejercicio); // Formato: -4 + 5 - 8 - 9 + 3
                    break;
                default:
                    return redirect()->route('ejercicios.index')->with('error', 'Nivel no válido.');
            }
        }
    
        // Generar PDF
        $mpdf = new Mpdf();
        $mpdf->SetTitle('Ejercicios de Números Enteros');
    
        $html = '<h1>Ejercicios Generados</h1><ol>';
        foreach ($ejerciciosGenerados as $ejercicio) {
            $html .= "<li>$ejercicio</li>";
        }
        $html .= '</ol>';
    
        $mpdf->WriteHTML($html);
        $mpdf->Output('ejercicios.pdf', 'D'); // D para descargar
    
        return; // Se detiene la ejecución aquí porque el PDF se envía directamente
    }
    
    private function generateFromLevel($nivel, &$ejerciciosGenerados)
    {
        switch ($nivel) {
            case 1:
                $num1 = rand(1, 20);
                $num2 = rand(1, 20);
                $ejerciciosGenerados[] = "$num1 + $num2"; // Formato: 5 + 6
                break;
            case 2:
                $num1 = rand(-20, -1);
                $num2 = rand(-20, -1);
                $ejerciciosGenerados[] = "$num1 + $num2"; // Formato: -4 + -7
                break;
            case 3:
                $num1 = rand(1, 20);
                $num2 = rand(1, 19) * -1; // Aseguramos que sea negativo
                $ejerciciosGenerados[] = "$num1 + $num2"; // Formato: 8 + -4
                break;
            case 4:
                $num1 = rand(-1, -19);
                $num2 = rand(1, 20);
                $ejerciciosGenerados[] = "$num1 + $num2"; // Formato: -8 + 3
                break;
            case 5:
                $ejercicio = [];
                for ($j = 0; $j < 10; $j++) { // cantidad de numeros
                    $num = rand(-20, 20);
                    if ($j > 0 && $num < 0 && end($ejercicio) < 0) {
                        $num = rand(1, 20); // Generar un positivo si el último número es negativo
                    }
                    $ejercicio[] = $num;
                }
                // Crear la cadena de operación sin doble signo
                $ejerciciosGenerados[] = implode(" + ", $ejercicio); // Formato: -4 + 5 + 6
                break;
        }
    }
    
    public function destroy($id)
    {
        $ejercicio = Entero::findOrFail($id);
        $ejercicio->delete();

        return redirect()->route('ejercicios.index')->with('success', 'Ejercicio eliminado con éxito.');
    }
}
