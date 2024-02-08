<?php
require_once 'models/vuelosModel.php';
header("Content-Type: application/json");
// si recibo una peticion de tipo get
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // si recibo un id
    if (isset($_GET['identificador'])) {
        // obtengo el id
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
            // devuelvo el vuelo
            echo json_encode($vuelo);
        }
    } else {
        //obtengo todos los vuelos
        $vuelosModel = new VuelosModel(new DB());
        $vuelos = $vuelosModel->getAllVuelos();
        // devuelvo los vuelos
        echo json_encode($vuelos);
    }
}
