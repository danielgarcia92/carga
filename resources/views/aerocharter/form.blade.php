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
                    <input type="text" class="form-control" id="to" name="to" required>
                </div>
                <div class="form-group">
                    <label for="flightNumber">* Número de vuelo</label>
                    <input type="text" class="form-control" id="flightNumber" name="flightNumber" value="{{ $data[0]->flight }}" required/>
                </div>
                <div class="form-group">
                    <label for="rego">* Matrícula</label>
                    @if($data[0]->rego != 'MX')
                        <input type="text" class="form-control" id="rego" name="rego" value="{{ $data[0]->rego }}" required>
                    @else
                        <input type="text" class="form-control" id="rego" name="rego" required>
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
                                    <th>Tipo de carga</th>
                                    <th>Ruta</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $d)
                                <tr>
                                    <td><input type="text" name="guideNumber[]" class="form-control" value="{{ $d->guideNumber }}" readonly></td>
                                    <td><input type="text" name="pieces[]" class="form-control" value="{{ $d->pieces }}" readonly></td>
                                    <td><input type="text" name="weight[]" class="form-control" value="{{ round($d->weightkg, 2) }}" readonly></td>
                                    <td><input type="text" name="volume[]" class="form-control" value="{{ round($d->volume, 2) }}" readonly></td>
                                    <td><input type="text" name="natureGoods[]" class="form-control" value="{{ $d->description }}" readonly></td>
                                    <td><input type="text" name="routeItem[]" class="form-control" value="{{ $d->routeItem }}" readonly></td>
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
