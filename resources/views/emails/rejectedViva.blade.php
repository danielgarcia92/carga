<!DOCTYPE html>
<html>
    <head>
        <title>Solicitud Rechazada</title>
    </head>
    <body>
        La solicitud ha sido <strong>RECHAZADA</strong>
        <br/>
        <p><strong># Folio: </strong>{{ $data['id'] }}</p>
        <p><strong>Comentarios de CCV: </strong>{{ $data['message_approval'] }}</p>
        <p><strong>Número de Vuelo: </strong>{{ $data['flight_number'] }}</p>
        <p><strong>Fecha de vuelo (UTC): </strong>{{ $data['std_zulu'] }}</p>
        <p><strong>Ruta: </strong>{{ $data['from'] }} - {{ $data['to'] }}</p>
        <p><strong>Piezas Totales: </strong>{{ $data['pieces'] }}</p>
        <p><strong>Peso Total: </strong>{{ round($data['weight'], 2) }}</p>
        <p><strong>Descripción: </strong>{{ $data['description'] }}</p>
        <p><strong>Método de aseguramiento: </strong>{{ $data['assurance'] }}</p>
        <p><strong>Embalaje: </strong>{{ $data['packing'] }}</p>
        <p><strong>Solicitado por: </strong>{{ $data['send'] }}</p>
        <p><strong>Rechazado por: </strong>{{ $approved_name }}</p>
    </body>
</html>
