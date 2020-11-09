@extends('layouts.app')

@section('title', 'Formulario')

@section('content')

    <div class="mx-auto w-70 card">
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

            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">@sortablelink('id', '#')</th>
                    <th scope="col">@sortablelink('std', 'STD')</th>
                    <th scope="col">@sortablelink('flight_number', 'Vuelo')</th>
                    <th scope="col">Ruta</th>
                    <th scope="col">@sortablelink('rego', 'Rego')</th>
                    <th scope="col">Piezas</th>
                    <th scope="col">Peso</th>
                    <th scope="col">Volumen</th>
                    <th scope="col">Embalaje</th>
                    <th scope="col">Método de aseguramiento</th>
                    <th scope="col">Solicitud</th>
                    <th scope="col">Aprobación</th>
                    <th scope="col">@sortablelink('accept', 'Estatus')</th>
                    <th scope="col">Sí</th>
                    <th scope="col">No</th>
                    <th scope="col">Sí / No</th>
                </tr>
                </thead>
                <tbody>
                @foreach($uploads as $upload)
                    <tr>
                        <th scope="row">{{ $upload->id }}</th>
                        <td>{{ $upload->std }}</td>
                        <td>{{ $upload->flight_number }}</td>
                        <td>{{ $upload->from }} - {{ $upload->to }}</td>
                        <td>{{ $upload->rego }}</td>
                        <td>{{ $upload->pieces }}</td>
                        <td>{{ $upload->weight }}</td>
                        <td>{{ $upload->volume }}</td>
                        <td>{{ $upload->packing }}</td>
                        <td>{{ $upload->assurance }}</td>
                        <!--<td>{{ \App\User::where('id', $upload->created_by)->first()->name }}</td>-->
                        <td>{{ $upload->receive  }}</td>
                        @if($upload->accept === null)
                            <td></td>
                            <td><i class="fas fa-hourglass-half" style="color:#ffcc00;"></i></td>

                            @if ( Auth::user()->rol != 'test')
                                <form method="POST" action="{{ url("main/{$upload->id}") }}" novalidate>
                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }}

                                    <input type="hidden" id="accept" name="accept" value="1"/>
                                    <td>
                                        <input type="hidden" name="approved_by" value="{{Auth::user()->getAuthIdentifier()}}"/>
                                        <button onclick="approve()" type="submit">
                                            <i class="far fa-check-circle" style="color:#008000;"></i>
                                        </button>
                                    </td>

                                    <td>
                                        <input type="hidden" name="approved_by" value="{{Auth::user()->getAuthIdentifier()}}"/>
                                        <button onclick="reject()" type="submit">
                                            <i class="far fa-times-circle" style="color:#cb3234;"></i>
                                        </button>
                                    </td>

                                    <td><textarea name="message_approval"></textarea></td>
                                </form>
                            @endif

                        @elseif($upload->accept === 1)
                            <td>{{ \App\User::where('id', $upload->approved_by)->first()->name }}</td>
                            <td><i class="far fa-check-circle" style="color:#008000;"></i></td>
                            <td><button type="submit" disabled><i class="far fa-check-circle" style="color:#ccc;"></i></button></td>
                            <td><button type="submit" disabled><i class="far fa-times-circle" style="color:#ccc;"></i></button></td>
                            <td><textarea name="message_approval" disabled>{{ $upload->message_approval }}</textarea></td>
                        @else
                            <td>{{ \App\User::where('id', $upload->approved_by)->first()->name }}</td>
                            <td><i class="far fa-times-circle" style="color:#cb3234;"></i></td>
                            <td><button type="submit" disabled><i class="far fa-check-circle" style="color:#ccc;"></i></button></td>
                            <td><button type="submit" disabled><i class="far fa-times-circle" style="color:#ccc;"></i></button></td>
                            <td><textarea name="message_approval" disabled>{{ $upload->message_approval }}</textarea></td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <br>

@endsection
