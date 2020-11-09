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

            <form method="POST" action="{{ url('uploads') }}" class="needs-validation" enctype="multipart/form-data" novalidate>
                {!! csrf_field() !!}

                <div class="form-group">
                    <label for="std">* Fecha de vuelo (UTC)</label>
                    <input type="datetime-local" class="form-control" id="std" name="std" placeholder="Fecha" value="{{ old('std') }}" required/>
                </div>
                <div class="form-group">
                    <label for="from">* Aeropuerto de salida</label>
                    <input type="text" class="form-control" id="from" name="from" placeholder="MTY" maxlength="3" value="{{ old('from') }}" required>
                </div>
                <div class="form-group">
                    <label for="to">* Aeropuerto de llegada</label>
                    <input type="text" class="form-control" id="to" name="to" placeholder="MEX" maxlength="3" value="{{ old('to') }}" required>
                </div>
                <div class="form-group">
                    <label for="flightNumber">* Número de vuelo</label>
                    <input type="number" class="form-control" id="flightNumber" name="flightNumber" placeholder="Máximo 4 dígitos" min="0" value="{{ old('flightNumber') }}" required/>
                </div>
                <div class="form-group">
                    <label for="rego">* Matrícula</label>
                    <input type="text" class="form-control" id="rego" name="rego" placeholder="XA-VIH" maxlength="6" value="{{ old('rego') }}" required>
                </div>

                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>AWB / ULD </th>
                                    <th>PIECES</th>
                                    <th>WEIGHT</th>
                                    <th>VOLUME</th>
                                    <th>NATURE GOODS</th>
                                    <th>USE BY OWNER/OPERATOR OFFICIAL USE</th>
                                    <th style="text-align: center"><a href="#" class="btn btn-info addRow">+</a></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="text" name="awb" class="form-control"></td>
                                    <td><input type="text" name="piecesNumber" class="form-control"></td>
                                    <td><input type="text" name="weight" class="form-control"></td>
                                    <td><input type="text" name="volume" class="form-control"></td>
                                    <td><input type="text" name="goods" class="form-control"></td>
                                    <td><input type="text" name="use" class="form-control"></td>
                                    <td style="text-align: center"><a href="#" class="btn btn-danger">-</a></td>
                                </tr>
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
