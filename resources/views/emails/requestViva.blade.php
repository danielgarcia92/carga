<!DOCTYPE html>
<html>
    <head>
        <title>Envío de Solicitud Comat</title>
    </head>
    <body>
        La solicitud de envío Comat ha sido diligenciada satisfactoriamente, el equipo del centro de control de Viva Aerobus está evaluando la información.
        <br/>
        <p>Los datos enviados son los siguientes: </p>
        <p><strong>Número de Vuelo: </strong>{{ $data['flight_number'] }}</p>
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
