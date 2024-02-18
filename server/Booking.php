<?php
require_once("./models/BookingModel.php");
$booking = new BookingModel();

header("Content-Type: application/json");

/************* P O S T ***************************
 * Endpoint: server/pasaje.php
 * Método: POST
 * Descripción: Inserta un pasaje en la base de datos.
 */

// Verificar que la solicitud sea de tipo POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener el cuerpo JSON de la solicitud
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    // var_dump($data);

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
    $resultado = $booking->insertBooking($pasaje);

    // Devolver el resultado como respuesta
    echo $resultado;
}

/*****************  G  E  T   ******************************
 * Endpoint: server/booking.php
 * Método: GET
 * Decripción: Obtiene todos los pasajes o un pasaje en particular.
 * @param int $idpasaje (opcional) El id del pasaje a obtener.
 */
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    //si recibo un idpasaje
    if (isset($_GET['idpasaje'])) {
        $res = $booking->getAllBookings($_GET['idpasaje']);
        //si el pasaje no existe
        if ($res == null) {
            //devuelvo un error
            http_response_code(404);
            echo json_encode(['error' => 'El pasaje no existe']);
        } else {
            //devuelvo el pasaje en formato json
            echo json_encode($res);
            exit();
        }
    } else {
        //obtengo todos los pasajes
        $res = $booking->getAllBookings();
        //devuelvo los pasajes en formato json
        echo json_encode($res);
        exit();
    }
}

/**************   D  E  L  E  T  E  *******************************
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
    $resultado = $booking->deleteBooking($idpasaje);
    // Devolver el resultado como respuesta
    echo $resultado;
    exit();
}
/*****************   P  U  T   **************************************
 * Endpoint: server/booking.php
 * Método: PUT
 * Descripción: Actualiza un pasaje en la base de datos.
 *  Recibe un objeto JSON con los datos del pasaje a actualizar.
 * Tiene que mandar un objeto de tipo pasaje con todos los campos.
 */
if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    // Obtener el cuerpo JSON de la solicitud
    $post = json_decode(file_get_contents('php://input'), true);
    $response = $booking->updateBooking($post); //response es lo que devuelve el modelo
    //$result['mensaje'] = $response; si quiero devolver con una clave 'mensaje'
    echo json_encode($response);
    exit();
}
//en caso de que no sea ninguna de las anteriores
header("HTTP/1.1 400 Bad Request");
