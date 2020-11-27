<!DOCTYPE html>
<html>
    <head>
        <title>Carga Aerocharter Rechazada</title>
    </head>
    <body>
        La carga de Aerocharter ha sido <strong>RECHAZADA</strong>
        <br/>
        <p><strong>Comentarios de CCV: </strong>{{ $data['message_approval'] }}</p>
        <p><strong>Número de Vuelo: </strong>{{ $data['flight_number'] }}</p>
        <p><strong>STD: </strong>{{ $data['std'] }}</p>
        <p><strong>Ruta: </strong>{{ $data['from'] }} - {{ $data['to'] }}</p>
        <p><strong>Piezas Totales: </strong>{{ $data['pieces'] }}</p>
        <p><strong>Peso Total: </strong>{{ round($data['weight'], 2) }}</p>
        <p><strong>Volumen Total: </strong>{{ round($data['volume'], 2) }}</p>
        <p><strong>Envía: </strong>{{ $data['send'] }}</p>
        <p><strong>Descripción: </strong>{{ $data['description'] }}</p>
        <p><strong>Método de aseguramiento: </strong>{{ $data['assurance'] }}</p>
        <p><strong>Embalaje: </strong>{{ $data['packing'] }}</p>
        <br>
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
            @foreach($items['guide_number'] as $key => $value)
                <tr>
                    <td><input type="text" class="form-control" value="{{ $items['guide_number'][$key] }}" readonly></td>
                    <td><input type="text" class="form-control" value="{{ $items['pieces'][$key] }}" readonly></td>
                    <td><input type="text" class="form-control" value="{{ round($items['weight'][$key], 2) }}" readonly></td>
                    <td><input type="text" class="form-control" value="{{ round($items['volume'][$key], 2) }}" readonly></td>
                    <td><input type="text" class="form-control" value="{{ $items['nature_goods'][$key] }}" readonly></td>
                    <td><input type="text" class="form-control" value="{{ $items['route_item'][$key] }}" readonly></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </body>
</html>
