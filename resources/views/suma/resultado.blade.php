@extends('adminlte::page')

@section('title', 'Sumas Generadas')

@section('content')
<div class="card mt-5">
    <div class="card-header bg-success">
        <h4 class="text-center">SUMAS GENERADAS</h4>
        @isset($practico)
            <h5 class="text-center">{{ $practico->nombre }}</h5>
        @endisset
    </div>
    <div class="card-body">
        <table class="table table-bordered">
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
                @foreach($ejercicios as $i => $ejercicio)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $ejercicio->enunciado }}</td>
                    <td>
                        @foreach($ejercicio->operandos as $op)
                            {{ $op->valor }}@if(!$loop->last) , @endif
                        @endforeach
                    </td>
                    <td>{{ $ejercicio->respuesta }}</td>
                    <td>{{ $ejercicio->grado }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{ route('sumas.create') }}" class="btn btn-primary mt-3">Generar más sumas</a>
    </div>
</div>
@stop
