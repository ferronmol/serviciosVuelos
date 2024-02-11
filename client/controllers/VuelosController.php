<?php
include_once('./views/VuelosView.php');
include_once('./views/InfoView.php');
include_once("./services/VuelosService.php");
include_once("./services/PasajesService.php");

/**
 * Controlador de la página de vuelos.
 * @class VuelosController
 * @brief Controlador de la página de vuelos.
 */
class VuelosController
{
    private $vuelosView; //objeto de la clase Login_formview
    private $InfoView; //objeto de la clase InfoView
    private $vuelosService; //objeto de la clase VuelosService
    private $pasajesService; //objeto de la clase PasajesService

    /**
     * Constructor de la clase VuelosController.
     * 
     */
    public function __construct()
    {
        $this->vuelosView = new VuelosView();  //crea un objeto de la clase Login_formview
        $this->InfoView = new InfoView();  //crea un objeto de la clase InfoView
        $this->vuelosService = new VuelosService();  //crea un objeto de la clase VuelosService
        $this->pasajesService = new PasajesService();  //crea un objeto de la clase PasajesServices
    }

    /**
     * Muestra la página de inicio de vuelos.
     */
    public function inicioVuelos()
    {
        if (isset($_SESSION['nombre'])) {
            $fechaUltVisita = date('Y-m-d H:i:s');
            setcookie('ultima_visita', $fechaUltVisita, time() + 7 * 24 * 60 * 60, '/'); //valida por 7 dias

            $this->vuelosView->inicioVuelos();
        } else {
            header('Location: index.php?controller=User&action=mostrarInicio');
        }
    }
    /**
     * Pide al servidor la información de todos los vuelos.
     */
    public function AllFlights()
    {

        $this->vuelosService->request();

        //se lo mandamos a la vista
        // $this->InfoView->AllFlights();
    }
    /**
     * Solicita a la vista que muestre el formulario de búsqueda de vuelos.
     */
    public function FlightBooking()
    {
        $this->InfoView->FlightBooking();
    }
    /**
     * Recibe el formulario de búsqueda de vuelos.
     */
    public function recibirFormularioBooking()
    {
        $pasaje = array();
        if (isset($_POST['pasajerocod']) && isset($_POST['identificador'])) {
            $pasajerocod = $_POST['pasajerocod'];
            $identificador = $_POST['identificador'];
            $numasiento = $_POST['numasiento'];
            $clase = $_POST['clase'];
            $pvp = $_POST['pvp'];
            $pasaje = array('pasajerocod' => $pasajerocod, 'identificador' => $identificador, 'numasiento' => $numasiento, 'clase' => $clase, 'pvp' => $pvp);
        }
        if (!empty($pasaje)) {
            //pedimos al servicio que inserte el pasaje
            $resultado = $this->pasajesService->insertarPasaje($pasaje);
            //mostramos el resultado
            print_r($resultado);
        }
    }
    /**
     * Pide a la vista que muestre el formulario para pedir el identificador de UN vuelo.
     */
    public function mostrarVuelo()
    {

        $this->InfoView->formularioVuelos();
    }

    /**
     * Obtiene la información de un vuelo concreto.
     */
    public function obtenerInfoVuelo()
    {
        if (isset($_POST['identificador'])) {
            $identificador = $_POST['identificador'];
        }
        //var_dump($identificador); //ok

        // Envía el identificador al servicio para procesar la información del vuelo
        $this->vuelosService->obtenerInfoVuelo($identificador);

        // Muestra el resultado en la vista correspondiente
        $this->InfoView->mostrarInfoVuelo();
    }
}
