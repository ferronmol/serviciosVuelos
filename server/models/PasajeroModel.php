<?php
//tendre que usar getPDO() para obtener la conexion a la base de datos
require_once __DIR__ . '/../db/DB.php';

/**
 * *********************USUARIOS**********************************************
 * Clase Pasajero: Representa un pasajero de la aplicación.
 */
class Pasajero
{
    private $pasajerocod;
    private $nombre;
    private $tlf;
    private $direccion;
    private $pais;

    /**
     * Constructor de la clase Pasajero
     * @param int $pasajerocod Código del pasajero
     * @param string $nombre Nombre del pasajero
     * @param string $tlf Teléfono del pasajero
     * @param string $direccion Dirección del pasajero
     * @param string $pais País del pasajero
     */
    public function __construct($pasajerocod, $nombre, $tlf, $direccion, $pais)
    {
        $this->pasajerocod = $pasajerocod;
        $this->nombre = $nombre;
        $this->tlf = $tlf;
        $this->direccion = $direccion;
        $this->pais = $pais;
    }
    public function getPasajerocod()
    {
        return $this->pasajerocod;
    }
    public function getNombre()
    {
        return $this->nombre;
    }
    public function getTlf()
    {
        return $this->tlf;
    }
    public function getDireccion()
    {
        return $this->direccion;
    }
    public function getPais()
    {
        return $this->pais;
    }
}


/** 
 * Clase PasajeroModel: Representa el modelo (Lógica de negocio) de los pasajeros.
 * @param DB $db Instancia de la clase DB
 */

class PasajeroModel
{
    private $db;


    /** 
     * Constructor de la clase PasajeroModel.
     * @param DB $db Instancia de la clase DB
     * @throws Exception Si no se puede conectar con la base de datos salta una excepción
     */

    public function __construct(DB $db)
    {
        $this->db = $db;


        // Verificar la conexión y manejar errores
        try {
            $pdoInstance = $this->db->getPDO();

            if ($pdoInstance == null) {
                throw new Exception("No estás conectado con la base de datos ");
            }
        } catch (PDOException $e) {
            // Manejar errores de conexión PDO si es necesario
            throw new Exception("Error de conexión con la base de datos: " . $e->getMessage());
        }
    }

    /**
     *
     * Método para abrir la base de datos
     * @return PDO
     */
    public function abrirBD()
    {
        $this->db->getPDO();
    }
    /**
     * Método para cerrar la base de datos
     */
    public function cierroBD()
    {
        $this->db->cierroBD();
    }


    /** 
     * Método para obtener todos los pasajeros
     * @return array $pasajeros Array de objetos Pasajero
     * @throws Exception Si no se puede conectar con la base de datos salta una excepción
     */
    public function getAllPasajeros()
    {
        try {
            $sql = "SELECT * FROM pasajeros";
            $stmt = $this->db->getPDO()->query($sql);
            $pasajeros = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $arrayPasajeros = [];
            foreach ($pasajeros as $pasajero) {
                $arrayPasajeros[] = new Pasajero($pasajero['pasajerocod'], $pasajero['nombre'], $pasajero['tlf'], $pasajero['direccion'], $pasajero['pais']);
            }
            return $arrayPasajeros;
        } catch (PDOException $ex) {
            throw new RuntimeException('Error al obtener los pasajeros de la base de datos');
            return null;
        }
    }



    /**
     * Método para obtener todos los datos de un pasajaero a traves de su pasajerocod
     * @param int $pasajerocod Código del pasajero
     * @return Pasajero $pasajero Objeto Pasajero
     * @throws Exception Si no se puede conectar con la base de datos salta una excepción
     */

    public function getPasajero($pasajerocod)
    {
        try {
            $sql = "SELECT * FROM pasajeros WHERE pasajerocod = :pasajerocod";
            $stmt = $this->db->getPDO()->prepare($sql);
            $stmt->execute(['pasajerocod' => $pasajerocod]);
            $pasajero = $stmt->fetch(PDO::FETCH_ASSOC);
            return new Pasajero($pasajero['pasajerocod'], $pasajero['nombre'], $pasajero['tlf'], $pasajero['direccion'], $pasajero['pais']);
        } catch (PDOException $ex) {
            throw new RuntimeException('Error al obtener el pasajero de la base de datos');
            return null;
        }
    }
}
