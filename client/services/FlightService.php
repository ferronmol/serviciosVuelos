<?php
class FlightService
{
    /******************  G E T *************************************
     * Metodo que pide al servidor la información de todos los vuelos
     * 
     */

    public function request()
    {
        $urlmiservicio = "http://localhost/_servWeb/serviciosVuelos/Flight.php";
        $conexion = curl_init();
        //Url de la petición
        curl_setopt($conexion, CURLOPT_URL, $urlmiservicio);
        //Tipo de petición
        curl_setopt($conexion, CURLOPT_HTTPGET, TRUE);
        //Tipo de contenido de la respuesta, espera un array
        curl_setopt($conexion, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        //para recibir una respuesta
        curl_setopt($conexion, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($conexion);
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

    /*********** G  E   T *************************************
     * Metodo que pide al servidor la información de un vuelo concreto
     * @param $identificador identificador del vuelo
     * @return Array bidemensional 
     */
    public function requestFlightId($identificador)
    {
        //var_dump($identificador);
        //codificamos el identificador para que no de problemas en la url
        $urlmiservicio = "http://localhost/_servWeb/serviciosVuelos/Flight.php?identificador=" . $identificador;
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
            // return $res sin el true  si queiro un objeto
            $resArray =  json_decode($res, true);
            curl_close($conexion);
            return $resArray;
        }
    }

    /*********** D E L E T E *************************************
     * Metodo que pide al servidor que borre un vuelo
     * @param $idVuelo identificador del vuelo
     * @return void
     */
    public function deleteFlight($idVuelo)
    {
        $urlmiservicio = "http://localhost/_servWeb/serviciosVuelos/Flight.php?id=" . $idVuelo;
        $conexion = curl_init();
        //Url de la petición
        curl_setopt($conexion, CURLOPT_URL, $urlmiservicio);
        //Tipo de petición
        curl_setopt($conexion, CURLOPT_CUSTOMREQUEST, "DELETE");
        //Tipo de contenido de la respuesta
        curl_setopt($conexion, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        //para recibir una respuesta
        curl_setopt($conexion, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($conexion);
        if ($res) {

            $resArray =  json_decode($res, true); //array asociativo
            // return $res; si queiro un objeto
            // $res = json_decode($res); //objeto
            curl_close($conexion);
            return $resArray;
        }
    }
}
