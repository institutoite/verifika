<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MulController extends Controller
{
    private $Multiplicando;
    private $Dificultaddo;
    private $Digitos_Multiplicando;

    private $Multiplicador;
    private $Dificultad_Multiplicador;
    private $Digitos_Multiplicador;

function __construct($difiMultiplicando,$difiMultiplicador,$digitosMultiplicando,$digitosMultiplicador)
{ 
    //$this->$Dificultad_Multiplicador=$difiMultiplicador;
    //$this->$Digitos_Multiplicador=$digitosMultiplicador;
    //$this->$Dificultaddo=$difiMultiplicando;
    $this->Multiplicando=new NaturalController($difiMultiplicando,$digitosMultiplicando);
    //$this->$Digitos_Multiplicando=$digitosMultiplicando;
    $this->Multiplicador=new NaturalController($difiMultiplicador,$digitosMultiplicador);

}

function GetMultiplicando(){
    return $this->Multiplicando->GetValor();
}

function GetMultiplicador(){
    return $this->Multiplicador->GetValor();
}

function Respuesta(){
    return $this->Multiplicando->GetValor()*$this->Multiplicador->GetValor();	
}

}
