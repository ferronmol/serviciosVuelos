<?php
require_once("./models/BookingModel.php");
$pasajeModel = new BookingModel(new DB());
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

    // Insertar el pasaje y obtener el mensaje de resultado
    $resultado = $pasajeModel->insertBooking($pasaje);

    // Devolver el resultado como respuesta
    echo $resultado;
}

/**
 * Endpoint: server/booking.php
 * Método: GET
 * Decripción: Obtiene todos los pasajes o un pasaje en particular.
 * @param int $idpasaje (opcional) El id del pasaje a obtener.
 */
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    //si recibo un idpasaje
    if (isset($_GET['idpasaje'])) {
        // obtengo el idpasaje
        $idpasaje = $_GET['idpasaje'];
        // Obtener del modelo  todos los pasajes en un array asociativo
        $res = $pasajeModel->getAllBookings($idpasaje);
    } else {
        //si no recibo un idpasaje
        $res = $pasajeModel->getAllBookings();
    }
    // Devolver el resultado como JSON
    echo json_encode($res);
    exit();
}

/**
 * Endpoint: server/booking.php
 * Método: DELETE
 * Decripción: Elimina un pasaje de la base de datos a partir de su id.
 * @param int $idpasaje El id del pasaje a eliminar.
 */
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Verificar si se proporciona el parámetro idpasaje
    if (!isset($_GET['idpasaje'])) {
        header("HTTP/1.1 400 Bad Request");
        echo "Parámetro 'idpasaje' no proporcionado.";
        exit();
    }
    // Obtener el idpasaje de la solicitud
    $idpasaje = $_GET['idpasaje'];

    // Eliminar el pasaje y obtener el mensaje de resultado
    $resultado = $pasajeModel->deleteBooking($idpasaje);
    // Devolver el resultado como respuesta
    echo $resultado;
    exit();
}
