<?php
//tendre que usar getPDO() para obtener la conexion a la base de datos
require_once __DIR__ . '/../db/DB.php';

/**
 * CLASE PASAJE
 * Clase Pasaje: Representa un pasaje de la aplicación.
 
 */
class Pasaje
{
    private $idpasaje;
    private $pasajerocod;
    private $identificador;
    private $numasiento;
    private $clase;
    private $pvp;


    /**
     * constructor de la clase Pasaje
     * @param int $idpasaje Código del pasaje PK
     * @param int $pasajerocod Código del pasajero FK
     * @param string $identificador Código del vuelo FK
     * @param int $numasiento Número de asiento
     * @param string $clase Clase del asiento
     * @param float $pvp Precio del pasaje
     */

    public function __construct($idpasaje, $pasajerocod, $identificador, $numasiento, $clase, $pvp)
    {
        $this->idpasaje = $idpasaje;
        $this->pasajerocod = $pasajerocod;
        $this->identificador = $identificador;
        $this->numasiento = $numasiento;
        $this->clase = $clase;
        $this->pvp = $pvp;
    }

    public function getIdpasaje()
    {
        return $this->idpasaje;
    }
    public function getPasajerocod()
    {
        return $this->pasajerocod;
    }
    public function getIdentificador()
    {
        return $this->identificador;
    }
    public function getNumasiento()
    {
        return $this->numasiento;
    }
    public function getClase()
    {
        return $this->clase;
    }
    public function getPvp()
    {
        return $this->pvp;
    }
}
/**
 * Clase PasajeModel: Representa el modelo (Lógica de negocio) de los pasajes.
 * @param DB $db Instancia de la clase DB
 */

class PasajeModel
{
    private $db;


    /**
     * Constructor de la clase PasajeModel.
     * @param DB $db Instancia de la clase DB
     * @throws Exception Si no se puede conectar a la base de datos
     */
    public function __construct($db)
    {
        $this->db = $db;
        try {
            $pdoInstance = $this->db->getPDO();
            if ($pdoInstance == null) {
                throw new Exception("No se ha podido conectar a la base de datos");
            }
        } catch (Exception $e) {
            throw new Exception("No se ha podido conectar a la base de datos");
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
     * Método para verificar si el pasajero ya existe en el vuelo
     * @param int $pasajeroCod Código del pasajero
     * @param string $identificador Código del vuelo
     * @return bool true si el pasajero ya existe, false en caso contrario
     */
    public function verificarPasajeroExistente($pasajeroCod, $identificador)
    {
        try {
            // Obtener la conexión PDO
            $pdo = $this->db->getPDO();

            // Realizar la consulta SQL para verificar la existencia del pasajero en el vuelo
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM pasaje WHERE pasajerocod = ? AND identificador = ?");
            $stmt->execute([$pasajeroCod, $identificador]);
            $count = $stmt->fetchColumn();

            // Devolver true si existe, false si no existe
            return ($count > 0);
        } catch (PDOException $e) {
            // Manejar errores de base de datos
            return false;
        }
    }

    /**
     * Método para verificar si el asiento está ocupado en el vuelo
     * @param int $numAsiento Número del asiento
     * @param string $identificador Código del vuelo
     * @return bool true si el asiento está ocupado, false en caso contrario
     */
    public function verificarAsientoOcupado($numAsiento, $identificador)
    {
        try {
            // Obtener la conexión PDO
            $pdo = $this->db->getPDO();

            // Realizar la consulta SQL para verificar si el asiento está ocupado en el vuelo
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM pasaje WHERE numasiento = ? AND identificador = ?");
            $stmt->execute([$numAsiento, $identificador]);
            $count = $stmt->fetchColumn();

            // Devolver true si está ocupado, false si no está ocupado
            return ($count > 0);
        } catch (PDOException $e) {
            // Manejar errores de base de datos
            return false;
        }
    }
    /**
     * Método para insertar un pasaje a un vuelo
     * @param Pasaje $pasaje Objeto Pasaje a insertar
     * @return string Mensaje indicando el resultado de la operación
     */
    public function insertarPasaje($pasaje)
    {
        try {
            // Obtener la conexión PDO
            $pdo = $this->db->getPDO();

            // Realizar las comprobaciones antes de insertar
            $pasajeroExistente = $this->verificarPasajeroExistente($pasaje->getPasajerocod(), $pasaje->getIdentificador());
            $asientoOcupado = $this->verificarAsientoOcupado($pasaje->getNumasiento(), $pasaje->getIdentificador());

            // Si el pasajero o el asiento ya existen, devolver mensaje de error específico
            if ($pasajeroExistente && $asientoOcupado) {
                return "El pasajero '" . $pasaje->getPasajerocod() . "' ya tiene otro asiento en el vuelo '" . $pasaje->getIdentificador() . "' y el asiento '" . $pasaje->getNumasiento() . "' ya está ocupado.";
            } elseif ($pasajeroExistente) {
                return "ERROR AL INSERTAR. EL PASAJERO . '" . $pasaje->getPasajerocod() . "' YA TIENE OTRO ASIENTO EN EL VUELO '" . $pasaje->getIdentificador() . "'";
            } elseif ($asientoOcupado) {
                return "ERROR AL INSERTAR. EL Nº DE ASIENTO '" . $pasaje->getNumasiento() . "' YA ESTÁ OCUPADO EN EL VUELO '" . $pasaje->getIdentificador() . "'";
            }

            // Insertar el pasaje
            $stmt = $pdo->prepare("INSERT INTO pasaje (pasajerocod, identificador, numasiento, clase, pvp) 
                                   VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$pasaje->getPasajerocod(), $pasaje->getIdentificador(), $pasaje->getNumasiento(), $pasaje->getClase(), $pasaje->getPvp()]);

            // Devolver mensaje de éxito
            return "REGISTRO INSERTADO CORRECTAMENTE";
        } catch (PDOException $e) {
            // Si hay un error SQL, devolver el mensaje correspondiente
            return "Error SQL: " . $e->getMessage();
        }
    }
}
