@extends('layouts.app')

@section('title', 'Formulario')

@section('content')

    <div class="mx-auto w-50 card">
        <h2 class="card-header text-center">Guardado con éxito</h2>

        <div class="card-body text-center">
            <a href="{{ route('champ.index') }}" class="btn btn-link">Ingrese un nuevo registro</a>
        </div>
    </div>

@endsection
