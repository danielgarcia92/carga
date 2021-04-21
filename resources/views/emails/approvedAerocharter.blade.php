<!DOCTYPE html>
<html>
    <head>
        <title>Carga Aerocharter Aprobada</title>
    </head>
    <body>
        La carga de Aerocharter ha sido <strong>APROBADA</strong>
        <br/>
        <p><strong># Folio: </strong>{{ $data['id'] }}</p>
        <p><strong>Comentarios de CCV: </strong>{{ $data['message_approval'] }}</p>
        <p><strong>Número de Vuelo: </strong>{{ $data['flight_number'] }}</p>
        <p><strong>STD: </strong>{{ $data['std'] }}</p>
        <p><strong>Ruta: </strong>{{ $data['from'] }} - {{ $data['to'] }}</p>
        <p><strong>Piezas Totales: </strong>{{ $data['pieces'] }}</p>
        <p><strong>Peso Total: </strong>{{ round($data['weight'], 2) }}</p>
        <p><strong>Volumen Total: </strong>{{ round($data['volume'], 2) }}</p>
        <p><strong>Descripción: </strong>{{ $data['description'] }}</p>
        <p><strong>Método de aseguramiento: </strong>{{ $data['assurance'] }}</p>
        <p><strong>Embalaje: </strong>{{ $data['packing'] }}</p>
        <p><strong>Solicitante: </strong>{{ $data['send'] }}</p>
        <p><strong>Aprobador: </strong>{{ $data['approved_by'] }}</p>
        <br>
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
            @foreach($items as $key => $value)
                <tr>
                    <td><input type="text" class="form-control" value="{{ $items[$key]->guide_number }}" readonly></td>
                    <td><input type="text" class="form-control" value="{{ $items[$key]->pieces }}" readonly></td>
                    <td><input type="text" class="form-control" value="{{ round($items[$key]->weight, 2) }}" readonly></td>
                    <td><input type="text" class="form-control" value="{{ round($items[$key]->volume, 2) }}" readonly></td>
                    <td><input type="text" class="form-control" value="{{ round($items[$key]->partial, 2) }}" readonly></td>
                    <td><input type="text" class="form-control" value="{{ round($items[$key]->density, 2) }}" readonly></td>
                    <td><input type="text" class="form-control" value="{{ $items[$key]->nature_goods }}" readonly></td>
                    <td><input type="text" class="form-control" value="{{ $items[$key]->route_item }}" readonly></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </body>
</html>
