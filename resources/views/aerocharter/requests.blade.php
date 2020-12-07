@extends('layouts.app')

@section('title', 'Mis Solicitudes')

@section('content')

<div class="subheader py-2 py-lg-6 subheader-transparent" id="kt_subheader">
    <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <!--begin::Info-->
        <div class="d-flex align-items-center flex-wrap mr-1">
            <!--begin::Page Heading-->
            <div class="d-flex align-items-baseline flex-wrap mr-5">
                <!--begin::Page Title-->
                <h5 class="text-dark font-weight-bold my-1 mr-5">Mis Solicitudes</h5>
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
                        <a href="" class="text-muted">Solicitudes</a>
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
        <div class="card-toolbar">
            
            <a href="{{ url('/aerocharter') }}" class="btn btn-primary font-weight-bolder">
            <span class="svg-icon svg-icon-md">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <rect x="0" y="0" width="24" height="24"></rect>
                        <circle fill="#000000" cx="9" cy="15" r="6"></circle>
                        <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3"></path>
                    </g>
                </svg>
                
            </span>Nueva Solicitud</a>
            
        </div>
    </div>
    <div class="card-body">
        <ul class="nav nav-tabs md-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="pending-tab-md" data-toggle="tab" href="#pending-md" role="tab" aria-controls="pending-md"
                   aria-selected="true">Pendientes</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="approved-tab-md" data-toggle="tab" href="#approved-md" role="tab" aria-controls="approved-md"
                   aria-selected="false">Aprobadas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="rejected-tab-md" data-toggle="tab" href="#rejected-md" role="tab" aria-controls="rejected-md"
                   aria-selected="false">Rechazadas</a>
            </li>
        </ul>
        <div class="tab-content card pt-5" id="myTabContent">
            <div class="tab-pane fade show active" id="pending-md" role="tabpanel" aria-labelledby="pending-tab-md">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">@sortablelink('flight_number', 'Vuelo')</th>
                        <th scope="col">@sortablelink('std', 'STD (UTC)')</th>
                        <th scope="col">@sortablelink('from', 'Salida')</th>
                        <th scope="col">@sortablelink('to', 'Llegada')</th>
                        <th scope="col">@sortablelink('rego', 'Matrícula')</th>
                        <th scope="col">Estatus</th>
                        <th scope="col">Detalles</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($uploads as $upload)
                        @if($upload->accept === null)
                            <tr>
                                <td>{{ $upload->flight_number }}</td>
                                <td>{{ $upload->std }}</td>
                                <td>{{ $upload->from }}</td>
                                <td>{{ $upload->to }}</td>
                                <td>{{ $upload->rego }}</td>
                                <td><i class="fas fa-hourglass-half" style="color:#ffcc00;"></i></td>
                                <form method="POST" action="{{ url("aerocharter_requests/{$upload->id}") }}" novalidate>
                                    {{ csrf_field() }}
                                    <input type="hidden" id="id" name="id" value="{{ $upload->id }}"/>
                                    <td><button type="submit" class="btn btn-outline-secondary"><i class="fas fa-info-circle"></i></button></td>
                                </form>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="approved-md" role="tabpanel" aria-labelledby="approved-tab-md">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">@sortablelink('flight_number', 'Vuelo')</th>
                        <th scope="col">@sortablelink('std', 'STD (UTC)')</th>
                        <th scope="col">@sortablelink('from', 'Salida')</th>
                        <th scope="col">@sortablelink('to', 'Llegada')</th>
                        <th scope="col">@sortablelink('rego', 'Matrícula')</th>
                        <th scope="col">Estatus</th>
                        <th scope="col">Detalles</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($uploads as $upload)
                        @if($upload->accept == 1)
                            <tr>
                                <td>{{ $upload->flight_number }}</td>
                                <td>{{ $upload->std }}</td>
                                <td>{{ $upload->from }}</td>
                                <td>{{ $upload->to }}</td>
                                <td>{{ $upload->rego }}</td>
                                <td><i class="far fa-check-circle" style="color:#008000;"></i></td>
                                <form method="POST" action="{{ url("aerocharter_requests/{$upload->id}") }}" novalidate>
                                    {{ csrf_field() }}
                                    <input type="hidden" id="id" name="id" value="{{ $upload->id }}"/>
                                    <td><button type="submit" class="btn btn-outline-secondary"><i class="fas fa-info-circle"></i></button></td>
                                </form>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="rejected-md" role="tabpanel" aria-labelledby="rejected-tab-md">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">@sortablelink('flight_number', 'Vuelo')</th>
                        <th scope="col">@sortablelink('std', 'STD (UTC)')</th>
                        <th scope="col">@sortablelink('from', 'Salida')</th>
                        <th scope="col">@sortablelink('to', 'Llegada')</th>
                        <th scope="col">@sortablelink('rego', 'Matrícula')</th>
                        <th scope="col">Estatus</th>
                        <th scope="col">Detalles</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($uploads as $upload)
                        @if($upload->accept == 0 && $upload->accept != null)
                            <tr>
                                <td>{{ $upload->flight_number }}</td>
                                <td>{{ $upload->std }}</td>
                                <td>{{ $upload->from }}</td>
                                <td>{{ $upload->to }}</td>
                                <td>{{ $upload->rego }}</td>
                                <td><i class="far fa-times-circle" style="color:#cb3234;"></i></td>
                                <form method="POST" action="{{ url("aerocharter_requests/{$upload->id}") }}" novalidate>
                                    {{ csrf_field() }}
                                    <input type="hidden" id="id" name="id" value="{{ $upload->id }}"/>
                                    <td><button type="submit" class="btn btn-outline-secondary"><i class="fas fa-info-circle"></i></button></td>
                                </form>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
