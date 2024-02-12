<?php

/**
 * Controlador del Pasaje de  los vuelos
 */
class PasajeController
{
    private $vueloView; //objeto de la clase Login_formview
    private $InfoView; //objeto de la clase InfoView
    private $pasajeService; //objeto de la clase PasajesService

    /**
     * Constructor de la clase VuelosController.
     * 
     */
    public function __construct()
    {
        $this->vueloView = new VueloView();  //crea un objeto de la clase Login_formview
        $this->InfoView = new InfoView();  //crea un objeto de la clase InfoView     
        $this->pasajeService = new PasajeService();  //crea un objeto de la clase PasajesServices
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
            $resultado = $this->pasajeService->insertarPasaje($pasaje);
            //mostramos el resultado
            print_r($resultado);
        }
    }
}
