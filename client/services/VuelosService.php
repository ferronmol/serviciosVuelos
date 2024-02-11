<?php


//vamos a pedirle al servidor qeu nos mande por get todos los vuelos usando curl
//y lo vamos a mostrar en la vista
class VuelosService
{

    function request()
    {
        echo "request";
        $urlmiservicio = "http://localhost:3000/server/vuelos.php";
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
        echo $res;
        if ($res === false) {
            echo "Error cURL: " . curl_error($conexion);
        }
        curl_close($conexion);
        return json_decode($res, true);
    }


    public function obtenerInfoVuelo($identificador)
    {
        $urlmiservicio = "http://localhost:3000/server/vuelos.php";
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
        if ($res === false) {
            echo "Error cURL: " . curl_error($conexion);
        }
        curl_close($conexion);
        $vuelos = json_decode($res, true);
        $vuelo = array();
        foreach ($vuelos as $v) {
            if ($v['identificador'] == $identificador) {
                $vuelo = $v;
            }
        }
        return $vuelo;
    }
}
