<!DOCTYPE html>
<html>
    <head>
        <title>Envío de solicitud Aerocharter</title>
    </head>
    <body>
        <p>Su solicitud de envío de carga ha sido diligenciada satisfactoriamente, el equipo del centro de control está evaluando la información.</p>
        <br/>
        <p>Los datos enviados son los siguiente: </p>
        <br/>
        <p><strong>Número de Vuelo: </strong>{{ $data['flightNumber'] }}</p>
        <p><strong>STD: </strong>{{ $data['std'] }}</p>
        <p><strong>Aeropuerto de salida: </strong>{{ $data['from'] }}</p>
        <p><strong>Aeropuerto de llegada: </strong>{{ $data['to'] }}</p>
        <p><strong>Piezas totales: </strong>{{ $data['pieces'] }}</p>
        <p><strong>Peso Total: </strong>{{ $data['weight'] }} Kg</p>
        <p><strong>Volumen Total: </strong>{{ $data['volume'] }} MC</p>
        <p><strong>Descripción: </strong>{{ $data['description'] }}</p>
        <p><strong>Método de aseguramiento: </strong>{{ $data['assurance'] }}</p>
        <p><strong>Embalaje: </strong>{{ $data['packing'] }}</p>
    </body>
</html>
