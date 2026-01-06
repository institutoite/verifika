<!DOCTYPE html>
<html lang="es">
<head>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Prácticos - Ejercicios Propuestos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/base.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
                /* Efecto cebra suave */
                .table-striped tbody tr:nth-of-type(odd) {
                    background-color: rgba(38,186,165,0.07);
                }
                .table-striped tbody tr:nth-of-type(even) {
                    background-color: rgba(55,95,122,0.04);
                }
                /* Efecto hover */
                .table-hover tbody tr:hover {
                    background-color: rgba(38,186,165,0.18) !important;
                    transition: background 0.2s;
                }
        :root {
            --primary-color: rgb(38,186,165);
            --secondary-color: rgb(55,95,122);
            --accent-color: rgb(55,95,122);
            --primary-light: rgba(38,186,165,0.18);
            --secondary-light: rgba(55,95,122,0.18);
            --accent-light: rgba(55,95,122,0.10);
            --text-light: #fff;
        }
        .card-header {
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            color: var(--text-light) !important;
        }
        .table thead th {
            background: var(--primary-light);
            color: var(--accent-color);
            border-bottom: 2px solid var(--primary-color);
        }
        .table-bordered > :not(caption) > * > td {
            border-color: var(--primary-color);
        }
        .btn-success {
            background: var(--primary-color);
            border: none;
        }
        .btn-success:hover {
            background: var(--primary-light);
            color: var(--secondary-color);
        }
        .btn-primary {
            background: var(--secondary-color);
            border: none;
        }
        .btn-primary:hover {
            background: var(--secondary-light);
            color: var(--text-light);
        }
        .btn-secondary {
            background: var(--accent-color);
            border: none;
        }
        .btn-secondary:hover {
            background: var(--accent-light);
            color: var(--primary-color);
        }
        .btn-info {
            background: var(--primary-light);
            color: var(--accent-color);
            border: none;
        }
        .btn-info:hover {
            background: var(--primary-color);
            color: var(--text-light);
        }
        .btn-warning {
            background: #ffe082;
            color: var(--secondary-color);
            border: none;
        }
        .btn-warning:hover {
            background: #ffd54f;
            color: var(--secondary-color);
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
    <div class="container py-5">
        <div class="card mt-5">
            <div class="card-header bg-info text-white">
                <h4 class="text-center">Mis Prácticos</h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th class="d-none d-md-table-cell">Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($practicos as $i => $practico)
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td>{{ $practico->nombre }}</td>
                            <td class="d-none d-md-table-cell">{{ $practico->fecha }}</td>
                            <td class="d-flex flex-wrap gap-1">
                                <a href="{{ route('practicos.ejercicios', $practico->id) }}" class="btn btn-success btn-sm" title="Ver ejercicios">
                                    <span class="bi bi-list-ul"></span>
                                </a>
                                <a href="{{ route('practicos.imprimir', ['id' => $practico->id, 'tipo' => 'propuestos']) }}" class="btn btn-primary btn-sm" target="_blank" title="Imprimir propuestos">
                                    <span class="bi bi-printer"></span>
                                </a>
                                <a href="{{ route('practicos.imprimir', ['id' => $practico->id, 'tipo' => 'respuestas']) }}" class="btn btn-secondary btn-sm" target="_blank" title="Imprimir respuestas">
                                    <span class="bi bi-clipboard-check"></span>
                                </a>
                                @php
                                    $esMultiplicacion = $practico->ejercicios->first() && $practico->ejercicios->first()->tipo === 'multiplicacion';
                                @endphp
                                <a href="{{ route('practicos.imprimir', ['id' => $practico->id, 'tipo' => $esMultiplicacion ? 'multiplicacion' : 'ambos']) }}" class="btn btn-info btn-sm" target="_blank" title="Imprimir ambos">
                                    <span class="bi bi-files"></span>
                                </a>
                                <a href="{{ route('practicos.edit', $practico->id) }}" class="btn btn-warning btn-sm" title="Editar">
                                    <span class="bi bi-pencil-square"></span>
                                </a>
                                <form action="{{ route('practicos.destroy', $practico->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm btn-eliminar" title="Eliminar">
                                        <span class="bi bi-trash"></span>
                                    </button>
                                </form>
                            </head>
                                <!-- Bootstrap Icons -->
                                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <script>
                    document.querySelectorAll('.btn-eliminar').forEach(function(btn) {
                        btn.addEventListener('click', function(e) {
                            e.preventDefault();
                            const form = btn.closest('form');
                            Swal.fire({
                                title: '¿Estás seguro?',
                                text: '¡Esta acción no se puede deshacer!',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#26baa5',
                                cancelButtonColor: '#375f7a',
                                confirmButtonText: 'Sí, eliminar',
                                cancelButtonText: 'Cancelar'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    form.submit();
                                }
                            });
                        });
                    });
                </script>
            </div>
        </div>
    </div>
    <footer class="text-center text-muted small py-3 mt-4">
        &copy; {{ date('Y') }} Ejercicios Propuestos
    </footer>
</body>
</html>
