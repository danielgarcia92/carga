@extends('layouts.app')

@section('title', 'Solicitud')

@section('content')
<div class="card card-custom gutter-b example example-compact">
    <div class="card-header">
        <h3 class="card-title">Formulario de Solicitud</h3>
        <div class="card-toolbar">
            <div class="example-tools justify-content-center">
                <span class="example-toggle" data-toggle="tooltip" title="" data-original-title="View code"></span>
                <span class="example-copy" data-toggle="tooltip" title="" data-original-title="Copy code"></span>
            </div>
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

     <form method="POST" action="{{ url('uploads') }}" class="needs-validation" enctype="multipart/form-data">
        
        {!! csrf_field() !!}
        <div class="card-body">
            <div class="form-group row">
                <div class="col-lg-4">
                    <label>* Número de Vuelo:</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="la la-calendar-plus-o"></i>
                            </span>
                        </div>

                        <select class="form-control" onchange="populate()" id="flight_number" name="flight_number" required>
                            <option value=""></option>
                            @foreach($flights as $flight)
                                <option Dep="{{ $flight->Dep }}" OUTZulu="{{ $flight->DepZulu }}" PortFrom="{{ $flight->PortFrom }}" PortTo="{{ $flight->PortTo }}" Rego="{{ $flight->Rego }}" value="{{ $flight->Flight }}"> VB{{ $flight->Flight }}</option>
                            @endforeach
                        </select>
                    </div>
                    <span class="form-text text-muted">Número de vuelo máximo 4 dígitos</span>
                </div>

                <div class="col-lg-4">
                    <label>* STD (UTC):</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="la la-calendar"></i>
                            </span>
                        </div>
                        <input type="hidden" class="form-control" id="std" name="std" readonly/>
                        <input type="text" class="form-control" id="stdZulu" name="stdZulu" placeholder="Fecha" readonly/>
                    </div>
                    <span class="form-text text-muted">Verificar que la fecha esté en UTC</span>
                </div>

                <div class="col-lg-4">
                    <label>* Matrícula:</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="la la-chain"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control" id="rego" name="rego" placeholder="XX-XXX" maxlength="6" style="text-transform:uppercase" readonly>
                    </div>
                    <span class="form-text text-muted">Formato XX-XXX</span>
                </div>

            </div>

            <div class="form-group row">
                <div class="col-lg-4">
                    <label>* Aeropuerto de Salida:</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="la la-plane"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control" id="from" name="from" placeholder="XXX" maxlength="3" style="text-transform:uppercase" readonly>
                    </div>
                    <span class="form-text text-muted">Utilizar Código IATA del Aeropuerto</span>
                </div>

                <div class="col-lg-4">
                    <label>* Aeropuerto de Llegada:</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="la la-plane"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control" id="to" name="to" placeholder="XXX" maxlength="3" style="text-transform:uppercase" readonly>
                    </div>
                    <span class="form-text text-muted">Utilizar Código IATA del Aeropuerto</span>
                </div>

                <div class="col-lg-4">
                    <label>* Número de Piezas:</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="la la-clipboard"></i>
                            </span>
                        </div>
                        <input type="number" class="form-control" id="pieces" name="pieces" value="{{ old('pieces') }}" min=0 required/>
                    </div>
                    <span class="form-text text-muted">Hasta 2 decimales</span>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-4">
                    <label>* Peso (Kg):</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="la la-align-left"></i>
                            </span>
                        </div>
                        <input type="number" class="form-control" id="weight" name="weight" value="{{ old('weight') }}" min=0 step="0.01" required/>
                    </div>
                    <span class="form-text text-muted">Colocar el peso en KG con hasta 2 decimales</span>
                </div>
                <div class="col-lg-4">
                    <label>Volumen (m3):</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="la la-align-left"></i>
                            </span>
                        </div>
                        <input type="number" class="form-control" id="volume" name="volume" value="{{ old('volume') }}" min=0 step="0.01"/>
                    </div>
                    <span class="form-text text-muted">Colocar los metros cúbicos</span>
                </div>
                <div class="col-lg-4">
                    <label>* Envía:</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="la la-user"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control" id="send" name="send" placeholder="John Doe" value="{{ old('send') }}" required>
                    </div>
                    <span class="form-text text-muted">Nombre de quien envía</span>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-4">
                    <label>* Descripción:</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="la la-comment"></i>
                            </span>
                        </div>
                        <textarea class="form-control" id="description" name="description" rows="3" maxlength="100" required>{{ old('description') }}</textarea>
                    </div>
                    <span class="form-text text-muted">Describa de forma clara lo que contiene el paquete</span>
                </div>

                <div class="col-lg-4">
                    <label>* Método de Aseguramiento:</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="la la-gear"></i>
                            </span>
                        </div>
                        <textarea class="form-control" id="assurance" name="assurance" rows="3" maxlength="100" required>{{ old('assurance') }}</textarea>
                    </div>
                    <span class="form-text text-muted">Describir el método de aseguramiento del paquete</span>
                </div>
                <div class="col-lg-4">
                    <label>* Embalaje:</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="la la-gift"></i>
                            </span>
                        </div>
                        <textarea class="form-control" id="packing" name="packing" rows="3" maxlength="100" required>{{ old('packing') }}</textarea>
                    </div>
                    <span class="form-text text-muted">Definir el método de embalaje del paquete</span>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-4">
                    <label>Enviar copia a:</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="las la-envelope-open-text"></i>
                            </span>
                        </div>
                        <input type="email" class="form-control" id="email1" name="email1" placeholder="test@test.com">
                    </div>
                    <span class="form-text text-muted">Sólo llenar en caso de querer enviar copia de la solicitud</span>
                </div>
                <div class="col-lg-4">
                    <label>Enviar copia a:</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="las la-envelope-open-text"></i>
                            </span>
                        </div>
                        <input type="email" class="form-control" id="email2" name="email2" placeholder="test@test.com">
                    </div>
                    <span class="form-text text-muted">Sólo llenar en caso de querer enviar copia de la solicitud</span>
                </div>
                <div class="col-lg-4">
                    <label>Enviar copia a:</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="las la-envelope-open-text"></i>
                            </span>
                        </div>
                        <input type="email" class="form-control" id="email3" name="email3" placeholder="test@test.com">
                    </div>
                    <span class="form-text text-muted">Sólo llenar en caso de querer enviar copia de la solicitud</span>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-4">
                    <label>Subir imagen:</label>
                    <div class="input-group">
                        <input type="file" class="form-control" id="file" name="file" accept="image/png, image/jpeg" />
                    </div>
                    <span class="form-text text-muted">Sólo llenar en caso de querer enviar una imagen de la solicitud</span>
                </div>
            </div>
        </div>

         <div class="card-footer">
             <div class="row">
                 <div class="col-lg-4"></div>
                 <div class="col-lg-8">
                     @if ( Auth::user()->rol != 'test')
                         <div class="mx-auto">
                             <button type="submit" onClick="this.form.submit(); this.disabled=true; this.innerHTML='Enviando ...'; " class="btn btn-success"><i class="fa fa-upload"></i> Enviar Formulario</button>
                         </div>
                     @endif
                 </div>
             </div>
         </div>
    </form>
    <!--end::Form-->
</div>

@endsection
