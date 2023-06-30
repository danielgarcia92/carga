<!DOCTYPE html>
<html>
    <head>
        <title>Envío de Solicitud Comat</title>
    </head>
    <body>
        La solicitud Comat ha sido enviada satisfactoriamente, el equipo del centro de control de Viva Aerobus está evaluando la información.
        <br/>
        <p>Los datos enviados son los siguientes: </p>
        <p><strong># Folio: </strong>{{ $data['id'] }}</p>
        <p><strong>Número de Vuelo: </strong>{{ $data['flight_number'] }}</p>
        <p><strong>STD (UTC): </strong>{{ $data['std_zulu'] }}</p>
        <p><strong>Ruta: </strong>{{ $data['from'] }} - {{ $data['to'] }}</p>
        <p><strong>Piezas totales: </strong>{{ $data['pieces'] }}</p>
        <p><strong>Peso Total: </strong>{{ round($data['weight'], 2) }}</p>
        <p><strong>Descripción: </strong>{{ $data['description'] }}</p>
        <p><strong>Método de aseguramiento: </strong>{{ $data['assurance'] }}</p>
        <p><strong>Embalaje: </strong>{{ $data['packing'] }}</p>
        <p><strong>Solicitante: </strong>{{ $data['send'] }}</p>
    </body>
</html>
