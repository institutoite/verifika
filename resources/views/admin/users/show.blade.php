@extends('layouts.app')

@section('content')
<div class="container py-3">
    <h3 class="mb-2">Usuario: {{ $user->name }}</h3>
    <p class="text-muted mb-3">{{ $user->email }} | {{ $user->phone }}</p>

    <h5>Prácticos</h5>
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Fecha</th>
                <th>Ejercicios</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($user->practicos as $i => $p)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $p->nombre }}</td>
                <td>{{ $p->fecha ?? $p->created_at }}</td>
                <td>{{ $p->ejercicios_count ?? $p->ejercicios()->count() }}</td>
                <td>
                    <a href="{{ route('practicos.ejercicios', $p->id) }}" class="btn btn-sm btn-success">Ver ejercicios</a>
                    <a href="{{ route('practicos.imprimir', ['id' => $p->id, 'tipo' => 'propuestos']) }}" target="_blank" class="btn btn-sm btn-primary">PDF propuestos</a>
                    <a href="{{ route('practicos.imprimir', ['id' => $p->id, 'tipo' => 'respuestas']) }}" target="_blank" class="btn btn-sm btn-secondary">PDF respuestas</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
