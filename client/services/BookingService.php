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
     * Método qeu pide todos los pasajes al servicio o opcionalemnte uno si se le pasa el id. GET
     */
    public function GetBookings($idpasaje = null)
    {
        if ($idpasaje == null) {
            $urlmiservicio = "http://localhost/serviciosVuelos/server/Booking.php";
        } else {
            $urlmiservicio = "http://localhost/serviciosVuelos/server/Booking.php?idpasaje=" . $idpasaje;
        }
        $conexion = curl_init();
        //Url de la petición
        curl_setopt($conexion, CURLOPT_URL, $urlmiservicio);
        //Tipo de petición
        curl_setopt($conexion, CURLOPT_HTTPGET, true);
        //tipo de contenido de la respuesta
        curl_setopt($conexion, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        //para recibir una respuesta
        curl_setopt($conexion, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($conexion);
        //$res es la respuesta del servidor , en los get no se  convierte a json     
        // Verificar errores
        if ($res === false) {
            echo "Error en la solicitud: " . curl_error($conexion);
            return false;
        }

        // Verificar el código de estado HTTP
        $httpCode = curl_getinfo($conexion, CURLINFO_HTTP_CODE);
        if ($httpCode !== 200) {
            echo "Error en la respuesta del servidor (código $httpCode)";
            return false;
        }

        // Cerrar la conexión
        curl_close($conexion);

        // Devolver la respuesta
        return $res;
    }





    /**
     * Borra un pasaje de la base de datos. DELETE
     * @param int $idpasaje Identificador del pasaje a borrar.
     */
    public function DeleteBooking($idpasaje)
    {
        if (!isset($idpasaje)) {
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
        //$res es la respuesta del servidor
        $res = curl_exec($conexion);
        var_dump($res); //para ver bien el tipo de respuesta.es cadena
        //lo guardo en la sesion
        $_SESSION['message-delete'] = $res;
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
     * Actualiza un pasaje en la base de datos. PUT
     * @param Array asociativo $booking Pasaje a actualizar.
     * @return string Mensaje de confirmación o error.
     */
    public function UpdateBooking($booking)
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
        //Tipo de petición PUT para actualizar
        curl_setopt($conexion, CURLOPT_CUSTOMREQUEST, "PUT");
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
        $_SESSION['message-update'] = $res;
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
