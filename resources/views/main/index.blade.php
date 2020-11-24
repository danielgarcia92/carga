@extends('layouts.app')

@section('title', 'Formulario')

@section('content')

    <div class="mx-auto w-70 card">
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
                        <th scope="col">@sortablelink('id', '#')</th>
                        <th scope="col">@sortablelink('std', 'STD')</th>
                        <th scope="col">@sortablelink('flight_number', 'Vuelo')</th>
                        <th scope="col">@sortablelink('from', 'Aeropuerto de salida')</th>
                        <th scope="col">@sortablelink('rego', 'Matrícula')</th>
                        <th scope="col">Origen</th>
                        <th scope="col">@sortablelink('accept', 'Estatus')</th>
                        <th scope="col">Detalles</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($uploads as $upload)
                    <tr>
                        <th scope="row">{{ $upload->id }}</th>
                        <td>{{ $upload->std }}</td>
                        <td>{{ $upload->flight_number }}</td>
                        <td>{{ $upload->from }}</td>
                        <td>{{ $upload->rego }}</td>
                        <td>{{ \App\Origin::where('id', $upload->origins_id)->first()->name }}</td>
                        @if($upload->accept === null)
                            <td><i class="fas fa-hourglass-half" style="color:#ffcc00;"></i></td>
                        @elseif($upload->accept == 1)
                            <td><i class="far fa-check-circle" style="color:#008000;"></i></td>
                        @else
                            <td><i class="far fa-times-circle" style="color:#cb3234;"></i></td>
                        @endif
                        <form method="POST" action="{{ url("main/{$upload->id}") }}" novalidate>
                            {{ csrf_field() }}
                            <input type="hidden" id="id" name="id" value="{{ $upload->id }}"/>
                            <td><button type="submit" class="btn btn-outline-secondary"><i class="fas fa-info-circle"></i></button></td>
                        </form>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <br>

@endsection
