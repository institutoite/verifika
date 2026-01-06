
@extends('adminlte::page')

@section('title', 'Resta')

@section('css')

@stop

@section('content')
<h1>Crear nuevo ejercicio</h1>

@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form action="{{ route('ejercicios.store') }}" method="POST">
    @csrf
    <label for="enunciado">Enunciado:</label>
    <input type="text" id="enunciado" name="enunciado" required>
    <br>

    <label for="solucion">Solución:</label>
    <input type="number" id="solucion" name="solucion" required>
    <br>

    <button type="submit">Crear</button>
</form>
@stop



@section('js')
    <script> console.log('Hi!'); </script>
@stop

