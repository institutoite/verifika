<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DivController extends Controller
{
    private $Dividendo;
    private $Dificultaddo;
    private $Digitos_Dividendo;

    private $Divisor;
    private $Dificultad_Divisor;
    private $Digitos_Divisor;

function __construct($difiDividendo,$difiDivisor,$digitosDividendo,$digitosDivisor)
{ 
    $this->Dividendo=new NaturalController($difiDividendo,$digitosDividendo);

    $this->Divisor=new NaturalController($difiDivisor,$digitosDivisor);
}

function GetDividendo(){
    return $this->Dividendo->GetValor();
}

function GetDivisor(){
    return $this->Divisor->GetValor();
}

function Respuesta(){
    if($this->Divisor->GetValor()!=0){
    return [floor($this->Dividendo->GetValor()/$this->Divisor->GetValor()),$this->Dividendo->GetValor()%$this->Divisor->GetValor()];	
    }else{
        return ["Infinito","infinito"];
    }
}

}
