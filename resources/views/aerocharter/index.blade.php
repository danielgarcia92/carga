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
                <h5 class="text-dark font-weight-bold my-1 mr-5">Carga de Datos</h5>
                <!--end::Page Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">Sistema de Carga</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">CHAMP</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="" class="text-muted">SFTP</a>
                    </li>
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page Heading-->
        </div>
        <!--end::Info-->
        
    </div>
</div>
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
<div class="card card-custom">
    <!--begin::Header-->
    <div class="card-header flex-wrap border-0 pt-6 pb-0">
        <div class="card-title">
            <h3 class="card-label">Listado
            <span class="d-block text-muted pt-2 font-size-sm">Listado de Solicitudes</span></h3>
        </div>
        <div class="card-toolbar">
           
        </div>
    </div>
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Fecha de vuelo (UTC)</th>
                    <th scope="col">Vuelo</th>
                    <th scope="col">idMensajeRCV</th>
                    <th scope="col">Formulario</th>
                </tr>
            </thead>
            <tbody>
            @foreach($cargo as $c)
                <tr>
                    <td>{{ $c->OUTZulu }}</td>
                    <th scope="row">{{ $c->flight }}</th>
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

@endsection
