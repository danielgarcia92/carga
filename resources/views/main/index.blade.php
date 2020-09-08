@extends('layouts.app')

@section('title', 'Formulario')

@section('content')

    <div class="mx-auto w-70 card">
        <h2 class="card-header text-center">{{ $title }}</h2>

        <div class="card-body">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">STD</th>
                    <th scope="col">Vuelo</th>
                    <th scope="col">Leg Code</th>
                    <th scope="col">De</th>
                    <th scope="col">Hacia</th>
                    <th scope="col">Matrícula</th>
                    <th scope="col">Volumen</th>
                    <th scope="col">Piezas</th>
                    <th scope="col">Peso</th>
                    <th scope="col">Solicitante</th>
                    <th scope="col">Aceptado</th>
                    <th scope="col">Estatus</th>
                    <th scope="col">Aprobar</th>
                    <th scope="col">Rechazar</th>
                </tr>
                </thead>
                <tbody>
                @foreach($uploads as $upload)
                    <tr>
                        <th scope="row">{{ $upload->id }}</th>
                        <td>{{ $upload->std }}</td>
                        <td>{{ $upload->flight_number }}</td>
                        <td>{{ $upload->legcd }}</td>
                        <td>{{ $upload->from }}</td>
                        <td>{{ $upload->to }}</td>
                        <td>{{ $upload->rego }}</td>
                        <td>{{ $upload->volume.' '.$upload->volume_unit }}</td>
                        <td>{{ $upload->pieces }}</td>
                        <td>{{ $upload->weight }}</td>
                        <td>{{ \App\User::where('id', $upload->createdBy)->first()->name }}</td>
                        @if($upload->accept === null)
                            <td>Pendiente</td>
                            <td><i class="fas fa-hourglass-half" style="color:#ffcc00;"></i></td>
                            @if ( Auth::user()->rol != 'test')
                                <form method="POST" action="{{ url("main/{$upload->id}") }}" novalidate>
                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }}

                                    <td>
                                        <input type="hidden" name="accept" value="1"/>
                                        <button onclick="return confirm('¿Realmente desea aprobar la solicitud?')" type="submit"><i class="far fa-check-circle" style="color:#008000;"></i></button>
                                    </td>
                                </form>
                                <form method="POST" action="{{ url("main/{$upload->id}") }}" novalidate>
                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }}

                                    <td>
                                        <input type="hidden" name="accept" value=0 />
                                        <button onclick="return confirm('¿Realmente desea rechazar la solicitud?')" type="submit"><i class="far fa-times-circle" style="color:#cb3234;"></i></button>
                                    </td>
                                </form>
                            @endif
                        @elseif($upload->accept === 1)
                            <td>Sí</td>
                            <td><i class="far fa-check-circle" style="color:#008000;"></i></td>
                            <td><button type="submit" disabled><i class="far fa-check-circle" style="color:#ccc;"></i></button></td>
                            @if ( Auth::user()->rol != 'test')
                                <form method="POST" action="{{ url("main/{$upload->id}") }}" novalidate>
                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }}

                                    <td>
                                        <input type="hidden" name="accept" value=0 />
                                        <button onclick="return confirm('¿Realmente desea rechazar la solicitud?')" type="submit"><i class="far fa-times-circle" style="color:#cb3234;"></i></button>
                                    </td>
                                </form>
                            @endif
                        @else
                            <td>No</td>
                            <td><i class="far fa-times-circle" style="color:#cb3234;"></i></td>
                            @if ( Auth::user()->rol != 'test')
                                <form method="POST" action="{{ url("main/{$upload->id}") }}" novalidate>
                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }}

                                    <td>
                                        <input type="hidden" name="accept" value="1"/>
                                        <button onclick="return confirm('¿Realmente desea aprobar la solicitud?')" type="submit"><i class="far fa-check-circle" style="color:#008000;"></i></button>
                                    </td>
                                </form>
                            @endif
                            <td><button type="submit" disabled><i class="far fa-times-circle" style="color:#cccccc;"></i></button></td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <br>

@endsection
