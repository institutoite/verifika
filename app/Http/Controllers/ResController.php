<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResController extends Controller
{
        private $Minuendo;
		private $Dificultad;
		private $Sustraendo;
		private $Digitos;


	function __construct($dificultad, $digitos)
{ 
    // Inicializar el minuendo y el sustraendo
    $this->Minuendo = -1;
    $this->Sustraendo = 0;

    // Generar el minuendo y el sustraendo hasta que el minuendo sea mayor que el sustraendo
    while ($this->Minuendo <= $this->Sustraendo) {
        $this->Minuendo = new NaturalController($dificultad, $digitos);
        $this->Sustraendo = new NaturalController($dificultad, $digitos);
    }
    
    $this->Digitos = $digitos;
    $this->Dificultad = $dificultad;
}
function generarNumeroAlAzar($cantidadDigitos) {
    // Verificar que la cantidad de dígitos sea válida
    if ($cantidadDigitos < 1) {
        return rand(1, 2);
    }

    // Generar los límites inferior y superior basados en la cantidad de dígitos
    $limiteInferior = pow(10, $cantidadDigitos - 1);
    $limiteSuperior = pow(10, $cantidadDigitos) - 1;

    // Retornar un número aleatorio entre los límites
    return rand($limiteInferior, $limiteSuperior);
}
	
	function GetMinuendo(){
		return $this->Minuendo->getValor()+$this->generarNumeroAlAzar($this->Digitos-1);
	}

	function GetSustraendo(){
		return $this->Sustraendo->getValor();
	}

	function Respuesta(){
		return $this->Minuendo->getValor()-$this->Sustraendo->getValor();	
	}
}
