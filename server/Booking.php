<?php
require_once("./models/BookingModel.php");
header("Content-Type: application/json");

/**
 * Endpoint: server/pasaje.php
 * Método: POST
 * Decripción: Inserta un pasaje en la base de datos.
 */

// Verificar que la solicitud sea de tipo POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener el cuerpo JSON de la solicitud
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    // Verificar que todas las claves necesarias estén presentes
    $requiredFields = ['pasajerocod', 'identificador', 'numasiento', 'clase', 'pvp'];

    foreach ($requiredFields as $field) {
        if (!isset($data[$field])) {
            $response = ['error' => 'Falta el campo ' . $field . ' en la solicitud POST'];
            echo json_encode($response);
            exit;
        }
    }

    // Crear un objeto Pasaje con los datos recibidos
    $pasaje = new Booking(
        null,
        $data['pasajerocod'],
        $data['identificador'],
        $data['numasiento'],
        $data['clase'],
        $data['pvp']
    );

    // Crear una instancia de PasajeModel
    $pasajeModel = new BookingModel(new DB());

    // Insertar el pasaje y obtener el mensaje de resultado
    $resultado = $pasajeModel->insertBooking($pasaje);

    // Devolver el resultado como respuesta
    echo $resultado;
}
// Si la solicitud no es de tipo POST, devolver un error
else {
    header("HTTP/1.1 400 Bad Request");
    echo json_encode(['error' => 'Solicitud no válida']);
}
