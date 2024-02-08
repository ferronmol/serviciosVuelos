<?php
$configFilePath = __DIR__ . '/../config/Config.php';
/*
* Verifica si existe el archivo de configuración.
*/
if (file_exists($configFilePath)) {
    require_once($configFilePath);
} else {
    throw new Exception('Config file not found');
    exit;
}
class DB
{
    private $pdo;

    /**
     * Constructor de la clase DB.
     * @param string $host Nombre del host
     * @param string $databaseName Nombre de la base de datos
     * @param string $user Nombre de usuario
     * @param string $password Contraseña
     * @throws Exception
     */

    public function __construct()
    {
        $host = DB_HOST;
        $databaseName = DB_NAME;
        $user = DB_USER;
        $password = DB_PASSWORD;

        try {
            // Crea una instancia de PDO para conectarse a la base de datos
            $dsn = "mysql:host=$host;dbname=$databaseName;charset=utf8";
            $this->pdo = new PDO($dsn, $user, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $ex) {
            header('Location: ../../../../client/views/errorView.php?error=Error en la conexión con la base de datos');
            throw new Exception('Se ha soltado algún cable del servidor de la base de datos');
        }
    }


    /**
     * Obtén la instancia de PDO para interactuar con la base de datos y realizar consultas.
     * @return PDO
     */
    public function getPDO()
    {
        return $this->pdo;
    }


    /**
     * Cierra la conexión con la base de datos
     * @return void
     */
    public function cierroBD()
    {
        $this->pdo = null;
    }

    /**
     * Verifica si la conexión con la base de datos está activa.
     * @return boolean
     * @throws Exception
     */
    public function verificarConexion()
    {
        try {
            $this->getPDO();
            return true;
        } catch (Exception $e) {

            return false;
        }
    }
}
