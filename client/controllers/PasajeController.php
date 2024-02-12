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
    public function FormBooking()
    {
        $booking = array();
        $error = null;
        if (isset($_POST['pasajerocod']) && isset($_POST['identificador']) && isset($_POST['numasiento'])) {
            $pasajerocod = intval($_POST['pasajerocod']);
            $identificador = $_POST['identificador'];
            $numasiento = intval($_POST['numasiento']);
            $clase = $_POST['clase'];
            $pvp = floatval($_POST['pvp']);
            $booking = array('pasajerocod' => $pasajerocod, 'identificador' => $identificador, 'numasiento' => $numasiento, 'clase' => $clase, 'pvp' => $pvp);
        }
        if (!empty($booking)) {
            //pedimos al servicio que inserte el pasaje
            $res = $this->pasajeService->InsertBooking($booking);
            //convertimos el json de respuesta en un array
            $res = json_decode($res, true);
            //se lo mando al mismo fomrulario
            $this->InfoView->FlightBooking();
            //si recibo un mensaje del servidor lo almaceno en la sesion
            if (isset($res['message'])) {
                //lo guardamos en la sesion
                $_SESSION['message'] = $res['message'];
                var_dump($_SESSION['message']);
                die();
                //redirigimos al formulario
                header('Location: index.php?controller=Pasaje&action=FlightBooking');
                exit();
            }
        }
    }
}
