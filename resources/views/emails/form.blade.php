<!DOCTYPE html>
<html>
    <head>
        <title>Envío de Solicitud</title>
    </head>
    <body>
        <p>La solicitud de envío de carga ha sido diligenciada satisfactoriamente, el equipo del centro de control está evaluando la información.</p>
        <br/>
        <p>Los datos enviados son los siguiente: </p>
        <br/>
        <p><strong>Número de Vuelo: </strong>{{ $data['flightNumber'] }}</p>
        <p><strong>STD: </strong>{{ $data['std'] }}</p>
        <p><strong>Ruta: </strong>{{ $data['from'] }} - {{ $data['to'] }}</p>
        <p><strong>Piezas totales: </strong>{{ $data['pieces'] }}</p>
        <p><strong>Peso Total: </strong>{{ $data['weight'] }}</p>
        <p><strong>Volumen Total: </strong>{{ $data['volume'] }}</p>
        <p><strong>Descripción: </strong>{{ $data['description'] }}</p>
        <p><strong>Método de aseguramiento: </strong>{{ $data['assurance'] }}</p>
        <p><strong>Embalaje: </strong>{{ $data['packing'] }}</p>
    </body>
</html>
