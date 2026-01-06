@extends('adminlte::page')

@section('title', 'Sumas')

@section('css')
<link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
@stop
@section('content')
<div class="container mt-3">
    <div class="card">
        <div class="card-header bg-primary">
            GENERADOR DE SUMAS
        </div>
        <div class="card-body">
            <form action='{{ route("sumas.imprimir") }}' method="POST" class="form-horizontal">
                @csrf
        
                <div class="mb-3">
                    <label for="sumandos" class="form-label">Cantidad de Sumandos</label>
                    <input type="number" min="1" name="sumandos" id="sumandos" class="form-control" required placeholder="Cantidad de Sumandos">
                </div>
        
                <div class="mb-3">
                    <label for="digitos" class="form-label">Cantidad de Dígitos</label>
                    <input type="number" min="1" name="digitos" id="digitos" class="form-control" required placeholder="Cantidad de Dígitos">
                </div>
        
                <div class="mb-3">
                    <label for="floatingSelectGrid" class="form-label">Selecciona la Dificultad</label>
                    <select name="dificultad" class="form-select form-control" id="floatingSelectGrid" required>
                        <option value="1">FACILINGO</option>
                        <option value="2">FACIL</option>
                        <option value="3">NORMAL</option>
                        <option value="4">DIFICIL</option>
                        <option value="5">SUPERDIFICIL</option>
                        <option value="6">ULTRADIFICIL</option>
                        <option value="7">TIPOEXAMEN</option>
                    </select>
                </div>
        
                <div class="d-flex justify-content-center">
                    <input type="submit" name="Aceptar" class="btn btn-primary col-4" value="Generar">
                </div>
            </form>
        </div>
    </div>
    
</div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop