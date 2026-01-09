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
                        <div class="inciso-label">a)</div>

                        @php
                            $divisorStrA = strval($pasosA['divisor']);
                            $divLenA = strlen($pasosA['dividendo']);
                            $st0 = $pasosA['steps'][0] ?? null;
                        @endphp

                        {{-- Encabezado + cociente + primera bajada en la misma fila del cociente --}}
                        <table class="cuadricula" style="margin-bottom:10px;">
                            {{-- FILA 0: Dividendo L Divisor --}}
                            <tr>
                                {{-- Dividendo --}}
                                @for($d=0; $d < $divLenA; $d++)
                                    <td style="font-weight:bold; background:#f2f2f2;">
                                        {{ $pasosA['dividendo'][$d] }}
                                    </td>
                                @endfor

                                {{-- "L" visual: línea vertical + divisor con borde inferior --}}
                                @for($d=0; $d < strlen($divisorStrA); $d++)
                                    <td style="background:#f2f2f2; font-weight:bold; border-left:{{ $d==0 ? '2px solid #000' : 'none' }}; border-bottom:2px solid #000;">
                                        {{ $divisorStrA[$d] }}
                                    </td>
                                @endfor
                            </tr>

                            {{-- FILA 1: reach del primer paso + PRIMERA BAJADA aquí + cociente debajo del divisor --}}
                            <tr>
                                {{-- Parte debajo del DIVIDENDO --}}
                                @for($d=0; $d < $divLenA; $d++)
                                    <td style="background:#fff; font-family:monospace; text-align:center;">
                                        @if($st0 && $d == $st0['index'])
                                            {{ $st0['reach'] }}
                                        @elseif($st0 && ($st0['bringDown'] ?? false) && ($st0['nextDigit'] ?? null) !== null && $d == $st0['index'] + 1)
                                            <span style="color:#007; font-weight:bold;">↓{{ $st0['nextDigit'] }}</span>
                                        @endif
                                    </td>
                                @endfor

                                {{-- Parte debajo del DIVISOR: Cociente --}}
                                @for($d=0; $d < strlen($pasosA['cociente']); $d++)
                                    <td style="background:#fff; font-family:monospace; font-size:1.2em; text-align:center; font-weight:bold;">
                                        {{ $pasosA['cociente'][$d] }}
                                    </td>
                                @endfor
                            </tr>

                            {{-- DESARROLLO: desde el paso 1 en adelante (solo reach, sin bajadas repetidas) --}}
                            @for($s=1; $s < count($pasosA['steps']); $s++)
                                @php $step = $pasosA['steps'][$s]; @endphp
                                <tr>
                                    @for($d=0; $d < $divLenA; $d++)
                                        <td style="background:#fff; font-family:monospace; text-align:center;">
                                            {{-- reach debajo del dígito actual --}}
                                            @if($d == $step['index'])
                                                {{ $step['reach'] }}
                                            {{-- bajada del siguiente dígito en la MISMA fila y en la MISMA columna correcta --}}
                                            @elseif(($step['bringDown'] ?? false) && ($step['nextDigit'] ?? null) !== null && $d == $step['index'] + 1)
                                                <span style="color:#007; font-weight:bold;">↓{{ $step['nextDigit'] }}</span>
                                            @endif
                                        </td>
                                    @endfor

                                    {{-- espacio debajo del divisor (mantener ancho) --}}
                                    @for($d=0; $d < strlen($divisorStrA); $d++)
                                        <td style="background:#fff;"></td>
                                    @endfor
                                </tr>
                            @endfor

                        </table>

                        <div style="margin-bottom: 0.5em;">
                            Resto final: <b>{{ $pasosA['residuo'] }}</b>
                        </div>
                    @endif

                </td>

                {{-- NO TOCO EL INCISO B para no romper tu layout actual --}}
                @if($ejB && isset($pasosEjercicios[$i+1]) && $pasosEjercicios[$i+1] && isset($pasosEjercicios[$i+1]['steps']) && is_array($pasosEjercicios[$i+1]['steps']))
                        <td style="vertical-align:top; width:2%;"></td>
                        <td style="vertical-align:top; width:49%;">
                            <div class="inciso-label">b)</div>
                            @php
                                $pasosB = $pasosEjercicios[$i+1] ?? null;
                                $divisorStrB = strval($pasosB['divisor']);
                                $divLenB = strlen($pasosB['dividendo']);
                                $st0b = $pasosB['steps'][0] ?? null;
                            @endphp

                            <table class="cuadricula" style="margin-bottom:10px;">
                                <tr>
                                    @for($d=0; $d < $divLenB; $d++)
                                        <td style="font-weight:bold; background:#f2f2f2;">
                                            {{ $pasosB['dividendo'][$d] }}
                                        </td>
                                    @endfor
                                    @for($d=0; $d < strlen($divisorStrB); $d++)
                                        <td style="background:#f2f2f2; font-weight:bold; border-left:{{ $d==0 ? '2px solid #000' : 'none' }}; border-bottom:2px solid #000;">
                                            {{ $divisorStrB[$d] }}
                                        </td>
                                    @endfor
                                </tr>
                                <tr>
                                    @for($d=0; $d < $divLenB; $d++)
                                        <td style="background:#fff; font-family:monospace; text-align:center;">
                                            @if($st0b && $d == $st0b['index'])
                                                {{ $st0b['reach'] }}
                                            @elseif($st0b && ($st0b['bringDown'] ?? false) && ($st0b['nextDigit'] ?? null) !== null && $d == $st0b['index'] + 1)
                                                <span style="color:#007; font-weight:bold;">↓{{ $st0b['nextDigit'] }}</span>
                                            @endif
                                        </td>
                                    @endfor
                                    @for($d=0; $d < strlen($pasosB['cociente']); $d++)
                                        <td style="background:#fff; font-family:monospace; font-size:1.2em; text-align:center; font-weight:bold;">
                                            {{ $pasosB['cociente'][$d] }}
                                        </td>
                                    @endfor
                                </tr>
                                @for($s=1; $s < count($pasosB['steps']); $s++)
                                    @php $stepB = $pasosB['steps'][$s]; @endphp
                                    <tr>
                                        @for($d=0; $d < $divLenB; $d++)
                                            <td style="background:#fff; font-family:monospace; text-align:center;">
                                                @if($d == $stepB['index'])
                                                    {{ $stepB['reach'] }}
                                                @elseif(($stepB['bringDown'] ?? false) && ($stepB['nextDigit'] ?? null) !== null && $d == $stepB['index'] + 1)
                                                    <span style="color:#007; font-weight:bold;">↓{{ $stepB['nextDigit'] }}</span>
                                                @endif
                                            </td>
                                        @endfor
                                        @for($d=0; $d < strlen($divisorStrB); $d++)
                                            <td style="background:#fff;"></td>
                                        @endfor
                                    </tr>
                                @endfor
                            </table>
                            <div style="margin-bottom: 0.5em;">
                                Resto final: <b>{{ $pasosB['residuo'] }}</b>
                            </div>
                        </td>
                @endif
            </tr>
        </table>

        <hr style="border: none; border-top: 2px solid #888; margin: 18px 0 0 0;">

        @php $ejercicioNum++; @endphp
    @endfor
</body>
</html>
