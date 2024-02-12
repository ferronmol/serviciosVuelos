<?php
require_once("./models/VuelosModel.php");
header("Content-Type: application/json");


// si recibo una peticion de tipo GET

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // si recibo un identificador
    if (isset($_GET['identificador'])) {
        // obtengo el identificador
        $identificador = $_GET['identificador'];
        // creo una instancia de VuelosModel
        $vuelosModel = new VuelosModel(new DB());
        // obtengo todo lo de un vuelo con el indentificador
        $vuelo  = $vuelosModel->getAllVuelos($identificador);
        // si el vuelo no existe
        if ($vuelo == null) {
            // devuelvo un error
            http_response_code(404);
            echo json_encode(['error' => 'El vuelo no existe']);
        } else {
            // devuelvo el vuelo en formato json
            echo json_encode($vuelo);
            exit();
        }
    } else {
        //obtengo todos los vuelos
        $vuelosModel = new VuelosModel(new DB());
        $vuelos = $vuelosModel->getAllVuelos();
        //var_dump($vuelos);
        // devuelvo los vuelos en formato json
        echo json_encode($vuelos);
        exit();
    }
}

header("HTTP/1.1 400 Bad Request");
