<?php

/**
 * Controlador de la página de vuelos.
 * @class VuelosController
 * @brief Controlador de la página de vuelos.
 */
class FlightController
{
    private $flightView; //objeto de la clase Login_formview
    private $formView; //objeto de la clase InfoView
    private $flightService; //objeto de la clase VuelosService
    private $bookingService; //objeto de la clase PasajesService

    /**
     * Constructor de la clase VuelosController.
     * 
     */
    public function __construct()
    {
        $this->flightView = new FlightView();  //crea un objeto de la clase Login_formview
        $this->formView = new FormView();  //crea un objeto de la clase InfoView
        $this->flightService = new FlightService();  //crea un objeto de la clase VuelosServices
        $this->bookingService = new BookingService();  //crea un objeto de la clase PasajesServices
    }

    /**
     * Muestra la página de inicio de vuelos.
     */
    public function initFlight()
    {
        if (isset($_SESSION['nombre'])) {
            $fechaUltVisita = date('Y-m-d H:i:s');
            setcookie('ultima_visita', $fechaUltVisita, time() + 7 * 24 * 60 * 60, '/'); //valida por 7 dias

            $this->flightView->initFlights();
        } else {
            header('Location: index.php?controller=User&action=mostrarInicio');
        }
    }
    /**
     * Pide al servidor la información de todos los vuelos.
     */
    public function AllFlights()
    {

        $Vuelos = json_decode($this->flightService->request(), true);
        // var_dump($Vuelos);

        $this->flightView->AllFlights($Vuelos);
    }

    /**
     * Pide a la vista que muestre el formulario para pedir el identificador de UN vuelo.
     */
    public function FlightId()
    {

        $this->formView->formFlightId();
    }

    /**
     * Recibe el identificador del form y se lo manda al servicio
     * Manda a la vista la respuesta del servicio
     */
    public function requestFlight()
    {
        if (isset($_POST['identificador'])) {
            $identificador = $_POST['identificador'];
        }
        //var_dump($identificador); //ok

        // Envía el identificador al servicio para procesar la información del vuelo
        $res = $this->flightService->requestFlightId($identificador);

        // Muestra el resultado en la vista correspondiente
        $this->flightView->showFlightId($res);
    }
}
