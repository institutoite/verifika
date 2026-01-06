<?php

namespace App\Http\Controllers\itesolve;

use App\Http\Controllers\Controller;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DivisionIteSolveController extends Controller
{
    private $pasos = []; // Array para guardar los pasos
    private $pasoActual = 0; // Índice del paso actual
    private $cuadricula = [];
    private $posCociente = 0;
    private $filaActual = 1; // Empezar en la fila 1 para el cociente
    private $cantidadDigitosDividendo = 0;
    private $cantidadDigitosDivisor = 0;
    private $dividendo;
    private $divisor;

    // Mostrar el formulario
    public function index()
    {
        return view('itesolve.division.division');
    }

    // Procesar la división
    public function dividir(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'dividendo' => 'required|numeric|min:1',
            'divisor' => 'required|numeric|min:1|not_in:0', // 👈 Evita divisor 0
        ], [
            'dividendo.required' => 'El dividendo es obligatorio.',
            'dividendo.numeric' => 'El dividendo debe ser un número.',
            'dividendo.min' => 'El dividendo debe ser mayor que 0.',
            'divisor.required' => 'El divisor es obligatorio.',
            'divisor.numeric' => 'El divisor debe ser un número.',
            'divisor.min' => 'El divisor debe ser mayor que 0.',
            'divisor.not_in' => 'El divisor no puede ser 0.', // 👈 Mensaje para divisor 0
        ]);
    
        // Si la validación falla, redirige con errores
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $this->dividendo = $request->dividendo;
        $this->divisor = $request->divisor;

        
        $this->cantidadDigitosDividendo = count(str_split((string)$this->dividendo));
        $this->cantidadDigitosDivisor = count(str_split((string)$this->divisor));
        // Reiniciar los pasos
        $this->pasos = [];
        $this->pasoActual = 0;

        // Crear la cuadrícula inicial
        $this->crearCuadriculaInicial($this->dividendo, $this->divisor);

        // Realizar la división paso a paso
        $this->realizarDivision($this->dividendo, $this->divisor);

        // Guardar los pasos en la sesión
        session(['pasos' => $this->pasos]);
        session(['pasoActual' => $this->pasoActual]);

        return view('itesolve.division.division', [
            'dividendo' => $this->dividendo,
            'count_digitos_divisor' => $this->cantidadDigitosDividendo+1,
            'divisor' => $this->divisor,
            'cuadricula' => $this->pasos[$this->pasoActual],
            'pasoActual' => $this->pasoActual,
            'totalPasos' => count($this->pasos),
        ]);
    }



    // Crear la cuadrícula inicial
    private function crearCuadriculaInicial($dividendo, $divisor)
    {
        $digitosDividendo = str_split((string)$dividendo);
        $this->cantidadDigitosDividendo = count($digitosDividendo);
        $digitosDivisor = str_split((string)$divisor);
        $this->cantidadDigitosDivisor = count($digitosDivisor);
        $numFilas = $this->cantidadDigitosDividendo + 10; // Filas adicionales para los pasos
        $numColumnas = $this->cantidadDigitosDividendo + $this->cantidadDigitosDivisor + 8;

        // Inicializar la cuadrícula
        for ($i = 0; $i < $numFilas; $i++) {
            for ($j = 0; $j < $numColumnas; $j++) {
                $this->cuadricula[$i][$j] = "";
            }
        }

        // Colocar los dígitos del dividendo en la fila 0
        $columnaActual = 0;
        for ($j = 0; $j < $this->cantidadDigitosDividendo; $j++) {
            $this->cuadricula[0][$columnaActual] = $digitosDividendo[$j];
            $columnaActual++;
        }

        // Colocar el símbolo ÷ en la fila 0
        $this->cuadricula[0][$columnaActual] = "";
        $columnaActual++;
        
        
        $this->posCociente = $columnaActual;

        // Colocar los dígitos del divisor en la fila 0
        for ($k = 0; $k < $this->cantidadDigitosDivisor; $k++) {
            $this->cuadricula[0][$columnaActual] = $digitosDivisor[$k];
            $columnaActual++;
        }

        // Guardar el paso inicial
        $this->pasos[] = $this->cuadricula;
    }

    // Realizar la división paso a paso
    private function realizarDivision($dividendo, $divisor)
    {
        $digitosDividendo = str_split((string)$dividendo);
        $digitosDivisor = str_split((string)$divisor);
        $residuo = 0;
        $indiceDividendo = 0;
        $cociente = "";
    
        // Fila y columna para el cociente
        $fila_cociente = 1; // Fila constante debajo del divisor
        $columna_cociente = $this->posCociente; // Columna inicial del cociente
    
        // Fila para el proceso (producto, residuo y cifra bajada)
        $fila_proceso = 1; // Fila debajo del cociente
    
        while ($indiceDividendo < $this->cantidadDigitosDividendo) {
            // Tomar el siguiente dígito del dividendo
            $residuo = $residuo * 10 + (int)$digitosDividendo[$indiceDividendo];
            $indiceDividendo++;
    
        // Si el residuo es menor que el divisor, continuar
        if ($residuo < $divisor) {
            // Solo agregar un cero al cociente si ya hay dígitos en él
            if ($cociente !== "") {
                $cociente .= "0";
                $this->cuadricula[$fila_cociente][$columna_cociente] = "0"; // Mostrar 0 en el cociente
                $columna_cociente++; // Mover a la siguiente columna para el cociente
            }
            continue;
        }
    
            // Calcular el dígito del cociente
            $digitoCociente = floor($residuo / $divisor);
            $cociente .= $digitoCociente;
    
            // Mostrar el dígito del cociente en la fila y columna correcta
            $this->cuadricula[$fila_cociente][$columna_cociente] = $digitoCociente;
            $columna_cociente++; // Mover a la siguiente columna para el cociente
    
            // Calcular el producto
            $producto = $divisor * $digitoCociente;
            $productoDigitos = str_split((string)$producto);
    
            // Colocar el producto en la cuadrícula
            $columnaProducto = $indiceDividendo - count($productoDigitos);
            for ($k = 0; $k < count($productoDigitos); $k++) {
                $this->cuadricula[$fila_proceso][$columnaProducto + $k] = $productoDigitos[$k];
            }
    
            // Calcular el nuevo residuo
            $residuo = $residuo - $producto;
            $residuoDigitos = str_split((string)$residuo);
    
            // Colocar el residuo en la cuadrícula
            $columnaResiduo = $indiceDividendo - count($residuoDigitos);
            for ($k = 0; $k < count($residuoDigitos); $k++) {
                $this->cuadricula[$fila_proceso + 1][$columnaResiduo + $k] = $residuoDigitos[$k];
            }
    
            // Bajar la siguiente cifra del dividendo
            if ($indiceDividendo < $this->cantidadDigitosDividendo) {
                $this->cuadricula[$fila_proceso + 1][$columnaResiduo + count($residuoDigitos)] = $digitosDividendo[$indiceDividendo];
            }
    
            // Guardar el paso
            $this->pasos[] = $this->cuadricula;
            $fila_proceso += 2; // Avanzar a la siguiente fila para el siguiente paso
        }
    }
    // Navegar entre los pasos
    public function navegar(Request $request)
    {
       
        $accion = $request->accion;
        $pasos = session('pasos', []);
        $pasoActual = session('pasoActual', 0);

        switch ($accion) {
            case 'reiniciar':
                $pasoActual = 0;
                break;
            case 'atras':
                if ($pasoActual > 0) $pasoActual--;
                break;
            case 'siguiente':
                if ($pasoActual < count($pasos) - 1) $pasoActual++;
                break;
            case 'resolver':
                $pasoActual = count($pasos) - 1;
                break;
        }

        // Guardar el paso actual en la sesión
        session(['pasoActual' => $pasoActual]);

        return view('itesolve.division.division', [
            'cuadricula' => $pasos[$pasoActual],
            'pasoActual' => $pasoActual,
            'totalPasos' => count($pasos),
            'count_digitos_divisor' => $this->encontrarPrimeraPosicionVacia() + 1, // Índice del divisor
        ]);
    }

function encontrarPrimeraPosicionVacia() {
    $indice = 0;
    $array=session('pasos')[0];
    $longitud = count($array[0]);
    
    // Buscar el primer elemento vacío en la fila 0 (cociente
    while ($indice < $longitud) {
        if ($array[0][$indice] == "" || $array[0][$indice] == null) {
            return $indice;
        }
        $indice++;
    }
    

    return -1; // Retorna -1 si no hay elementos vacíos
}
    function contarDigitosCociente() {
        if ($this->divisor == 0) {
            return 0;
        }
    
        // Realizar la división
        $cociente = intdiv($this->dividendo, $this->divisor);
    
        // Contar los dígitos del cociente
        $cantidadDigitos = strlen((string)abs($cociente));
    
        return $cantidadDigitos;
    }
}
