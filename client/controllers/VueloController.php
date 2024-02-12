<?php

/**
 * Controlador de la página de vuelos.
 * @class VuelosController
 * @brief Controlador de la página de vuelos.
 */
class VueloController
{
    private $vueloView; //objeto de la clase Login_formview
    private $InfoView; //objeto de la clase InfoView
    private $vueloService; //objeto de la clase VuelosService
    private $pasajeService; //objeto de la clase PasajesService

    /**
     * Constructor de la clase VuelosController.
     * 
     */
    public function __construct()
    {
        $this->vueloView = new VueloView();  //crea un objeto de la clase Login_formview
        $this->InfoView = new InfoView();  //crea un objeto de la clase InfoView
        $this->vueloService = new VueloService();  //crea un objeto de la clase VuelosService
        $this->pasajeService = new PasajeService();  //crea un objeto de la clase PasajesServices
    }

    /**
     * Muestra la página de inicio de vuelos.
     */
    public function inicioVuelos()
    {
        if (isset($_SESSION['nombre'])) {
            $fechaUltVisita = date('Y-m-d H:i:s');
            setcookie('ultima_visita', $fechaUltVisita, time() + 7 * 24 * 60 * 60, '/'); //valida por 7 dias

            $this->vueloView->inicioVuelos();
        } else {
            header('Location: index.php?controller=User&action=mostrarInicio');
        }
    }
    /**
     * Pide al servidor la información de todos los vuelos.
     */
    public function AllFlights()
    {

        $Vuelos = json_decode($this->vueloService->request(), true);
        // var_dump($Vuelos);

        $this->InfoView->AllFlights($Vuelos);
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
        $this->vueloService->obtenerInfoVuelo($identificador);

        // Muestra el resultado en la vista correspondiente
        $this->InfoView->mostrarInfoVuelo();
    }
}
