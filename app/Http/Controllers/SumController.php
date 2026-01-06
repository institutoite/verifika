<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SumController extends Controller
{
    private $Vector;
    private $Dificultad;
    private $CantidadSumandos;
    private $Digitos;

function __construct($dificultad,$Sumandos,$digitos)
{ 
    for ($i=0; $i < $Sumandos; $i++) { 
        $sumando=new NaturalController($dificultad,$digitos);
        $this->Vector[$i]=$sumando;	
    }
    
    $this->Digitos=$digitos;
    $this->Dificultad=$dificultad;
    $this->CantidadSumandos=$Sumandos;			
}

function GetSumandos(){
    return $this->Vector;
}

function Respuesta(){
        $respuesta=0;
        for ($i=0; $i <$this->CantidadSumandos  ; $i++) { 
            $respuesta=$respuesta+$this->Vector[$i]->GetValor();
        }
    return $respuesta;	
}
}
