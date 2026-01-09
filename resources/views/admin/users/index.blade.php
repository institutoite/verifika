@extends('layouts.app')

@section('content')
<div class="container py-3">
    <h3 class="mb-3">Administración: Usuarios</h3>
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Prácticos</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $i => $u)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $u->name }}</td>
                <td>{{ $u->email }}</td>
                <td>{{ $u->phone }}</td>
                <td>{{ $u->practicos_count }}</td>
                <td>
                    <a href="{{ route('admin.users.show', $u->id) }}" class="btn btn-sm btn-primary">Ver detalle</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
