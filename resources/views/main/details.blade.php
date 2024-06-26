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
                                <th scope="row">Fecha de vuelo (UTC)</th>
                                <td>{{ $row->std_zulu }}</td>
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
                            @if($row->volume != 0)
                                <tr>
                                    <th scope="row">Volumen Total</th>
                                    <td>{{ round($row->volume, 2) . " m3" }}</td>
                                </tr>
                            @endif
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
                                <th scope="row">Envía</th>
                                <td>{{ \App\User::where('id', $row->created_by)->first()->name }}</td>
                            </tr>
                            @if($row->accept == 1)
                                <tr>
                                    <th scope="row">Aprobado por</th>
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
                            <tr>
                                <th scope="row">Estatus</th>
                                @if($row->accept == 1)
                                    <td style="color:#008000;">Aprobado</td>
                                @elseif($row->accept == 0 && $row->accept != null)
                                    <td style="color:#cb3234;">Rechazado</td>
                                @else
                                    <td style="color:#ffcc00;">Pendiente</td>
                                @endif
                            </tr>
                        </table>
                    </div>

                    @if($row->origins_id == 1)
                        <div id="bUpd">
                            <center>
                                <button type="submit" class="btn btn-primary" onclick="aprobarComat()"> Aprobar </button>
                                
                                <button type="submit" class="btn btn-danger" onclick="rechazar()"> Rechazar </button>
                            </center>
                        </div>
                        @if ( Auth::user()->rol == 'approval' || Auth::user()->rol == 'admin')
                            <form method="POST" onSubmit="if(!confirm('¿Realmente desea enviar la actualización?')){return false;}" action="{{ url("main/details/{$row->id}") }}" validate>
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}

                                <input type="hidden" id="accept" name="accept"/>
                                <input type="hidden" name="id" value="{{ $row->id }}"/>
                                <input type="hidden" id="origin" name="origin" value="VIV"/>
                                <input type="hidden" name="approved_by" value="{{Auth::user()->getAuthIdentifier()}}"/>
                                <div class="form-select" id="form1"></div>
                            </form>
                        @endif
                    @endif

                    @if($row->origins_id == 2)
                        <form method="POST" onSubmit="if(!confirm('¿Realmente desea enviar la actualización?')){return false;}" action="{{ url("main/details/{$row->id}") }}" validate>
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th><label class="selAllOpt" for="chkbxAll"><input onchange="selectAllChboxes()" type="checkbox" id="chkbxAll" name="chkbxAll" /></label></th>
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
                                            @foreach($details as $d)
                                                <tr>
                                                    <td><label for="chkbxAll"><input class="select-option" onchange="removeRequired()" type="checkbox" id="chkbx[]" name="chkbx[]" value="{{ $d->guide_number }}" required />  </label></td>
                                                    <td><input type="text" name="guideNumber[]" class="form-control" value="{{ $d->guide_number }}" readonly></td>
                                                    <td><input type="text" name="pieces[]" class="form-control" value="{{ $d->pieces }}" readonly></td>
                                                    <td><input type="text" name="weight[]" class="form-control" value="{{ round($d->weight, 2) }}" readonly></td>
                                                    <td><input type="text" name="volume[]" class="form-control" value="{{ round($d->volume, 2) }}" readonly></td>
                                                    <td><input type="text" name="partial[]" class="form-control" value="{{ round($d->partial, 2) }}" readonly></td>
                                                    <td><input type="text" name="density[]" class="form-control" value="{{ round($d->density, 3) }}" readonly></td>
                                                    <td><input type="text" name="natureGoods[]" class="form-control" value="{{ $d->nature_goods }}" readonly></td>
                                                    <td><input type="text" name="routeItem[]" class="form-control" value="{{ $d->route_item }}" readonly></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            @if ( Auth::user()->rol == 'approval' || Auth::user()->rol == 'admin')
                                <div id="bUpd">
                                    <center>
                                        <center>
                                        <button type="submit" class="btn btn-primary" onclick="aprobarCarga()"> Aprobar </button>
                                        
                                        <button type="submit" class="btn btn-danger" onclick="rechazar()"> Rechazar </button>
                                    </center>
                                    </center>
                                </div>
                                <input type="hidden" id="accept" name="accept"/>
                                <input type="hidden" name="id" value="{{ $row->id }}"/>
                                <input type="hidden" id="origin" name="origin" value="ACM"/>
                                <input type="hidden" name="approved_by" value="{{Auth::user()->getAuthIdentifier()}}"/>
                                <div class="form-select" id="form1"></div>
                            @endif
                        </form>

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
    <script type="text/javascript">
        const chkbxAll = document.querySelector("#chkbxAll");
        const chkbxOptions = document.querySelectorAll(".select-option");

        function selectAllChboxes() {
            const isChecked = chkbxAll.checked;
            for (let i = 0; i < chkbxOptions.length; i++) {
                chkbxOptions[i].checked = isChecked;
            }
        }

        function removeRequired() {
            for (let i = 0; i < chkbxOptions.length; i++) {
                chkbxOptions[i].removeAttribute("required");
            }
        }

    </script>
@endsection
