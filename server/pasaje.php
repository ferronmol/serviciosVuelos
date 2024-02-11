<?php
require_once("./models/PasajeModel.php");
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
    $requiredFields = ['pasajeroCod', 'identificador', 'numAsiento', 'clase', 'pvp'];

    foreach ($requiredFields as $field) {
        if (!isset($data[$field])) {
            $response = ['error' => 'Falta el campo ' . $field . ' en la solicitud POST'];
            echo json_encode($response);
            exit;
        }
    }

    // Crear un objeto Pasaje con los datos recibidos
    $pasaje = new Pasaje(
        null,
        $data['pasajeroCod'],
        $data['identificador'],
        $data['numAsiento'],
        $data['clase'],
        $data['pvp']
    );

    // Crear una instancia de PasajeModel
    $pasajeModel = new PasajeModel(new DB(/* Configuración de la base de datos */));

    // Insertar el pasaje y obtener el mensaje de resultado
    $resultado = $pasajeModel->insertarPasaje($pasaje);

    // Devolver el resultado como respuesta (puedes adaptar esto según tus necesidades)
    echo $resultado;
}
