<!DOCTYPE html>
<html>
    <head>
        <title>Carga Aprobada</title>
    </head>
    <body>
        <p>La carga ha sido <strong>APROBADA</strong></p>
        <br/>
        <p>Los datos de la carga son los siguientes: </p>
        <p><strong>Comentarios de CCV: </strong>{{ $data['message_approval'] }}</p>
        <p><strong>Número de Vuelo: </strong>{{ $data['flight_number'] }}</p>
        <p><strong>STD: </strong>{{ $data['std'] }}</p>
        <p><strong>Ruta: </strong>{{ $data['from'] }} - {{ $data['to'] }}</p>
        <p><strong>Número de piezas: </strong>{{ $data['piecesNumber'] }}</p>
        <p><strong>Peso Total: </strong>{{ $data['weight'] }}</p>
        <p><strong>Envía: </strong>{{ $data['send'] }}</p>
        <p><strong>Descripción: </strong>{{ $data['description'] }}</p>
        <p><strong>Método de aseguramiento: </strong>{{ $data['assurance'] }}</p>
        <p><strong>Embalaje: </strong>{{ $data['packing'] }}</p>
    </body>
</html>
