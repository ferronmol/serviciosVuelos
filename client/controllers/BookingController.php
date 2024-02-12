<?php

/**
 * Controlador del Pasaje de  los vuelos
 */
class BookingController
{
    private $flightView; //objeto de la clase Login_formview
    private $bookingView; //objeto de la clase InfoView
    private $bookingService; //objeto de la clase PasajesService
    private $formView; //objeto de la clase FormView

    /**
     * Constructor de la clase VuelosController.s
     * 
     */
    public function __construct()
    {
        $this->flightView = new FlightView();  //crea un objeto de la clase Login_formview
        $this->bookingView = new BookingView();  //crea un objeto de la clase InfoView
        $this->bookingService = new BookingService();  //crea un objeto de la clase PasajesServices
        $this->formView = new FormView();  //crea un objeto de la clase FormView
    }

    /**
     * Muestra la página con las opciones de pasajes.
     */
    public function Bookings()
    {

        $this->bookingView->Bookings();
    }


    /**
     * Solicita a la vista que muestre el formulario  para crear un pasaje.
     */
    public function CreateBooking()
    {
        $this->formView->CreateBooking();
    }
    /**
     * Recibe el formulario de búsqueda de pasajes.
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
            $res = $this->bookingService->InsertBooking($booking);
            //convertimos el json de respuesta en un array
            $res = json_decode($res, true);
            //se lo mando al mismo fomrulario
            $this->formView->CreateBooking();
            //si recibo un mensaje del servidor lo almaceno en la sesion
            if (isset($res['message'])) {
                //lo guardamos en la sesion
                $_SESSION['message'] = $res['message'];
                //var_dump($_SESSION['message']);
                die();
                //redirigimos al formulario
                header('Location: index.php?controller=Booking&action=FlightBooking');
                exit();
            }
        }
    }
    /*
    * Método que borra un pasaje a traves de su identificador
    *@param int $idpasaje
    *@return mensaje de confirmación o error
    */
    public function DeleteBooking()
    {
        //mostramos el formulario para solicitar el id del pasaje
        $this->formView->DeleteBooking();
        //recogemos el id del pasaje
        $idpasaje = $_GET['idpasaje'];
        $res = $this->bookingService->DeleteBooking($idpasaje);
        //convertimos el json de respuesta en un array
        $res = json_decode($res, true);
        //si recibo un mensaje del servidor lo almaceno en la sesion
        if (isset($res['message'])) {
            //lo guardamos en la sesion
            $_SESSION['message'] = $res['message'];
            //redirigimos al formulario
            header('Location: index.php?controller=Booking&action=FlightBooking');
            exit();
        }
    }
}
