<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Práctico PDF</title>

    <style>
        @page { margin: 2cm; } /* Márgenes de 2cm en PDF */

        :root {
            --primary-color: rgb(38,186,165);
            --secondary-color: rgb(55,95,122);
            --text-light: #fff;
        }

        html, body { margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; }

        /* 🔴 Evitar FLEX en PDF: mejor tabla/bloques */
        .membrete {
            width: 100%;
            margin: 0 0 8px 0;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            color: var(--text-light);
            padding: 10px 12px;
            box-sizing: border-box;
        }

        .membrete-table {
            width: 100%;
            border-collapse: collapse;
        }

        .membrete-table td {
            border: none;
            vertical-align: middle;
            padding: 0;
        }

        .membrete-title {
            font-size: 14px;
            font-weight: bold;
            white-space: nowrap;
        }

        .membrete-info {
            font-size: 12px;
            padding-left: 12px;
            white-space: nowrap;
        }

        .membrete-redes {
            text-align: right;
            white-space: nowrap;
        }

        .membrete-redes a {
            text-decoration: none;
            display: inline-block;
            width: 18px;
            height: 18px;
            margin-left: 6px;
            background: #fff;
            border-radius: 50%;
            line-height: 18px;
            text-align: center;
        }

        .membrete-redes svg {
            width: 12px;
            height: 12px;
            vertical-align: middle;
        }

        .membrete-redes .svg-facebook { color: #3b5998; }
        .membrete-redes .svg-instagram { color: #e1306c; }
        .membrete-redes .svg-whatsapp { color: #25d366; }
        .membrete-redes .svg-tiktok { color: #010101; }

        h2 {
            color: var(--primary-color);
            margin: 6px 0 10px 0;
            font-size: 16px;
        }

        /* ✅ NO uses avoid en todo el ejercicio (causa páginas en blanco) */
        .ejercicio {
            margin: 0 0 14px 0;
            page-break-inside: auto;
        }

        .grado { font-size: 11px; color: #888; }

        .suma-matriz {
            border-collapse: collapse;
            margin: 6px auto;
            page-break-inside: auto;
        }

        .suma-matriz tr { page-break-inside: avoid; } /* ✅ Evitar cortar FILAS */
        .suma-matriz td {
            border: none;
            width: 26px;
            height: 26px;
            text-align: center;
            font-size: 22px;
            padding: 2px 4px;
            background: #fff;
        }

        .suma-matriz .borde-suma { border-bottom: 2px solid rgb(38,186,165) !important; }
        .suma-matriz .signo { 
            font-weight: bold;
            color: rgb(38,186,165);
            font-size: 18px;
         }

        .inciso-label {
            font-weight: bold;
            font-size: 12px;
            text-align: center;
            background: transparent;
        }

        .respuesta {
            color: var(--secondary-color);
            font-weight: bold;
            font-size: 20px;
            text-align: center;
            margin-top: 4px;
        }

        .incisos-col { display: block; }
        .inciso { margin-bottom: 10px; }

        /* Footer normal (sin reglas raras) */
        .footer-pdf {
            width: 100%;
            margin-top: 14px;
            padding: 10px 8px;
            background: linear-gradient(90deg, var(--secondary-color), var(--primary-color));
            color: var(--text-light);
            text-align: center;
            font-size: 12px;
            box-sizing: border-box;
        }

        /* CSS SOLO del membrete (clases nuevas) */
        .pdf-membrete{
        width: 100%;
        background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
        color: var(--text-light);
        /* Ajustes para círculo blanco detrás del logo */
        .pdf-membrete__right{ width: 66px; text-align: right; vertical-align: top; }
        .pdf-membrete__logo-wrap{ display: inline-block; background:#eef9ff; border:1px solid #cfe8f2; border-radius:50%; width:44px; height:44px; padding:4px; box-sizing:border-box; overflow:hidden; }
        .pdf-membrete__logo{ display:block; margin:0 auto; padding:0; border:0; vertical-align:middle; width:31px; height:31px; }
        border-radius: 1.2em 1.2em 0 0;
        margin: 0 0 6px 0;
        border-spacing: 0;
        border-collapse: collapse;
        }

        .pdf-membrete__row{ }

        .pdf-membrete__left{
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

        .pdf-membrete__icons{
        margin-top: 6px;
        line-height: 1;
        }

        .pdf-membrete__right{
        width: 80px;
        text-align: right;
        vertical-align: top;
        padding: 6px 8px 0 0; /* baja a 0 si lo quieres más pegado arriba */
        font-size: 0;         /* elimina espacio fantasma */
        line-height: 0;       /* elimina espacio fantasma */
        }

        .pdf-membrete__logo{
        display: block;
        margin: 0;
        padding: 0;
        border: 0;
        vertical-align: top;
        height: 44px;      /* ajusta tamaño */
        width: auto;
        max-width: 80px;
        }

    </style>
</head>

<body>
    {{-- MEMBRETE (UNA SOLA VEZ) --}}
    <table class="pdf-membrete">
  <tr class="pdf-membrete__row">

    <!-- Texto a la izquierda -->
    <td class="pdf-membrete__left">
      <div class="pdf-membrete__title">Ejercicios Propuestos</div>

      <div class="pdf-membrete__info">
        Ningún niño fracasa por falta de capacidad, 
        &nbsp; | &nbsp; <span class="pdf-membrete__email"> Escríbeme:+59171324941</span>
      </div>
    </td>

    <!-- Logo arriba a la derecha (SIN ESPACIOS) -->
        <td class="pdf-membrete__right">
            <div class="pdf-membrete__logo-wrap">
                <img
                    class="pdf-membrete__logo"
                    src="{{ public_path('images/logo.png') }}"
                    alt="Logo"
                    width="31"
                    height="31"
                >
            </div>
        </td>

  </tr>
  
</table>

    <h2>Práctico: {{ $practico->nombre }}</h2>

    {{-- LOOP PRINCIPAL --}}
    @for($i = 0; $i < count($practico->ejercicios); $i += 2)
        @php
            $ejA = $practico->ejercicios[$i] ?? null;
            $ejB = $practico->ejercicios[$i+1] ?? null;

            $operandosA = $ejA ? $ejA->operandos : [];
            $operandosB = $ejB ? $ejB->operandos : [];

            $respuestaA = $ejA->respuesta ?? '';
            $respuestaB = $ejB->respuesta ?? '';

            $maxDigitosA = 0; $maxDigitosB = 0;
            foreach($operandosA as $op) { $maxDigitosA = max($maxDigitosA, strlen((string)$op->valor)); }
            foreach($operandosB as $op) { $maxDigitosB = max($maxDigitosB, strlen((string)$op->valor)); }
            $maxDigitosA = max($maxDigitosA, strlen((string)$respuestaA));
            $maxDigitosB = max($maxDigitosB, strlen((string)$respuestaB));

            $n = max(count($operandosA), count($operandosB));
            $filaSignoA = intdiv(count($operandosA),2);
            $filaSignoB = intdiv(count($operandosB),2);
            $usarVertical = ($maxDigitosA > 6 || $maxDigitosB > 6);
        @endphp

        <div class="ejercicio">
            <div>
                <strong>Ejercicio {{ intdiv($i,2)+1 }}</strong>
                <span class="grado">[{{ $practico->ejercicios[$i]->grado ?? '' }}]</span>
            </div>

            @if($tipo === 'respuestas')
                <div class="respuesta">a) {{ $respuestaA }} &nbsp;&nbsp; b) {{ $respuestaB }}</div>

            @elseif(!$usarVertical)
                <table class="suma-matriz">
                    <tr>
                        <td colspan="{{ 1 + $maxDigitosA }}" class="inciso-label">a)</td>
                        <td style="width:20px;"></td>
                        <td colspan="{{ 1 + $maxDigitosB }}" class="inciso-label">b)</td>
                    </tr>

                    @for($row = 0; $row < $n; $row++)
                        <tr>
                            {{-- a) --}}
                            @if($row < count($operandosA))
                                <td class="{{ $row == $filaSignoA ? 'signo' : '' }}">
                                    @if($row == $filaSignoA)
                                        @if($ejA && $ejA->tipo === 'multiplicacion')
                                            x
                                        @elseif($ejA && $ejA->tipo === 'resta')
                                            -
                                        @else
                                            +
                                        @endif
                                    @endif
                                </td>
                                @php $digitosA = str_pad($operandosA[$row]->valor, $maxDigitosA, ' ', STR_PAD_LEFT); @endphp
                                @for($d = 0; $d < $maxDigitosA; $d++)
                                    <td @if($row == $n-1) class="borde-suma" @endif>{{ $digitosA[$d] }}</td>
                                @endfor
                            @else
                                @for($d = 0; $d < 1 + $maxDigitosA; $d++) <td></td> @endfor
                            @endif

                            <td></td>

                            {{-- b) --}}
                            @if($row < count($operandosB))
                                <td class="{{ $row == $filaSignoB ? 'signo' : '' }}">
                                    @if($row == $filaSignoB)
                                        @if($ejB && $ejB->tipo === 'multiplicacion')
                                            x
                                        @elseif($ejB && $ejB->tipo === 'resta')
                                            -
                                        @else
                                            +
                                        @endif
                                    @endif
                                </td>
                                @php $digitosB = str_pad($operandosB[$row]->valor, $maxDigitosB, ' ', STR_PAD_LEFT); @endphp
                                @for($d = 0; $d < $maxDigitosB; $d++)
                                    <td @if($row == $n-1) class="borde-suma" @endif>{{ $digitosB[$d] }}</td>
                                @endfor
                            @else
                                @for($d = 0; $d < 1 + $maxDigitosB; $d++) <td></td> @endfor
                            @endif
                        </tr>
                    @endfor

                    @if($tipo === 'ambos')
                        {{-- Mostrar respuestas justo debajo de cada ejercicio, sin filas vacías ni espacios extra --}}
                        <tr>
                            {{-- Respuesta a) debajo del ejercicio a) --}}
                            <td></td>
                            @php $resA = str_pad($respuestaA, $maxDigitosA, ' ', STR_PAD_LEFT); @endphp
                            @for($d = 0; $d < $maxDigitosA; $d++) <td class="respuesta">{{ $resA[$d] }}</td> @endfor
                            <td></td>
                            {{-- Respuesta b) debajo del ejercicio b) --}}
                            <td></td>
                            @php $resB = str_pad($respuestaB, $maxDigitosB, ' ', STR_PAD_LEFT); @endphp
                            @for($d = 0; $d < $maxDigitosB; $d++) <td class="respuesta">{{ $resB[$d] }}</td> @endfor
                        </tr>
                    @endif
                </table>

            @else
                <div class="incisos-col">
                    @foreach([
                        ['inciso'=>'a','ej'=>$ejA,'maxDigitos'=>$maxDigitosA],
                        ['inciso'=>'b','ej'=>$ejB,'maxDigitos'=>$maxDigitosB]
                    ] as $data)

                        @php
                            $inciso = $data['inciso'];
                            $ej = $data['ej'];
                            $operandos = $ej ? $ej->operandos : [];
                            $respuesta = $ej->respuesta ?? '';
                            $maxDigitos = max($data['maxDigitos'], strlen((string)$respuesta));
                            $nLocal = count($operandos);
                            $filaSigno = intdiv($nLocal, 2);
                        @endphp

                        <div class="inciso">
                            @if($tipo === 'respuestas')
                                @if($ej && $ej->tipo === 'division')
                                    <div class="respuesta">{{ $inciso }}) Cociente: {{ $ej->cociente }}, Resto: {{ $ej->resto }}</div>
                                @else
                                    <div class="respuesta">{{ $inciso }}) {{ $respuesta }}</div>
                                @endif
                            @else
                                <span class="inciso-label">{{ $inciso }})</span>
                                <table class="suma-matriz">
                                    @foreach($operandos as $j => $op)
                                        <tr>
                                            <td class="{{ $j == $filaSigno ? 'signo' : '' }}">
                                                @if($j == $filaSigno)
                                                    @if($ej && $ej->tipo === 'multiplicacion')
                                                        x
                                                    @elseif($ej && $ej->tipo === 'resta')
                                                        -
                                                    @else
                                                        +
                                                    @endif
                                                @endif
                                            </td>
                                            @php $digitos = str_pad($op->valor, $maxDigitos, ' ', STR_PAD_LEFT); @endphp
                                            @for($d = 0; $d < $maxDigitos; $d++)
                                                <td @if($j == $nLocal-1) class="borde-suma" @endif>{{ $digitos[$d] }}</td>
                                            @endfor
                                        </tr>
                                    @endforeach

                                    @if($tipo === 'ambos')
                                        <tr>
                                            <td></td>
                                            @php $res = str_pad($respuesta, $maxDigitos, ' ', STR_PAD_LEFT); @endphp
                                            @for($d = 0; $d < $maxDigitos; $d++)
                                                <td class="respuesta">{{ $res[$d] }}</td>
                                            @endfor
                                        </tr>
                                    @endif
                                </table>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @endfor

    <div class="footer-pdf">
        <div>
            <strong>Clases :</strong> +59171324941 &nbsp; | &nbsp;
            <strong>Otros servicios:</strong> +59175553338 &nbsp; | &nbsp;
            <strong>Facebook:</strong> <a href="https://facebook.com/ite_educabol" target="_blank">/ite_educabol</a> &nbsp; | &nbsp;
            <strong>Instagram:</strong> <a href="https://instagram.com/ite_educabol" target="_blank">@ite_educabol</a> &nbsp; | &nbsp;
            <strong>YouTube:</strong> <a href="https://youtube.com/@@ite_educabol" target="_blank">@ite_educabol</a> &nbsp; | &nbsp;
            <strong>TikTok:</strong> <a href="https://tiktok.com/@ite_educabol" target="_blank">@ite_educabol</a> &nbsp; | &nbsp;
            <strong>Web:</strong> <a href="https://ite.com.bo" target="_blank">ite.com.bo</a>
        </div>
        <div style="margin-top:4px;">
            <a href="https://facebook.com/ite_educabol" target="_blank" title="Facebook">
                <svg class="svg-facebook" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" style="width:16px;height:16px;"><path fill="currentColor" d="M279.14 288l14.22-92.66h-88.91V127.91c0-25.35 12.42-50.06 52.24-50.06H293V6.26S259.5 0 225.36 0c-73.22 0-121 44.38-121 124.72v70.62H22.89V288h81.47v224h100.2V288z"/></svg>
            </a>
            <a href="https://instagram.com/ite_educabol" target="_blank" title="Instagram">
                <svg class="svg-instagram" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" style="width:16px;height:16px;"><path fill="currentColor" d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9 114.9-51.3 114.9-114.9S287.7 141 224.1 141zm0 186c-39.5 0-71.5-32-71.5-71.5s32-71.5 71.5-71.5 71.5 32 71.5 71.5-32 71.5-71.5 71.5zm146.4-194.3c0 14.9-12 26.9-26.9 26.9s-26.9-12-26.9-26.9 12-26.9 26.9-26.9 26.9 12 26.9 26.9zm76.1 27.2c-1.7-35.3-9.9-66.7-36.2-92.1S388.6 7.7 353.3 6C317.7 4.3 256.3 0 224 0s-93.7 4.3-129.3 6C59.4 7.7 28 15.9 2.7 41.2S7.7 59.4 6 94.7C4.3 130.3 0 191.7 0 224s4.3 93.7 6 129.3c1.7 35.3 9.9 66.7 36.2 92.1s56.8 34.5 92.1 36.2C130.3 507.7 191.7 512 224 512s93.7-4.3 129.3-6c35.3-1.7 66.7-9.9 92.1-36.2s34.5-56.8 36.2-92.1c1.7-35.6 6-97 6-129.3s-4.3-93.7-6-129.3z"/></svg>
            </a>
            <a href="https://youtube.com/@@ite_educabol" target="_blank" title="YouTube">
                <svg class="svg-youtube" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" style="width:16px;height:16px;"><path fill="currentColor" d="M549.655 124.083c-6.281-23.725-24.958-42.401-48.684-48.684C458.281 64 288 64 288 64s-170.281 0-212.971 11.399c-23.726 6.283-42.403 24.959-48.684 48.684C16 166.773 16 256 16 256s0 89.227 10.345 131.917c6.281 23.725 24.958 42.401 48.684 48.684C117.719 448 288 448 288 448s170.281 0 212.971-11.399c23.726-6.283 42.403-24.959 48.684-48.684C560 345.227 560 256 560 256s0-89.227-10.345-131.917zM232 336V176l142.857 80L232 336z"/></svg>
            </a>
            <a href="https://tiktok.com/@ite_educabol" target="_blank" title="TikTok">
                <svg class="svg-tiktok" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" style="width:16px;height:16px;"><path fill="currentColor" d="M448,209.9v125.1c0,97.2-78.8,176-176,176S96,432.2,96,335z"/></svg>
            </a>
            <a href="https://ite.com.bo" target="_blank" title="Página Web">
                <svg class="svg-web" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512" style="width:16px;height:16px;"><path fill="currentColor" d="M248 8C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zm0 48c110.5 0 200 89.5 200 200 0 110.5-89.5 200-200 200C137.5 456 48 366.5 48 256 48 145.5 137.5 56 248 56zm0 40c-88.2 0-160 71.8-160 160 0 88.2 71.8 160 160 160 88.2 0 160-71.8 160-160 0-88.2-71.8-160-160-160zm0 32c70.7 0 128 57.3 128 128s-57.3 128-128 128-128-57.3-128-128 57.3-128 128-128z"/></svg>
            </a>
        </div>
    </div>

</body>
</html>
