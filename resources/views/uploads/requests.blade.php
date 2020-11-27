@extends('layouts.app')

@section('title', 'Mis Solicitudes')

@section('content')

    <div class="mx-auto w-75 card">
        <h2 class="card-header text-center">{{ $title }}</h2>

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
                            <th scope="col">@sortablelink('std', 'STD (UTC)')</th>
                            <th scope="col">@sortablelink('flight_number', 'Vuelo')</th>
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
                                    <td>{{ $upload->std }}</td>
                                    <td>{{ $upload->flight_number }}</td>
                                    <td>{{ $upload->from }}</td>
                                    <td>{{ $upload->to }}</td>
                                    <td>{{ $upload->rego }}</td>
                                    <td><i class="fas fa-hourglass-half" style="color:#ffcc00;"></i></td>
                                    <form method="POST" action="{{ url("viva_requests/{$upload->id}") }}" novalidate>
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
                            <th scope="col">@sortablelink('id', '#')</th>
                            <th scope="col">@sortablelink('std', 'STD (UTC)')</th>
                            <th scope="col">@sortablelink('flight_number', 'Vuelo')</th>
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
                                    <th scope="row">{{ $upload->id }}</th>
                                    <td>{{ $upload->std }}</td>
                                    <td>{{ $upload->flight_number }}</td>
                                    <td>{{ $upload->from }}</td>
                                    <td>{{ $upload->to }}</td>
                                    <td>{{ $upload->rego }}</td>
                                    <td><i class="far fa-check-circle" style="color:#008000;"></i></td>
                                    <form method="POST" action="{{ url("viva_requests/{$upload->id}") }}" novalidate>
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
                            <th scope="col">@sortablelink('id', '#')</th>
                            <th scope="col">@sortablelink('std', 'STD (UTC)')</th>
                            <th scope="col">@sortablelink('flight_number', 'Vuelo')</th>
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
                                    <th scope="row">{{ $upload->id }}</th>
                                    <td>{{ $upload->std }}</td>
                                    <td>{{ $upload->flight_number }}</td>
                                    <td>{{ $upload->from }}</td>
                                    <td>{{ $upload->to }}</td>
                                    <td>{{ $upload->rego }}</td>
                                    <td><i class="far fa-times-circle" style="color:#cb3234;"></i></td>
                                    <form method="POST" action="{{ url("viva_requests/{$upload->id}") }}" novalidate>
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
    <br>

@endsection
