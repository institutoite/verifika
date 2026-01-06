<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicios del Práctico</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/base.css') }}">
    <style>
        .card-header {
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            color: var(--text-light);
        }
        .table thead {
            background: var(--primary-color);
            color: #fff;
        }
        .btn-secondary {
            background: var(--secondary-color);
            border: none;
        }
        .btn-secondary:hover {
            background: var(--primary-color);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="/">Ejercicios Propuestos</a>
            <div class="ms-auto d-flex gap-2">
                <a href="{{ route('dashboard') }}" class="btn btn-outline-light">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">Cerrar sesión</button>
                </form>
            </div>
        </div>
    </nav>
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <div class="card shadow">
                    <div class="card-header text-center">
                        <h4 class="mb-0">Ejercicios de: {{ $practico->nombre }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Enunciado</th>
                                        <th>Operandos</th>
                                        <th>Respuesta</th>
                                        <th>Dificultad</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($practico->ejercicios as $i => $ejercicio)
                                    <tr>
                                        <td>{{ $i+1 }}</td>
                                        <td>{{ $ejercicio->enunciado }}</td>
                                        <td>
                                            @foreach($ejercicio->operandos as $op)
                                                {{ $op->valor }}@if(!$loop->last), @endif
                                            @endforeach
                                        </td>
                                        <td>{{ $ejercicio->respuesta }}</td>
                                        <td>{{ $ejercicio->grado }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <a href="{{ route('practicos.index') }}" class="btn btn-secondary mt-3">Volver a mis prácticos</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="text-center text-muted small py-3 mt-4">
        &copy; {{ date('Y') }} Ejercicios Propuestos
    </footer>
</body>
</html>
