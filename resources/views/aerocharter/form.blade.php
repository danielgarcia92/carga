@extends('layouts.app')

@section('title', 'Formulario')

@section('content')

    <div class="mx-auto card">
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

            <form method="POST" action="{{ url('aerocharter') }}" class="needs-validation" enctype="multipart/form-data">
                {!! csrf_field() !!}
                {{ method_field('PUT') }}

                <div class="form-group">
                    <input type="hidden" id="idMensajeRCV" name="idMensajeRCV" value="{{ $data[0]->idMensajeRCV }}"/>
                </div>
                <div class="form-group">
                    <label for="std">* Fecha de vuelo (UTC)</label>
                    <input type="text" class="form-control" id="std" name="std" value="{{ $data[0]->STD }}" required/>
                </div>
                <div class="form-group">
                    <label for="from">* Aeropuerto de salida</label>
                    <input type="text" class="form-control" id="from" name="from" value="{{ $data[0]->portFrom }}" required>
                </div>
                <div class="form-group">
                    <label for="to">* Aeropuerto de llegada</label>
                    <input type="text" class="form-control" id="to" name="to"  maxlength="3" style="text-transform:uppercase" required>
                </div>
                <div class="form-group">
                    <label for="flightNumber">* Número de vuelo</label>
                    <input type="text" class="form-control" id="flight_number" name="flight_number" value="{{ $data[0]->flight }}" required/>
                </div>
                <div class="form-group">
                    <label for="rego">* Matrícula</label>
                    @if($data[0]->rego === NULL || $data[0]->rego == 'MX')
                        <input type="text" class="form-control" id="rego" name="rego" minlength="6" maxlength="6" style="text-transform:uppercase" required>
                    @else
                        <input type="text" class="form-control" id="rego" name="rego" maxlength="6" value="{{ $data[0]->rego }}" required>
                    @endif
                </div>

                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Número de guía </th>
                                    <th>Piezas</th>
                                    <th>Peso</th>
                                    <th>Volumen</th>
                                    <th>Parcial</th>
                                    <th>Densidad</th>
                                    <th>Tipo de carga</th>
                                    <th>Ruta</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $d)
                                <tr>
                                    <td><input type="text" name="guide_number[]" class="form-control" value="{{ $d->guideNumber }}" readonly></td>
                                    <td><input type="text" name="pieces[]" class="form-control" value="{{ $d->pieces }}" readonly></td>
                                    <td><input type="text" name="weight[]" class="form-control" value="{{ round($d->weightkg, 2) }}" readonly></td>
                                    <td><input type="text" name="volume[]" class="form-control" value="{{ round($d->volume, 2) }}" readonly></td>
                                    <td><input type="text" name="partial[]" class="form-control" value="{{ round($d->partial, 2) }}" readonly></td>
                                    <td><input type="text" name="density[]" class="form-control" value="{{ round($d->density, 2) }}" readonly></td>
                                    <td><input type="text" name="nature_goods[]" class="form-control" value="{{ $d->description }}" readonly></td>
                                    <td><input type="text" name="route_item[]" class="form-control" value="{{ $d->routeItem }}" readonly></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">* Descripción</label>
                    <textarea class="form-control" id="description" name="description" rows="3" maxlength="100" required>{{ old('description') }}</textarea>
                </div>
                <div class="form-group">
                    <label for="assurance">* Método de aseguramiento</label>
                    <textarea class="form-control" id="assurance" name="assurance" rows="3" maxlength="100" required>{{ old('assurance') }}</textarea>
                </div>
                <div class="form-group">
                    <label for="packing">* Embalaje</label>
                    <textarea class="form-control" id="packing" name="packing" rows="3" maxlength="100" required>{{ old('packing') }}</textarea>
                </div>
                <div class="form-group">
                    <label for="inter_cargo">N° Auth de envío carga internacional</label>
                    <input type="text" class="form-control" id="inter_cargo" maxlength="20" name="inter_cargo">
                    <span class="form-text text-muted">Sólo llenar en caso de vuelo internacional</span>
                </div>
                <div class="form-group row">
                    <div class="col-lg-4">
                        <label>Subir archivo:</label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="file" name="file" accept="image/png, image/jpeg, application/pdf" />
                        </div>
                        <span class="form-text text-muted">Sólo llenar en caso de querer enviar un archivo</span>
                    </div>
                </div>
                <br>
                @if ( Auth::user()->rol != 'test')
                    <div class="mx-auto text-center">
                        <button type="submit" class="btn btn-success"><i class="fa fa-upload"></i> Subir Formulario</button>
                    </div>
                @endif
            </form>
        </div>
    </div>
    <br>

@endsection
