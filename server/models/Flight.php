<?php
require './models/FlightModel.php';
$flight = new FlightModel();

header("Content-Type: application/json");


/*************  G  E   T ***************************
 * Endpoint: server/Flight.php
 * Método: GET
 * Descripción: Obtiene todos los vuelos o un vuelo en particular.
 */

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // si recibo un identificador
    if (isset($_GET['identificador'])) {
        $res = $flight->getAllFlights($_GET['identificador']);
        // si el vuelo no existe
        if ($res == null) {
            // devuelvo un error
            http_response_code(404);
            echo json_encode(['error' => 'El vuelo no existe']);
        } else {
            // devuelvo el vuelo en formato json
            echo json_encode($res);
            exit();
        }
    } else {
        //obtengo todos los vuelos

        $res = $flight->getAllFlights();
        //var_dump($vuelos);
        // devuelvo los vuelos en formato json
        echo json_encode($res);
        exit();
    }
}

header("HTTP/1.1 400 Bad Request");
