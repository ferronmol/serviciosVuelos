<?php
require_once './config/Config.php';

/**
 * Clase abstracta que representa la conexión a la base de datos.
 * @version 1.0
 */
abstract class DB
{

    private $conexion;
    private $mensajeerror;


    /**
     * Método que obtiene la conexión a la base de datos.
     * @return PDO|null Retorna la conexión a la base de datos o null si no se pudo conectar.
     */
    public function getConexion()
    {

        $host = DB_HOST;
        $databaseName = DB_NAME;
        $user = DB_USER;
        $password = DB_PASSWORD;

        try {
            // Crea una instancia de PDO para conectarse a la base de datos
            $this->conexion =
                new PDO("mysql:host=$host;dbname=$databaseName;charset=utf8", $user, $password);

            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conexion;
        } catch (PDOException $ex) {
            $this->mensajeerror = $ex->getMessage();
            return null;
        }
    }
    /**
     * Método que obtiene el mensaje de error.
     * @return string Retorna el mensaje de error.
     */
    public function getMensajeError()
    {
        return $this->mensajeerror;
    }

    /**
     * Método que cierra la conexión a la base de datos.
     * @return void
     */

    public function closeConexion()
    {
        $this->conexion = null;
    }
}
