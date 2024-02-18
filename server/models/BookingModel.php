<?php
include_once './db/DB.php';

/**
 * CLASE BOOKING
 * Clase Booking: Representa un pasaje de la aplicación.
 
 */
class Booking
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
 * Clase BookingModel: Representa el modelo (Lógica de negocio) de los pasajes.
 * extends DB
 */

class BookingModel extends DB
{
    private $conexion;
    private $table;


    /**
     * Constructor de la clase BookingModel.
     * @return void
     */
    public function __construct()
    {
        $this->table = "pasaje";
        $this->conexion = $this->getConexion();
    }

    /**
     * Método para verificar si el pasajero ya existe en el vuelo
     * @param int $pasajeroCod Código del pasajero
     * @param string $identificador Código del vuelo
     * @return bool true si el pasajero ya existe, false en caso contrario
     */
    public function checkExistingPassenger($pasajeroCod, $identificador)
    {
        try {
            // Obtener la conexión PDO

            $sql = "SELECT COUNT(*) FROM $this->table WHERE pasajerocod = ? AND identificador = ?";
            // Realizar la consulta SQL para verificar la existencia del pasajero en el vuelo
            $stmt = $this->conexion->prepare($sql);
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
    public function checkOccupiedSeat($numAsiento, $identificador)
    {
        try {

            $sql = "SELECT COUNT(*) FROM $this->table WHERE numasiento = ? AND identificador = ?";
            // Realizar la consulta SQL para verificar si el asiento está ocupado en el vuelo
            $stmt = $this->conexion->prepare($sql);
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
    public function insertBooking($pasaje)
    {
        try {


            // Realizar las comprobaciones antes de insertar
            $pasajeroExistente = $this->checkExistingPassenger($pasaje->getPasajerocod(), $pasaje->getIdentificador());
            $asientoOcupado = $this->checkOccupiedSeat($pasaje->getNumasiento(), $pasaje->getIdentificador());

            // Si el pasajero o el asiento ya existen, devolver mensaje de error específico
            if ($pasajeroExistente && $asientoOcupado) {
                return "El pasajero '" . $pasaje->getPasajerocod() . "' ya tiene otro asiento en el vuelo '" . $pasaje->getIdentificador() . "' y el asiento '" . $pasaje->getNumasiento() . "' ya está ocupado.";
            } elseif ($pasajeroExistente) {
                return "ERROR AL INSERTAR. EL PASAJERO . '" . $pasaje->getPasajerocod() . "' YA TIENE OTRO ASIENTO EN EL VUELO '" . $pasaje->getIdentificador() . "'";
            } elseif ($asientoOcupado) {
                return "ERROR AL INSERTAR. EL Nº DE ASIENTO '" . $pasaje->getNumasiento() . "' YA ESTÁ OCUPADO EN EL VUELO '" . $pasaje->getIdentificador() . "'";
            }

            // Insertar el pasaje

            $sql = "INSERT INTO pasaje (pasajerocod, identificador, numasiento, clase, pvp) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([$pasaje->getPasajerocod(), $pasaje->getIdentificador(), $pasaje->getNumasiento(), $pasaje->getClase(), $pasaje->getPvp()]);

            // Devolver mensaje de éxito
            return "REGISTRO INSERTADO CORRECTAMENTE";
        } catch (PDOException $e) {
            // Si hay un error SQL, devolver el mensaje correspondiente
            return "Error SQL: " . $e->getMessage();
        }
    }
    /**
     * Método para obtener todos los pasajes
     * @param int $idpasaje Identificador del pasaje a obtener (opcional)
     * @return array Array de objetos Pasaje
     */
    public function getAllBookings($idpasaje = null)
    {

        $bookingsArray = array();

        try {
            $sql = "SELECT * FROM pasaje";
            if ($idpasaje !== null) {
                $sql .= " WHERE idpasaje = :idpasaje";
            }
            $sql .= " ORDER BY idpasaje";
            //ojo esto es necesario para que funcione el if de arriba
            if ($idpasaje !== null) {
                $statement = $this->conexion->prepare($sql);
                $statement->bindParam(':idpasaje', $idpasaje, PDO::PARAM_INT);
            } else {
                $statement = $this->conexion->prepare($sql);
            }
            $statement->execute();
            $pasajes = $statement->fetchAll(PDO::FETCH_ASSOC);
            $statement = null;

            foreach ($pasajes as $pasaje) {
                $booking = array(
                    'idpasaje' => $pasaje['idpasaje'],
                    'pasajerocod' => $pasaje['pasajerocod'],
                    'identificador' => $pasaje['identificador'],
                    'numasiento' => $pasaje['numasiento'],
                    'clase' => $pasaje['clase'],
                    'pvp' => $pasaje['pvp']
                );
                array_push($bookingsArray, $booking);
            }

            return $bookingsArray;
        } catch (PDOException $e) {
            throw new Exception("Error SQL: " . $e->getMessage());
        }
    }
    /**
     * Método para eliminar un pasaje a través de su idpasaje
     * @param int $idpasaje Identificador del pasaje a eliminar
     * @return string Mensaje indicando el resultado de la operación
     */
    public function deleteBooking($idpasaje)
    {
        try {
            $sql = "SELECT * FROM pasaje WHERE idpasaje = ?";

            // Realizar la consulta SQL para eliminar el pasaje
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([$idpasaje]);
            //verifico si se elimino algun registro
            if ($stmt->rowCount() == 0) {
                return "ERROR AL ELIMINAR EL PASAJE CON ID " . $idpasaje;
            }
            // Devolver mensaje de éxito
            return "REGISTRO ELIMINADO CORRECTAMENTE";
        } catch (PDOException $e) {
            // Si hay un error SQL, devolver el mensaje correspondiente
            return "Error SQL: " . $e->getMessage();
        }
    }
    /**
     * Método para actualizar un pasaje
     * @param array $data Array asociativo con los datos del pasaje a actualizar
     * @return string Mensaje indicando el resultado de la operación
     */

    public function updateBooking($pasaje)
    {
        try {
            // Realizar las comprobaciones antes de insertar
            $pasajeroExistente = $this->checkExistingPassenger($pasaje['pasajerocod'], $pasaje['identificador']);
            $asientoOcupado = $this->checkOccupiedSeat($pasaje['numasiento'], $pasaje['identificador']);
            // Si el pasajero o el asiento ya existen, devolver mensaje de error específico
            if ($pasajeroExistente && $asientoOcupado) {
                return "El pasajero '" . $pasaje['pasajerocod'] . "' ya tiene otro asiento en el vuelo '" . $pasaje['identificador'] . "' y el asiento '" . $pasaje['numasiento'] . "' ya está ocupado.";
            } elseif ($pasajeroExistente) {
                return "ERROR AL ACTUALIZAR. EL PASAJERO '" . $pasaje['pasajerocod'] . "' YA TIENE OTRO ASIENTO EN EL VUELO '" . $pasaje['identificador'] . "'";
            } elseif ($asientoOcupado) {
                return "ERROR AL ACTUALIZAR. EL Nº DE ASIENTO '" . $pasaje['numasiento'] . "' YA ESTÁ OCUPADO EN EL VUELO '" . $pasaje['identificador'] . "'";
            }

            // Realizar la consulta SQL para actualizar el pasaje
            $sql = "UPDATE pasaje SET pasajerocod = ?, identificador = ?, numasiento = ?, clase = ?, pvp = ? WHERE idpasaje = ?";
            $stmt = $this->conexion->prepare($sql);

            // Extraer los parámetros del array asociativo y bindearlos directamente
            $stmt->bindParam(1, $pasaje['pasajerocod']);
            $stmt->bindParam(2, $pasaje['identificador']);
            $stmt->bindParam(3, $pasaje['numasiento']);
            $stmt->bindParam(4, $pasaje['clase']);
            $stmt->bindParam(5, $pasaje['pvp']);
            $stmt->bindParam(6, $pasaje['idpasaje']);

            // Ejecutar la consulta
            $num = $stmt->execute();

            // Verificar si se actualizó algún registro
            if ($stmt->rowCount() == 0) {
                return "NO ACTUALIZADO, SIN CAMBIOS O NO EXISTE EL PASAJE " . $pasaje['idpasaje'];
            } else {
                return "REGISTRO ACTUALIZADO: " . $pasaje['idpasaje'];
            }
        } catch (PDOException $e) {
            // Si hay un error SQL, devolver el mensaje correspondiente
            return "Error SQL: " . $e->getMessage();
        }
    }
}
