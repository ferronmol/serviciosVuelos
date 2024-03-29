<?php
include_once("./views/UserView.php");
class UserController
{
    private $userView; //objeto de la clase Login_formview

    /**
     * Constructor de la clase UserController.
     */
    public function __construct()
    {
        $this->userView = new UserView();  //crea un objeto de la clase Login_formview
    }

    /**
     * Muestra la página de inicio.
     */
    public function mostrarInicio()
    {
        $this->userView->showInit();
    }

    /**
     * Muestra el formulario de inicio de sesión.
     */
    public function showForm()
    {
        $this->userView->showForm();
    }


    public function processForm()
    {
        // Comprueba si se ha enviado el formulario
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Comprueba si el usuario y la contraseña existen
            if (isset($_POST['nombre']) && isset($_POST['contraseña'])) {
                $nombre = $_POST['nombre'];
                // Inicia la sesión
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                // Guarda el nombre de usuario en la sesión
                $_SESSION['nombre'] = $nombre;
                // var_dump($_SESSION['nombre']); ok

                /**********COOKIE DE ULTIMA VISITA ************ */
                // Comprueba si existe la cookie de última visita
                if (isset($_COOKIE['ultima_visita'])) {
                    //OBTENGO L ULTIMA VISITA almacena en la cookie
                    $fechaUltVisita = $_COOKIE['ultima_visita'];
                } else {
                    // Si no existe la cookie de última visita, se crea
                    $fechaUltVisita = date('Y-m-d H:i:s');
                    setcookie('ultima_visita', $fechaUltVisita, time() + 7 * 24 * 60 * 60, '/'); //valida por 7 dias
                }
                // Redirige a la página de vuelos
                header('Location: index.php?controller=Flight&action=initFlight');
                exit();
            } else {
                // Muestra un mensaje de error
                $mensajeError = 'Usuario o contraseña noo pueden esatr vacios. Inténtelo de nuevo.';
                $this->userView->showForm($mensajeError);
            }
        }
    }



    /**
     * Cierra la sesión del usuario, escribe en el log, destruye la sesión y redirige al índice.
     */
    public function closeSession()
    {

        //vaciamos la sesion
        $_SESSION = array();
        //borro la sesion
        session_destroy();
        //borro la cookie
        // setcookie('ultima_visita', '', time() - 3600, '/');
        //vuelvo al index
        header('Location: index.php?controller=User&action=mostrarInicio');
        exit();
    }
}
