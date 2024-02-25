<?php

class PassenguerService
{

    public function GetPassenguer($pasajerocod = null)
    {
        if ($pasajerocod == null) {
            $url = "http://localhost/_servWeb/serviciosVuelos/Passenguer.php";
        } else {
            $url = "http://localhost/_servWeb/serviciosVuelos/Passenguer.php?pasajerocod=" . $pasajerocod;
        }
        $conexion = curl_init();
        //Url de la petición
        curl_setopt($conexion, CURLOPT_URL, $url);
        //Tipo de petición
        curl_setopt($conexion, CURLOPT_HTTPGET, true);
        //tipo de contenido de la respuesta
        curl_setopt($conexion, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        //para recibir una respuesta
        curl_setopt($conexion, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($conexion);
        //var_dump($res); //para ver bien el tipo de respuesta.es cadena
        //$res es la respuesta del servidor , en los get no se  convierte a json     
        // Verificar errores
        if ($res === false) {
            //lo guarodamos en la sesion
            $_SESSION['message-insert'] = "Error en la solicitud: " . curl_error($conexion);
            //echo "Error en la solicitud: " . curl_error($conexion);
            return false;
        }
        // Verificar el código de estado HTTP
        $httpCode = curl_getinfo($conexion, CURLINFO_HTTP_CODE);
        if ($httpCode !== 200) {
            //lo guarodamos en la sesion
            $_SESSION['message-insert'] = "Error en la respuesta del servidor (código $httpCode)";
            // echo "Error en la respuesta del servidor (código $httpCode)";
            return false;
        }

        // Cerrar la conexión
        curl_close($conexion);

        // Devolver la respuesta
        return $res;
    }
}
