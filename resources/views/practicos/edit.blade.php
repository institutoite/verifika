<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Práctico</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/base.css') }}">
    <style>
        .form-card {
            border: 2px solid var(--primary-color);
            border-radius: 1.5rem;
            box-shadow: 0 4px 16px rgba(38,186,165,0.10);
            background: #fff;
        }
        .form-card .card-header {
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            color: var(--text-light);
            border-radius: 1.5rem 1.5rem 0 0;
        }
        .form-label {
            color: var(--secondary-color);
            font-weight: 500;
        }
        .btn-primary {
            background: var(--primary-color);
            border: none;
        }
        .btn-primary:hover {
            background: var(--secondary-color);
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card form-card">
                    <div class="card-header text-center">
                        <h4 class="mb-0">Editar Práctico</h4>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('practicos.update', $practico->id) }}" method="POST">
                                                        @if ($errors->any())
                                                            <div class="alert alert-danger">
                                                                <ul class="mb-0">
                                                                    @foreach ($errors->all() as $error)
                                                                        <li>{{ $error }}</li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        @endif
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $practico->nombre) }}" required>
                                @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                          
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">Guardar cambios</button>
                                <a href="{{ route('practicos.index') }}" class="btn btn-secondary mt-2">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
