<?php
require './db/DB.php';

/**
 * *********************VUELOS**********************************************
 * Clase Vuelo: Representa un vuelo de la aplicación.
 * @param int $identificador Código del vuelo
 * @param string $aeropuertoorigen Aeropuerto de origen del vuelo
 * @param string $aeropuertodestino Aeropuerto de destino del vuelo
 * @param string $tipovuelo Tipo de vuelo
 * @param string $fechavuelo Fecha del vuelo
 * @param float $descuento Descuento del vuelo
 */

class Flight
{
    private $identificador;
    private $aeropuertoorigen;
    private $aeropuertodestino;
    private $tipovuelo;
    private $fechavuelo;
    private $descuento;

    public function __construct($identificador, $aeropuertoorigen, $aeropuertodestino, $tipovuelo, $fechavuelo, $descuento)
    {
        $this->identificador = $identificador;
        $this->aeropuertoorigen = $aeropuertoorigen;
        $this->aeropuertodestino = $aeropuertodestino;
        $this->tipovuelo = $tipovuelo;
        $this->fechavuelo = $fechavuelo;
        $this->descuento = $descuento;
    }
}

/**
 * clase: FlightModel: Representa la clase que se encarga de la lógica de los vuelos.
 * extends DB
 */
class FlightModel extends DB
{
    private $conexion;
    private $table;

    /**
     * Constructor de la clase FlightModel
     * @return void
     */

    public function __construct()
    {
        $this->table = "vuelo";
        $this->conexion = $this->getConexion();

        if ($this->conexion == null) {
            throw new Exception("Error de conexión a la base de datos", 1);
        }
    }

    /**
     * Método para coger todos los vuelos
     * @param string $identificador Código del vuelo opcional
     * @return  Array de objetos Vuelo
     * @throws Exception
     * 
     */
    public function getFlights($identificador = null)
    {
        try {
            $sql = "SELECT * FROM vuelos";

            if ($identificador !== null) {
                $sql .= " WHERE identificador = :identificador";
            }
            $stmt = $this->conexion->prepare($sql);

            if ($identificador !== null) {
                $stmt->bindParam(':identificador', $identificador, PDO::PARAM_STR);
            }
            $stmt->execute();
            $vuelos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $vuelosArray = array();
            foreach ($vuelos as $vuelo) {
                $vuelosArray[] = new Flight($vuelo['identificador'], $vuelo['aeropuertoorigen'], $vuelo['aeropuertodestino'], $vuelo['tipovuelo'], $vuelo['fechavuelo'], $vuelo['descuento']);
            }
            return $vuelosArray;
        } catch (PDOException $e) {
            throw new Exception("Error de conexión con la base de datos: " . $e->getMessage());
        }
    }
    /**
     * Método para obtener todos la informacion que necesito para el servicio
     * @return array $allVuelos Array de objetos Vuelo ampliado
     * @throws Exception
     */
    public function getAllFlights($identificador = null)
    {
        try {
            $sql = "SELECT
            v.identificador AS 'Identificador del vuelo',
            v.aeropuertoorigen AS 'Aeropuerto de origen',
            a1.nombre AS 'Nombre aeropuerto de origen',
            a1.pais AS 'País de origen',
            v.aeropuertodestino AS 'Aeropuerto de destino',
            a2.nombre AS 'Nombre aeropuerto destino',
            a2.pais AS 'País de destino',
            v.tipovuelo AS 'Tipo de vuelo',
            COUNT(p.idpasaje) AS 'Número de pasajeros del vuelo'
        FROM
            vuelo v
        LEFT JOIN
            aeropuerto a1 ON v.aeropuertoorigen = a1.codaeropuerto
        LEFT JOIN
            aeropuerto a2 ON v.aeropuertodestino = a2.codaeropuerto
        LEFT JOIN
            pasaje p ON v.identificador = p.identificador";
            if ($identificador !== null) {
                $sql .= " WHERE v.identificador = :identificador";
            }
            $sql .= " GROUP BY
            v.identificador, v.aeropuertoorigen, a1.nombre, a1.pais, v.aeropuertodestino, a2.nombre, a2.pais, v.tipovuelo";

            $stmt = $this->conexion->prepare($sql);

            if ($identificador !== null) {
                $stmt->bindParam(':identificador', $identificador, PDO::PARAM_STR);
            }

            $stmt->execute();
            $allVuelos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $allVuelos;
        } catch (PDOException $e) {
            throw new Exception("Error de conexión con la base de datos: " . $e->getMessage());
        }
    }
}
