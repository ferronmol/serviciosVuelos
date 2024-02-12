<?php

class BookingService
{

    /**
     * Inserta un pasaje en la base de datos. POST
     * @param object $pasaje Pasaje a insertar.
     */
    public function InsertBooking($booking)
    {
        if (!isset($booking) || empty($booking) || $booking == null) {
            return "No se ha recibido un pasaje";
        }
        //convierto los pasajes a json
        $booking = json_encode($booking);
        $urlmiservicio = "http://localhost/serviciosVuelos/server/Booking.php";
        $conexion = curl_init();
        //Url de la petición
        curl_setopt($conexion, CURLOPT_URL, $urlmiservicio);
        //Tipo de petición POST para insertar
        curl_setopt($conexion, CURLOPT_POST, TRUE);
        //Tipo de contenido de la respuesta
        curl_setopt($conexion, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        curl_setopt($conexion, CURLOPT_HTTPHEADER, array('Content-Length: ' . strlen($booking)));
        //para recibir una respuesta
        curl_setopt($conexion, CURLOPT_RETURNTRANSFER, true);
        //para enviar datos, pongo los campos en el cuerpo de la petición
        curl_setopt($conexion, CURLOPT_POSTFIELDS, $booking);
        $res = curl_exec($conexion);
        //var_dump($res);
        //lo guardo en la sesion
        $_SESSION['message'] = $res;
        //$res es la respuesta del servidor
        if (curl_errno($conexion)) {
            $error = 'Error en la conexión cURL: ' . curl_error($conexion);
            curl_close($conexion);
            return $error;
        }
        // Obtener información sobre la respuesta HTTP
        $httpCode = curl_getinfo($conexion, CURLINFO_HTTP_CODE);

        // Cerrar la conexión cURL
        curl_close($conexion);
        // Verificar el código de respuesta HTTP
        if ($httpCode >= 200 && $httpCode < 300) {
            // Éxito (código de respuesta 2xx)
            return json_decode($res, true);
        } else {
            // Error en la respuesta del servidor
            return 'Error en la respuesta del servidor. Código HTTP: ' . $httpCode;
        }
    }
    /**
     * Borra un pasaje de la base de datos. DELETE
     * @param int $idpasaje Identificador del pasaje a borrar.
     */
    public function DeleteBooking($idpasaje)
    {
        if (!isset($idpasaje) || empty($idpasaje) || $idpasaje == null) {
            return "No se ha recibido un pasaje";
        }
        $urlmiservicio = "http://localhost/serviciosVuelos/server/Booking.php?idpasaje=" . $idpasaje;
        $conexion = curl_init();
        //Url de la petición
        curl_setopt($conexion, CURLOPT_URL, $urlmiservicio);
        //Tipo de petición DELETE para borrar
        curl_setopt($conexion, CURLOPT_CUSTOMREQUEST, "DELETE");
        //para recibir una respuesta
        curl_setopt($conexion, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($conexion);
        //lo guardo en la sesion
        $_SESSION['message'] = $res;
        //$res es la respuesta del servidor
        if (curl_errno($conexion)) {
            $error = 'Error en la conexión cURL: ' . curl_error($conexion);
            curl_close($conexion);
            return $error;
        }
        // Obtener información sobre la respuesta HTTP
        $httpCode = curl_getinfo($conexion, CURLINFO_HTTP_CODE);

        // Cerrar la conexión cURL
        curl_close($conexion);
        // Verificar el código de respuesta HTTP
        if ($httpCode >= 200 && $httpCode < 300) {
            // Éxito (código de respuesta 2xx)
            return json_decode($res, true);
        } else {
            // Error en la respuesta del servidor
            return 'Error en la respuesta del servidor. Código HTTP: ' . $httpCode;
        }
    }
}
