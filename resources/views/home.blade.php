@extends('layouts.app')

@section('content')
<div class="row">
    <div class="card card-custom gutter-b card-stretch bg-info">
        <div class="card-body d-flex p-0">
            <div class="flex-grow-1 bg-info p-12 pb-40 card-rounded flex-grow-1 bgi-no-repeat" 
            style="background-position: right bottom; background-size: 55% auto; background-image: url({{ asset('media/svg/humans/custom-4.svg') }})">
                <h3 class="text-inverse-info pb-5 font-weight-bolder">Bienvenidos al Sistema de Carga de VivaAerobus</h3>
                <p class="text-inverse-info pb-5 font-size-h6">Concentrador de Datos de Carga
                <br>Aerocharter
                <br>VivaAerobus
                <br>En caso de cualquier problema o comentario 
                <br>favor de comunicarse con el área de TI de VivaAerobus</p>
                <a href="https://vivaaerobus.com" class="btn btn-success font-weight-bold py-2 px-6" target="_blank">Sitio Oficial</a>
            </div>
        </div>
    </div>
</div>
@endsection

