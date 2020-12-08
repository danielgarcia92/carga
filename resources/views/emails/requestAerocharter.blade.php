<!DOCTYPE html>
<html>
    <head>
        <title>Envío de solicitud de carga Aerocharter</title>
    </head>
    <body>
        La solicitud de envío de carga por parte de Aerocharter ha sido diligenciada satisfactoriamente, el equipo del centro de control de Viva Aerobus está evaluando la información.
        <br/>
        <p>Los datos enviados son los siguientes: </p>
        <p><strong># Folio: </strong>{{ $data['id'] }}</p>
        <p><strong>Número de Vuelo: </strong>{{ $data['flight_number'] }}</p>
        <p><strong>STD: </strong>{{ $data['std'] }}</p>
        <p><strong>Aeropuerto de salida: </strong>{{ $data['from'] }}</p>
        <p><strong>Aeropuerto de llegada: </strong>{{ $data['to'] }}</p>
        <p><strong>Piezas totales: </strong>{{ $data['pieces'] }}</p>
        <p><strong>Peso Total: </strong>{{ round($data['weight'], 2) }} Kg</p>
        <p><strong>Volumen Total: </strong>{{ round($data['volume'], 2) }} MC</p>
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
                        <td><input type="text" class="form-control" value="{{ $items['guide_number'][$key] }}" readonly/></td>
                        <td><input type="text" class="form-control" value="{{ $items['pieces'][$key] }}" readonly/></td>
                        <td><input type="text" class="form-control" value="{{ round($items['weight'][$key], 2) }}" readonly/></td>
                        <td><input type="text" class="form-control" value="{{ round($items['volume'][$key], 2) }}" readonly/></td>
                        <td><input type="text" class="form-control" value="{{ $items['nature_goods'][$key] }}" readonly/></td>
                        <td><input type="text" class="form-control" value="{{ $items['route_item'][$key] }}" readonly/></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>
