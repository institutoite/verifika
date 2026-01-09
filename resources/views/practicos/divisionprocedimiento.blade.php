<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>División - Procedimiento</title>
    <style>
        @page { margin: 2cm; }
        body { font-family: Arial, sans-serif; }
        .cuadricula {
            border-collapse: collapse;
            margin: 10px 0 18px 0;
        }
        .cuadricula td {
            border: 1px solid #bbb;
            width: 1.2em;
            height: 1.2em;
            text-align: center;
            font-size: 1.2em;
            font-family: monospace;
        }
        .inciso-label { font-weight: bold; text-align: left; padding-right: 8px; }
        .ej-titulo { font-size: 1.1em; font-weight: bold; margin: 18px 0 4px 0; }
        .ej-grado { font-size: 0.95em; color: #888; margin-left: 8px; }
    </style>
</head>
<body>
    <h2>División con procedimiento</h2>
    @php $ejercicioNum = 1; @endphp
    @for($i = 0; $i < count($practico->ejercicios); $i += 2)
        @php
            $ejA = $practico->ejercicios[$i] ?? null;
            $ejB = $practico->ejercicios[$i+1] ?? null;
        @endphp
        <div class="ej-titulo">Ejercicio {{ $ejercicioNum }}
            <span class="ej-grado">[{{ $ejA->grado ?? ($ejB->grado ?? '') }}]</span>
        </div>
        <table style="width:100%; border-collapse:collapse;">
            <tr>
                <td style="vertical-align:top; width:49%;">
                @php $pasosA = $pasosEjercicios[$i] ?? null; @endphp
                @if($ejA && $pasosA)
                    {{-- JSON eliminado para mejor visualización --}}
                    <div class="inciso-label">a)</div>
                    {{-- Encabezado: DIVIDENDO L DIVISOR --}}
                    <table class="cuadricula" style="margin-bottom:10px;">
                        <tr>
                            {{-- Dividendo --}}
                            @for($d=0; $d < strlen($pasosA['dividendo']); $d++)
                                <td style="font-weight:bold; background:#f2f2f2;">{{ $pasosA['dividendo'][$d] }}</td>
                            @endfor
                            {{-- Línea vertical del símbolo de división y divisor juntos --}}
                            @php $divisorStrA = strval($pasosA['divisor']); @endphp
                            @for($d=0; $d < strlen($divisorStrA); $d++)
                                <td style="background:#f2f2f2; font-weight:bold; border-left:{{ $d==0 ? '2px solid #000' : 'none' }}; border-bottom:2px solid #000;">{{ $divisorStrA[$d] }}</td>
                            @endfor
                        </tr>
                        <tr>
                            {{-- Cocientes parciales y nuevo dividendo parcial debajo del dividendo --}}
                            @for($d=0; $d < strlen($pasosA['dividendo']); $d++)
                                <td style="background:#fff; font-family:monospace; text-align:center;">
                                    @if(isset($pasosA['steps'][0]) && $d == $pasosA['steps'][0]['index'])
                                        @if(isset($pasosA['steps'][0]['nextDigit']) && $pasosA['steps'][0]['quotientDigit'] === 0 && $pasosA['steps'][0]['nextDigit'] !== null)
                                            {{ $pasosA['steps'][0]['reach'] }}{{ $pasosA['steps'][0]['nextDigit'] }}
                                        @else
                                            {{ $pasosA['steps'][0]['reach'] }}
                                        @endif
                                    @endif
                                </td>
                            @endfor
                            {{-- Cociente debajo del divisor, alineado por columnas --}}
                            @for($d=0; $d < strlen($pasosA['cociente']); $d++)
                                <td style="background:#fff; font-family:monospace; font-size:1.2em; text-align:center; font-weight:bold;">{{ $pasosA['cociente'][$d] }}</td>
                            @endfor
                        </tr>
                        {{-- Desarrollo vertical: cada paso debajo del dígito correspondiente del dividendo --}}
                        @for($s=1; $s < count($pasosA['steps']); $s++)
                            <tr>
                                @for($d=0; $d < strlen($pasosA['dividendo']); $d++)
                                    <td style="background:#fff; font-family:monospace; text-align:center;">
                                        @if($d == $pasosA['steps'][$s]['index'])
                                            {{ $pasosA['steps'][$s]['reach'] }}
                                        @elseif(
                                            $d == $pasosA['steps'][$s]['index'] + 1 &&
                                            isset($pasosA['steps'][$s-1]['bringDown']) && $pasosA['steps'][$s-1]['bringDown'] && isset($pasosA['steps'][$s-1]['nextDigit']) && $pasosA['steps'][$s-1]['nextDigit'] !== null
                                        )
                                            <span style="color:#007; font-weight:bold;">↓{{ $pasosA['steps'][$s-1]['nextDigit'] }}</span>
                                        @endif
                                    </td>
                                @endfor
                                {{-- Espacio debajo del divisor --}}
                                <td style="background:#fff;"></td>
                                @for($d=0; $d < strlen($divisorStrA); $d++)
                                    <td style="background:#fff;"></td>
                                @endfor
                            </tr>
                        @endfor
                    </table>
                    {{-- Solo se muestra la tabla cuadriculada con celdas visibles --}}
                    <div style="margin-bottom: 0.5em;">Resto final: <b>{{ $pasosA['residuo'] }}</b></div>
                @endif
                </td>
                @if($ejB && isset($pasosEjercicios[$i+1]) && $pasosEjercicios[$i+1] && isset($pasosEjercicios[$i+1]['steps']) && is_array($pasosEjercicios[$i+1]['steps']))
                    <td style="vertical-align:top; width:2%;"></td>
                    <td style="vertical-align:top; width:49%;">
                        @php $pasosB = $pasosEjercicios[$i+1]; $divisorStrB = strval($pasosB['divisor']); @endphp
                        {{-- JSON eliminado para mejor visualización --}}
                        {{-- Tabla cuadriculada de pasos, segura para mPDF --}}
                        <table class="cuadricula" style="margin-bottom:10px;">
                            <tr>
                                @for($d=0; $d < strlen($pasosB['dividendo']); $d++)
                                    <td style="font-weight:bold;">{{ $pasosB['dividendo'][$d] }}</td>
                                @endfor
                            </tr>
                            @foreach($pasosB['steps'] as $step)
                                @if(isset($step['index']) && is_numeric($step['index']) && $step['index'] >= 0 && $step['index'] < strlen($pasosB['dividendo']))
                                <tr>
                                    @for($d=0; $d < strlen($pasosB['dividendo']); $d++)
                                        <td>
                                            @if($d == $step['index'])
                                                @if(isset($step['nextDigit']) && $step['quotientDigit'] === 0 && $step['nextDigit'] !== null)
                                                    {{ $step['reach'] }}{{ $step['nextDigit'] }}
                                                @else
                                                    {{ $step['reach'] }}
                                                @endif
                                            @endif
                                        </td>
                                    @endfor
                                </tr>
                                @endif
                            @endforeach
                        </table>
                        {{-- Tabla cuadriculada de pasos eliminada temporalmente para depuración de error mPDF --}}
                        <div class="inciso-label">b)</div>
                        <table style="border-collapse:collapse;display:inline-table;vertical-align:middle;">
                            <tr>
                                @for($d=0; $d < strlen($pasosB['dividendo']); $d++)
                                    <td style="border:none;padding:2px 4px;text-align:center;font-family:monospace;font-size:1.2em;">{{ $pasosB['dividendo'][$d] }}</td>
                                @endfor
                                @for($d=0; $d < strlen($divisorStrB); $d++)
                                    <td style="border-left: {{ $d==0 ? '2px solid #000' : 'none' }}; border-bottom: 2px solid #000; padding:2px 4px;text-align:center;font-family:monospace;font-size:1.2em;">{{ $divisorStrB[$d] }}</td>
                                @endfor
                            </tr>
                            <tr>
                                @for($d=0; $d < strlen($pasosB['dividendo']); $d++)
                                    <td style="border:none;"></td>
                                @endfor
                                @for($d=0; $d < strlen($divisorStrB); $d++)
                                    <td style="border:none;text-align:center;font-family:monospace;font-size:1.1em; font-weight:bold;">{{ $pasosB['cociente'][$d] ?? '' }}</td>
                                @endfor
                            </tr>
                            @foreach($pasosB['steps'] as $step)
                            <tr>
                                @for($d=0; $d < strlen($pasosB['dividendo']); $d++)
                                    <td style="border:none;"></td>
                                @endfor
                                @for($d=0; $d < strlen($divisorStrB); $d++)
                                    <td style="border:none;text-align:center;font-family:monospace;font-size:1em; color:#26baa5;">@if($d == 0){{ $step['reach'] }}@endif</td>
                                @endfor
                            </tr>
                            @endforeach
                        </table>
                        <div style="margin-bottom: 0.5em;">Resto final: <b>{{ $pasosB['residuo'] }}</b></div>
                    </td>
                @endif
                {{-- Si no hay segundo ejercicio, no se genera columna ni celda separadora --}}
            </tr>
        </table>
        <hr style="border: none; border-top: 2px solid #888; margin: 18px 0 0 0;">
        @php $ejercicioNum++; @endphp
    @endfor
</body>
</html>
