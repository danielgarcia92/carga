@extends('layouts.app')

@section('title', 'Formulario')

@section('content')

<div class="subheader py-2 py-lg-6 subheader-transparent" id="kt_subheader">
    <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <!--begin::Info-->
        <div class="d-flex align-items-center flex-wrap mr-1">
            <!--begin::Page Heading-->
            <div class="d-flex align-items-baseline flex-wrap mr-5">
                <!--begin::Page Title-->
                <h5 class="text-dark font-weight-bold my-1 mr-5">Solicitudes</h5>
                <!--end::Page Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Sistema de Carga</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">VivaAerobus</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Aprobación</a>
                    </li>
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page Heading-->
        </div>
        <!--end::Info-->
        
    </div>
</div>

<div class="card card-custom">
    <!--begin::Header-->
    <div class="card-header flex-wrap border-0 pt-6 pb-0">
        <div class="card-title">
            <h3 class="card-label">Listado
            <span class="d-block text-muted pt-2 font-size-sm">Listado de Solicitudes</span></h3>
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
                    <th scope="col">@sortablelink('std', 'Fecha de vuelo (UTC)')</th>
                    <th scope="col">Enviado (UTC)</th>
                    <th scope="col">@sortablelink('flight_number', 'Vuelo')</th>
                    <th scope="col">@sortablelink('from', 'Salida')</th>
                    <th scope="col">@sortablelink('to', 'Llegada')</th>
                    <th scope="col">@sortablelink('rego', 'Matrícula')</th>
                    <th scope="col">Origen</th>
                    <th scope="col">@sortablelink('accept', 'Estatus')</th>
                    <th scope="col">Detalles</th>
                </tr>
            </thead>
            <tbody>
            @foreach($uploads as $upload)
                <tr>
                    @if($upload->flight_type != 'NACIONAL')
                        <th bgcolor="#9acd32">{{ $upload->id }}</th>
                        <td bgcolor="#9acd32">{{ $upload->std_zulu }}</td>
                        <td bgcolor="#9acd32">{{ $upload->created_at }}</td>
                        <td bgcolor="#9acd32">{{ $upload->flight_number }}</td>
                        <td bgcolor="#9acd32">{{ $upload->from }}</td>
                        <td bgcolor="#9acd32">{{ $upload->to }}</td>
                        <td bgcolor="#9acd32">{{ $upload->rego }}</td>
                        <td bgcolor="#9acd32">{{ \App\Origin::where('id', $upload->origins_id)->first()->name }}</td>
                        @if($upload->accept === null)
                            <td bgcolor="#9acd32"><i class="fas fa-hourglass-half" style="color:#ffcc00;"></i></td>
                        @elseif($upload->accept == 1)
                            <td bgcolor="#9acd32"><i class="far fa-check-circle" style="color:#008000;"></i></td>
                        @else
                            <td bgcolor="#9acd32"><i class="far fa-times-circle" style="color:#cb3234;"></i></td>
                        @endif
                        <form method="POST" action="{{ url("main/{$upload->id}") }}" novalidate>
                            {{ csrf_field() }}
                            <input type="hidden" id="id" name="id" value="{{ $upload->id }}"/>
                            <td bgcolor="#9acd32"><button type="submit" class="btn btn-outline-secondary"><i class="fas fa-info-circle"></i></button></td>
                        </form>
                    @else
                        <th>{{ $upload->id }}</th>
                        <td>{{ $upload->std_zulu }}</td>
                        <td>{{ $upload->created_at }}</td>
                        <td>{{ $upload->flight_number }}</td>
                        <td>{{ $upload->from }}</td>
                        <td>{{ $upload->to }}</td>
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
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
            {{ $uploads->links() }}
    </div>
</div>
@endsection

@php
    $url1=$_SERVER['REQUEST_URI'];
    header("Refresh: 60; URL=$url1");
@endphp
