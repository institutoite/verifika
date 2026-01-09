<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imprimir Práctico</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/base.css') }}">
    <style>
        @media print {
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Práctico: {{ $practico->nombre }}</h3>
            <button class="btn btn-primary no-print" onclick="window.print()">Imprimir</button>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Enunciado</th>
                    @if($tipo === 'propuestos' || $tipo === 'ambos')
                        <th>Operandos</th>
                    @endif
                    @if($tipo === 'respuestas' || $tipo === 'ambos')
                        <th>Respuesta</th>
                    @endif
                    <th>Dificultad</th>
                </tr>
            </thead>
            <tbody>
                @foreach($practico->ejercicios as $i => $ejercicio)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{!! $ejercicio->enunciado !!}</td>
                    @if($tipo === 'propuestos' || $tipo === 'ambos')
                        <td>
                            @foreach($ejercicio->operandos as $op)
                                {{ $op->valor }}@if(!$loop->last), @endif
                            @endforeach
                        </td>
                    @endif
                    @if($tipo === 'respuestas' || $tipo === 'ambos')
                        <td>
                            @if($ejercicio->tipo === 'division')
                                Cociente: {{ $ejercicio->cociente }}, Resto: {{ $ejercicio->resto }}
                            @else
                                {{ $ejercicio->respuesta }}
                            @endif
                        </td>
                    @endif
                    <td>{{ $ejercicio->grado }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{ route('practicos.index') }}" class="btn btn-secondary mt-3 no-print">Volver a mis prácticos</a>
    </div>
</body>
</html>
