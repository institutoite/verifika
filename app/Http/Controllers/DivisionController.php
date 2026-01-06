<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\NaturalController;
use App\Http\Controllers\DivController;
use App\Http\Requests\DivisionRequest;
use Mpdf\Mpdf;

class DivisionController extends Controller
{
    
    function Sacudir(&$Vector){
        $CuantasVeces=rand(10,15);
        for ($i=0; $i <$CuantasVeces; $i++) {
            $posx=rand(0,count($Vector)-1);	 
            $posy=rand(0,count($Vector)-1);
            $aux=$Vector[$posx];
            $Vector[$posx]=$Vector[$posy];
            $Vector[$posy]=$aux; 					
        }
    }

    function mostrarVista(){
        return view('division.formdivision');
    }

/**%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% DIVISION %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% */

/**%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%  FIN CLASE  %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/
    
    function Imprimir(DivisionRequest $request){
        $UnaDificultadDividendo=$request->dificultaddo;
		$UnosDigitosDividendo=$request->digitosdo;
		$UnaDificultadDivisor=$request->dificultaddor;
		$UnosDigitosDivisor=$request->digitosdor;
        $imagenURL = public_path('images\logo.png');
        $html = '';
        $html.='<body><div>';
        $html .= '<link rel="stylesheet" href="' . public_path('css/estilosite.css') . '">';
        $encabezado = '<img src="'. $imagenURL .'">';
        $html.='<div>';
        $R=[];
        for ($k=0; $k < 4; $k++) { 
            $html .='<p class="text-right">'.($k+1).').-Reasuelve y une con una linea la respuesta correcta </p>';	
            $html .='<table class="tabla">';
            $html .= '<tr>';	
            for ($i=0; $i < 2; $i++) { 
                $S=new DivController($UnaDificultadDividendo,$UnaDificultadDivisor,$UnosDigitosDividendo,$UnosDigitosDivisor);
                $Dividendo=$S->GetDividendo();
                $Divisor=$S->GetDivisor();
                $html .= '<td class="mediano derecha dividendo">';
                $html.= $Dividendo;
                $html.="</td>";
                $html .= '<td class="mediano izquierda divisor">';
                $html.=$Divisor."<br>";
                $html.="</td>";
                $R[$i]=$S->Respuesta();
            } 			
            $html .= '</tr></table>';
            $this->Sacudir($R)	;
            $html.= '<div class="respuesta"><table class="tabla"><tr>'.'<td class="pequenio">Cociente:'.$R[0][0].' Resto:'.$R[0][1].'</td>
            <td class="pequenio">Cociente:'.$R[1][0].' Resto:'.$R[1][1].'</td>
            </tr></table></div>';
        }
        $html.='</div></body>';
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->SetMargins(10, 50, 30); 
        $mpdf->SetHeader($encabezado);
        $mpdf->SetFooter('services.ite.com.bo| propuestos.ite.com.bo |tik tok: ite_educabol');
        $mpdf->WriteHTML($html);
        return $mpdf->output("divisiones generadas ite.pdf","I");
    }
}
