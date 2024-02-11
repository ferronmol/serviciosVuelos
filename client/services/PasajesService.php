<?php

class PasajesService
{

    /**
     * Inserta un pasaje en la base de datos.   
     * @param object $pasaje Pasaje a insertar.
     */
    public function insertarPasaje($pasaje)
    {
        if (!isset($pasaje) || empty($pasaje) || $pasaje == null) {
            return "No se ha recibido un pasaje";
        }
        echo "Pasaje recibido en service: ";

        var_dump($pasaje);
        die();
        $urlmiservicio = "http://localhost:3000/server/pasaje.php";
        $conexion = curl_init();
        //Url de la petición
        curl_setopt($conexion, CURLOPT_URL, $urlmiservicio);
        //Tipo de petición POST para insertar
        curl_setopt($conexion, CURLOPT_POST, TRUE);
        //Tipo de contenido de la respuesta
        curl_setopt($conexion, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        //para recibir una respuesta
        curl_setopt($conexion, CURLOPT_RETURNTRANSFER, true);
        //para enviar datos
        curl_setopt($conexion, CURLOPT_POSTFIELDS, json_encode($pasaje)); //CONVERTIMOS EL ARRAY A JSON
        $res = curl_exec($conexion);
        //$res es la respuesta del servidor
        if (curl_errno($conexion)) {
            return 'Error en la conexión cURL: ' . curl_error($conexion);
        }
        return $res;
        curl_close($conexion);
    }
}
