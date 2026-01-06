<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NaturalController extends Controller
{
    private $Valor;
	function __construct($Dificultad,$Digitos)
	{
        $this->Valor=0;
        $i=1;
        while ($i <= $Digitos) {
            
            switch ($Dificultad) {
                    case config('constantes.FACILINGO'):
                            $CriaturaDigito=rand(1,4);
                        break;
                    case config('constantes.FACIL'):
                            $CriaturaDigito=rand(2,5);
                        break;    
                    case config('constantes.INTERMEDIO'):
                            $CriaturaDigito=rand(4,6);
                        break;    
                    case config('constantes.AVANZADO'):
                            $CriaturaDigito=rand(5,8);
                        break;    
                    case config('constantes.SUPERAVANZADO'):
                            $CriaturaDigito=rand(6,9);
                        break;    
                    case config('constantes.ULTRAAVANZADO'):
                            $CriaturaDigito=rand(7,9);
                        break;    
                    case config('constantes.TIPOEXAMEN'):
                            $CriaturaDigito=rand(8,9);
                        break;    
                    
                    default:
                        $CriaturaDigito=rand(4,8);
                        echo "Default<br>";
                        break;
                }	
            $this->Valor=$this->Valor*10+$CriaturaDigito;	
            $i++;
        } 	
	}

	function GetValor(){
		return $this->Valor;
	}

	function SetValor($UnValor){
		return $this->Valor=$UnValor;
	}

	function Cantidad_Digitos(){
		return floor(log10($this->GetValor()))+1;
	}

	function EsPrimo(){
		return true;
	}

	function Vectorizar(){
		$Vector=[];
		$Numero= $this->GetValor();
		$CantidaDig=$this->Cantidad_Digitos();
		while($Numero>0){
			$Vector[$CantidaDig-1]=$Numero%10;
			$Numero=floor($Numero/10);
			$CantidaDig=$CantidaDig-1;
		}
	return $Vector;
	}
}
