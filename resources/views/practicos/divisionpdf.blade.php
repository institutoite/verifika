<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Divisiones - Ejercicios Propuestos</title>
    <style>
        @page { margin: 2cm; }
        :root {
            --primary-color: rgb(38,186,165);
            --secondary-color: rgb(55,95,122);
            --text-light: #fff;
                            /* Lógica blade eliminada: no debe haber uso de $ejB en el CSS */
            vertical-align: top;
            padding: 8px 10px;
        }
        .pdf-membrete__title{
            font-size: 1.5em;
            font-weight: bold;
            margin: 0;
            padding: 0;
            line-height: 1.1;
        }
        .pdf-membrete__info{
            font-size: 1.05em;
            margin: 4px 0 0 0;
            padding: 0;
            line-height: 1.2;
        }
        .pdf-membrete__email{
            font-size: 0.95em;
        }
        .pdf-membrete__right{
            width: 80px;
            text-align: right;
            vertical-align: top;
            padding: 6px 8px 0 0;
            font-size: 0;
            line-height: 0;
        }
        .pdf-membrete__logo{
            display: block;
            margin: 0;
            padding: 0;
            border: 0;
            vertical-align: top;
            height: 44px;
            width: auto;
            max-width: 80px;
        }
        .ej-titulo {
            font-size: 1.1em;
            font-weight: bold;
            margin: 18px 0 4px 0;
        }
        .ej-grado {
            font-size: 0.95em;
            color: #888;
            margin-left: 8px;
        }
        .matriz-division {
            border-collapse: collapse;
            margin-bottom: 18px;
        }
        .matriz-division td {
            border: none;
            padding: 2px 4px;
            text-align: right;
            font-size: 1.1em;
        }
        .respuesta { color: #26baa5; font-weight: bold; }
        .inciso-label { font-weight: bold; text-align: left; padding-right: 8px; }
        .hr-op { border: none; border-bottom: 2px solid #26baa5; height: 0; margin: 2px 0; }
    </style>
</head>
<body>
    <!-- MEMBRETE -->
    <table class="pdf-membrete">
      <tr>
        <td class="pdf-membrete__left">
          <div class="pdf-membrete__title">Ejercicios Propuestos</div>
          <div class="pdf-membrete__info">
            Ningún niño fracasa por falta de capacidad,
            &nbsp; | &nbsp; <span class="pdf-membrete__email"> Escríbeme:+59171324941</span>
          </div>
        </td>
        <td class="pdf-membrete__right">
          <img class="pdf-membrete__logo" src="{{ public_path('images/logo.png') }}" alt="Logo">
        </td>
      </tr>
    </table>


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
            @if($ejA && $ejA->tipo === 'division' && isset($ejA->operandos[0]) && isset($ejA->operandos[1]))
                <table class="matriz-division">
                    <tr>
                        <td class="inciso-label">a)</td>
                        <td>
                            @php
                                $dividendo = $ejA->operandos[0]->valor ?? '';
                                $divisor = $ejA->operandos[1]->valor ?? '';
                            @endphp
                            @php
                                $dividendoStr = strval($dividendo);
                                $divisorStr = strval($divisor);
                                $dividendoLen = strlen($dividendoStr);
                                $divisorLen = strlen($divisorStr);
                                $totalLen = $dividendoLen + $divisorLen;
                            @endphp
                            <table style="border-collapse:collapse;display:inline-table;vertical-align:middle;">
                                <tr>
                                    {{-- Dividendo --}}
                                    @for($d=0; $d<$dividendoLen; $d++)
                                        <td style="border:none;padding:2px 4px;text-align:center;font-family:monospace;font-size:1.2em;">{{ $dividendoStr[$d] }}</td>
                                    @endfor
                                    {{-- Divisor con L --}}
                                    @for($d=0; $d<$divisorLen; $d++)
                                        <td style="
                                            border-left: {{ $d==0 ? '2px solid #000' : 'none' }};
                                            border-bottom: 2px solid #000;
                                            padding:2px 4px;text-align:center;font-family:monospace;font-size:1.2em;">
                                            {{ $divisorStr[$d] }}
                                        </td>
                                    @endfor
                                </tr>
                            </table>
                        </td>
                    </tr>
                    @if(isset($tipo) && ($tipo === 'respuestas' || $tipo === 'ambos'))
                    <tr>
                        <td colspan="2" class="respuesta">Cociente: {{ $ejA->cociente }}, Resto: {{ $ejA->resto }}</td>
                    </tr>
                    @endif
                </table>
            @endif
            </td>
            <td style="vertical-align:top; width:2%;"></td>
            <td style="vertical-align:top; width:49%;">
            @if(isset($ejB) && $ejB && $ejB->tipo === 'division' && isset($ejB->operandos[0]) && isset($ejB->operandos[1]))
                <table class="matriz-division">
                    <tr>
                        <td class="inciso-label">b)</td>
                        <td>
                            @php
                                $dividendo = $ejB->operandos[0]->valor ?? '';
                                $divisor = $ejB->operandos[1]->valor ?? '';
                                $dividendoStr = strval($dividendo);
                                $divisorStr = strval($divisor);
                                $dividendoLen = strlen($dividendoStr);
                                $divisorLen = strlen($divisorStr);
                                $totalLen = $dividendoLen + $divisorLen;
                            @endphp
                            <table style="border-collapse:collapse;display:inline-table;vertical-align:middle;">
                                <tr>
                                    {{-- Dividendo --}}
                                    @for($d=0; $d<$dividendoLen; $d++)
                                        <td style="border:none;padding:2px 4px;text-align:center;font-family:monospace;font-size:1.2em;">{{ $dividendoStr[$d] }}</td>
                                    @endfor
                                    {{-- Divisor con L --}}
                                    @for($d=0; $d<$divisorLen; $d++)
                                        <td style="
                                            border-left: {{ $d==0 ? '2px solid #000' : 'none' }};
                                            border-bottom: 2px solid #000;
                                            padding:2px 4px;text-align:center;font-family:monospace;font-size:1.2em;">
                                            {{ $divisorStr[$d] }}
                                        </td>
                                    @endfor
                                </tr>
                            </table>
                        </td>
                    </tr>
                    @if(isset($tipo) && ($tipo === 'respuestas' || $tipo === 'ambos'))
                    <tr>
                        <td colspan="2" class="respuesta">Cociente: {{ $ejB->cociente }}, Resto: {{ $ejB->resto }}</td>
                    </tr>
                    @endif
                </table>
            @endif
            </td>
        </tr>
    </table>
    <hr style="border: none; border-top: 2px solid #888; margin: 18px 0 0 0;">
    @php $ejercicioNum++; @endphp
@endfor

</body>
</html>
