@extends('layouts.app')

@section('title', 'Formulario')

@section('content')

    <div class="mx-auto w-75 card">
        <h2 class="card-header text-center">{{ $title }}</h2>
        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <h6>Por favor corregir los siguiente errores:</h6>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Vuelo</th>
                        <th scope="col">STD</th>
                        <th scope="col">idMensajeRCV</th>
                        <th scope="col">Formulario</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($cargo as $c)
                    <tr>
                        <th scope="row">{{ $c->flight }}</th>
                        <td>{{ $c->STD }}</td>
                        <td>{{ $c->idMensajeRCV }}</td>
                        <form method="POST" action="{{ url("aerocharter_form") }}" novalidate>
                            {{ csrf_field() }}
                            <input type="hidden" id="idMensajeRCV" name="idMensajeRCV" value="{{ $c->idMensajeRCV }}"/>
                            <td><button type="submit"><i class="fab fa-wpforms"></i></button></td>
                        </form>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <br>

@endsection
