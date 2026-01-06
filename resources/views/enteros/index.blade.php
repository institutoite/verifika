
@extends('adminlte::page')

@section('title', 'Resta')

@section('css')

@stop
@section('content')
<div class="container">
    <h1>Ejercicios de Números Enteros</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif


    <form action="{{ route('ejercicios.generate.pdf') }}" method="POST" style="margin-top: 20px;">
        @csrf
        <div class="form-group">
            <label for="nivel_pdf">Seleccione el Nivel para PDF:</label>
            <select name="nivel" id="nivel_pdf" class="form-control">
                <option value="1">Nivel 1: Dos números positivos</option>
                <option value="2">Nivel 2: Dos números negativos</option>
                <option value="3">Nivel 3: Signos contrarios (+ mayor)</option>
                <option value="4">Nivel 4: Signos contrarios (- mayor)</option>
                <option value="5">Nivel 5: Combinados (más de tres números)</option>
                <option value="6">Nivel 6: Mezcla de todos los niveles</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Generar PDF</button>
    </form>

    <h2>Lista de Ejercicios Generados</h2>
    <ul>
        @foreach($ejercicios as $ejercicio)
            <li>{{ $ejercicio->descripcion }} 
                <form action="{{ route('ejercicios.destroy', $ejercicio->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                </form>
            </li>
        @endforeach
    </ul>
</div>
@endsection
