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
    * Método que prepara el formulario para borrar un pasaje
    *@param int $idpasaje
    *@return mensaje de confirmación o error
    */
    public function DeleteBooking($idpasaje = null)
    {
        //recogemos el id del pasaje si existe
        if ($idpasaje != null) {
            $idpasaje = $_GET['idpasaje'];
        }
        $idpasaje = $_GET['idpasaje'];
        //pedimos al servicio que nos de todos los datos del pasaje que le pasamos
        $res = $this->bookingService->GetBookings($idpasaje);
        //convertimos el json de respuesta en un array
        $bookingId = json_decode($res, true);
        //lo mandamos al formulario de confirmacion
        $this->formView->DeleteBooking($bookingId);
    }
    /**
     * Metodo que borra un pasaje
     * @param int $idpasaje
     * @return mensaje de confirmación o error
     * 
     */
    public function DeleteFactBooking()
    {
        //recogemos el id del pasaje por post
        $idpasaje = $_POST['idpasaje'];
        //var_dump($idpasaje);
        //pedimos al servicio que borre el pasaje y nos de un mensaje de confirmacion
        $res = $this->bookingService->DeleteBooking($idpasaje);
        // Verificar si la eliminación fue exitosa antes de configurar el mensaje en $_SESSION
        if ($res === "REGISTRO ELIMINADO CORRECTAMENTE") {
            $_SESSION['message-delete'] = $res;
        } else {
            $_SESSION['message-delete'] = "Error al eliminar el pasaje: " . $res;
        }
        $this->DeleteBooking($idpasaje);
    }

    /**
     * Metodo que muestre todos los pasajes
     * @return array asociativo con los pasajes
     */
    public function ShowBooking()
    {
        //pedimos al servicio que nos de todos los pasajes
        $res = $this->bookingService->GetBookings();
        //convertimos el json de respuesta en un array
        $bookings = json_decode($res, true);
        //lo almaceno en la sesion
        $_SESSION['bookings'] = $bookings;
        //se lo mando a la vista
        $this->bookingView->ShowBookings($bookings);
    }

    /**
     * Metodo que prepara el formulario para editar un pasaje
     * @param int $idpasaje
     * @return mensaje de confirmación o error
     */
    public function UpdateBooking($idpasaje = null)
    {
        //si recibo un idpasaje POR GET  LO GUARDO EN LA VARIABLE
        $idpasaje = isset($_GET['idpasaje']) ? $_GET['idpasaje'] : null;

        if ($idpasaje !== null) {
            // Guardar en la sesión si es necesario
            $_SESSION['idpasaje'] = $idpasaje;

            $res = $this->bookingService->GetBookings($idpasaje);
        } else {
            $res = $this->bookingService->GetBookings();
        }
        //convertimos el json de respuesta en un array
        $bookingId = json_decode($res, true);
        //lo mandamos al formulario de edicion
        $this->formView->UpdateBooking($bookingId);
    }
    /**
     * Metodo que actualiza un pasaje
     * @return mensaje de confirmación o error  
     */
    public function UpdateFactBooking()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Recoger los datos del formulario de actualización 
            // PONIENDO EL TIPO DE DATO QUE SE ESPERA
            $idpasaje = isset($_POST['idpasaje']) ? (int)$_POST['idpasaje'] : null;
            $pasajerocod = isset($_POST['pasajerocod']) ? (int)$_POST['pasajerocod'] : null;
            $identificador = $_POST['identificador'];
            $numasiento = isset($_POST['numasiento']) ? (int)$_POST['numasiento'] : null;
            $clase = $_POST['clase'];
            $pvp = isset($_POST['pvp']) ? (float)$_POST['pvp'] : null;
        }
        // var_dump($idpasaje);

        // Crear un array asociativo con los datos del pasaje
        $booking = [
            'idpasaje' => $idpasaje,
            'pasajerocod' => $pasajerocod,
            'identificador' => $identificador,
            'numasiento' => $numasiento,
            'clase' => $clase,
            'pvp' => $pvp
        ];
        //var_dump($booking); ok
        // Pedimos al servicio que actualice el pasaje y nos dé un mensaje de confirmación
        $res = $this->bookingService->UpdateBooking($booking);
        // Verificar si la actualización fue exitosa antes de configurar el mensaje en $_SESSION
        if ($res === "REGISTRO ACTUALIZADO CORRECTAMENTE") {
            $_SESSION['message-update'] = $res;
        } else {
            $_SESSION['message-update'] = "Error: " . $res;
        }

        $this->UpdateBooking($booking['idpasaje']);
    }
}
