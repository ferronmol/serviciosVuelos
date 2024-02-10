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
        $this->userView->mostrarInicio();
    }

    /**
     * Muestra el formulario de inicio de sesión.
     */
    public function mostrarFormulario()
    {
        $this->userView->mostrarFormulario();
    }


    public function procesarFormulario()
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

                // Redirige a la página de vuelos
                header('Location: index.php?controller=Vuelos&action=inicioVuelos');
                exit();
            } else {
                // Muestra un mensaje de error
                $mensajeError = 'Usuario o contraseña noo pueden esatr vacios. Inténtelo de nuevo.';
                $this->userView->mostrarFormulario($mensajeError);
            }
        }
    }



    /**
     * Cierra la sesión del usuario, escribe en el log, destruye la sesión y redirige al índice.
     */
    public function cerrarSesion()
    {
        //informo al logcontroler usando logOut
        //borro la sesion
        session_destroy();
        //vuelvo al index
        header('Location: index.php?controller=User&action=mostrarInicio');
        exit();
    }
}
