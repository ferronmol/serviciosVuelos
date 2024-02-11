<?php
class VuelosService
{
    /**
     * Metodo que pide al servidor la información de todos los vuelos
     */

    public function request()
    {
        echo "request";
        $urlmiservicio = "http://localhost:3000/server/Vuelos.php";
        $conexion = curl_init();
        //Url de la petición
        curl_setopt($conexion, CURLOPT_URL, $urlmiservicio);
        //Tipo de petición
        curl_setopt($conexion, CURLOPT_HTTPGET, TRUE);
        //Tipo de contenido de la respuesta
        curl_setopt($conexion, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        //para recibir una respuesta
        curl_setopt($conexion, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($conexion);
        if ($res) {
            echo "<br>Salida request_curl<br>";
            print_r($res);
        }
        curl_close($conexion);
    }

    /**
     * Metodo que pide al servidor la información de un vuelo concreto
     * @param $identificador identificador del vuelo
     */
    public function obtenerInfoVuelo($identificador)
    {
        var_dump($identificador);
        //codificamos el identificador para que no de problemas en la url
        $identificadorCod = urlencode($identificador);
        $urlmiservicio = "http://localhost:3000/server/Vuelos.php/?identificador=" . $identificadorCod;
        $conexion = curl_init();
        //Url de la petición
        curl_setopt($conexion, CURLOPT_URL, $urlmiservicio);
        //Tipo de petición
        curl_setopt($conexion, CURLOPT_HTTPGET, TRUE);
        //Tipo de contenido de la respuesta
        curl_setopt($conexion, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        //para recibir una respuesta
        curl_setopt($conexion, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($conexion);
        if ($res) {
            echo "<br>Salida request_curl<br>";
            print_r($res);
        }
        curl_close($conexion);
    }
}
