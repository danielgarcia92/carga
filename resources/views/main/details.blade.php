@extends('layouts.app')

@section('title', 'Detalles')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="mx-auto w-100">
                <div class="card">
                    <div class="card-header">{{ $title }}{{ $row->flight_number }}</div>

                    <div class="card-body mx-auto w-75">
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
                            <tr>
                                <th scope="row">STD</th>
                                <td>{{ $row->std }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Vuelo</th>
                                <td>{{ $row->flight_number }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Aeropuerto de salida</th>
                                <td>{{ $row->from }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Aeropuerto de llegada</th>
                                <td>{{ $row->to }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Matrícula</th>
                                <td>{{ $row->rego }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Volumen Total</th>
                                <td>{{ round($row->volume, 2) . " m3" }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Piezas totales</th>
                                <td>{{ $row->pieces }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Peso Total</th>
                                <td>{{ round($row->weight, 2) . " kg"}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Descripción</th>
                                <td>{{ $row->description }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Método de aseguramiento</th>
                                <td>{{ $row->assurance }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Embalaje</th>
                                <td>{{ $row->packing }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Envia</th>
                                <td>{{ \App\User::where('id', $row->created_by)->first()->name }}</td>
                            </tr>
                            @if($row->accept == 1)
                                <tr>
                                    <th scope="row">Aprobador por</th>
                                    <td>{{ \App\User::where('id', $row->approved_by)->first()->name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Mensaje de aprobación</th>
                                    <td>{{ $row->message_approval }}</td>
                                </tr>
                            @elseif($row->accept == 0 && $row->accept != null)
                                <tr>
                                    <th scope="row">Rechazado por</th>
                                    <td>{{ \App\User::where('id', $row->approved_by)->first()->name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Mensaje de rechazo</th>
                                    <td>{{ $row->message_approval }}</td>
                                </tr>
                            @endif
                            @if($row->file !== NULL)
                                <tr>
                                    <th scope="row">Imagen</th>
                                    <td><a href="{{ asset($row->file) }}">Imagen</a></td>
                                </tr>
                            @endif
                            <tr>
                                <th scope="row">Origen</th>
                                <td>{{ \App\Origin::where('id', $row->origins_id)->first()->name }}</td>
                            </tr>
                        </table>
                    </div>

                    @if($row->origins_id == 2)
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Número de guía </th>
                                            <th>Piezas</th>
                                            <th>Peso</th>
                                            <th>Volumen</th>
                                            <th>Tipo de carga</th>
                                            <th>Ruta</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($details as $d)
                                            <tr>
                                                <td><input type="text" name="guideNumber[]" class="form-control" value="{{ $d->guide_number }}" readonly></td>
                                                <td><input type="text" name="pieces[]" class="form-control" value="{{ $d->pieces }}" readonly></td>
                                                <td><input type="text" name="weight[]" class="form-control" value="{{ round($d->weight, 2) }}" readonly></td>
                                                <td><input type="text" name="volume[]" class="form-control" value="{{ round($d->volume, 2) }}" readonly></td>
                                                <td><input type="text" name="natureGoods[]" class="form-control" value="{{ $d->nature_goods }}" readonly></td>
                                                <td><input type="text" name="routeItem[]" class="form-control" value="{{ $d->route_item }}" readonly></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    @endif

                    @if($row->accept === null)
                        <div class="mx-auto w-75 card">
                            <form method="POST" action="{{ url("main/details/{$row->id}") }}" validate>
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}

                                <input type="hidden" name="id" value="{{ $row->id }}"/>
                                <input type="hidden" id="accept" name="accept"/>
                                <input type="hidden" name="approved_by" value="{{Auth::user()->getAuthIdentifier()}}"/>
                                <center><textarea name="message_approval" rows="5" required></textarea></center>
                                <br>
                                @if ( Auth::user()->rol == 'approval' || Auth::user()->rol == 'admin')
                                    <center>
                                        <button type="submit" class="btn btn-primary" onclick="approve()"> Aprobar </button>
                                        <button type="submit" class="btn btn-danger" onclick="reject()"> Rechazar </button>
                                    </center>
                                @elseif (Auth::user()->rol == 'test')
                                    <center>
                                        <button type="submit" class="btn btn-primary" onclick="approve()" disabled> Aprobar </button>
                                        <button type="submit" class="btn btn-danger" onclick="reject()" disabled> Rechazar </button>
                                    </center>
                                @endif
                            </form>
                        </div>
                    @endif
                    <br>
                    <br>
                </div>
            </div>
        </div>
    </div>
    <style>
        textarea {
            font-size:20px;
            width:100%;
        }
    </style>
@endsection
