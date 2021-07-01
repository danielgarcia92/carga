@extends('layouts.notification')

@section('title', 'Notificación')

@section('content')

<div class="card card-custom">
    <!--begin::Header-->
    <div class="card-header pt-1 pb-0">
        <div class="card-title">
            <h3 class="card-label">Listado de solicitudes pendientes</h3>
        </div>
    </div>
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
                    <th scope="col">@sortablelink('id', 'Folio')</th>
                    <th scope="col">@sortablelink('std_zulu', 'Fecha de vuelo (UTC)')</th>
                    <th scope="col">Enviado (UTC)</th>
                    <th scope="col">@sortablelink('flight_number', 'Vuelo')</th>
                    <th scope="col">@sortablelink('from', 'Salida')</th>
                    <th scope="col">@sortablelink('to', 'Llegada')</th>
                    <th scope="col">@sortablelink('rego', 'Matrícula')</th>
                    <th scope="col">Origen</th>
                    <th scope="col">Tiempo Faltante</th>
                </tr>
            </thead>
            <tbody>
            @foreach($uploads as $key => $upload)
                @if($diff[$key] === 'El vuelo ya salió')
                    <tr class="table-danger">
                @elseif($diff[$key] <= 45)
                    <tr class="bg-warning">
                @else
                    <tr>
                @endif
                    <th>{{ $upload->id }}</th>
                    <td>{{ $upload->std_zulu }}</td>
                    <td>{{ $upload->created_at }}</td>
                    <td>{{ $upload->flight_number }}</td>
                    <td>{{ $upload->from }}</td>
                    <td>{{ $upload->to }}</td>
                    <td>{{ $upload->rego }}</td>
                    <td>{{ \App\Origin::where('id', $upload->origins_id)->first()->name }}</td>
                    <td>{{ $diff[$key] }}</td>
                </tr>

            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
