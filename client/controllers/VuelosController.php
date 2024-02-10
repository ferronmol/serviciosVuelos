<?php
include_once("./views/VuelosView.php");


/**
 * Controlador de la página de vuelos.
 * @class VuelosController
 * @brief Controlador de la página de vuelos.
 */
class VuelosController
{
    private $vuelosView; //objeto de la clase Login_formview

    /**
     * Constructor de la clase VuelosController.
     * 
     */
    public function __construct()
    {
        $this->vuelosView = new VuelosView();  //crea un objeto de la clase Login_formview
    }

    /**
     * Muestra la página de inicio de vuelos.
     */
    public function inicioVuelos()
    {
        if (isset($_SESSION) && isset($_SESSION['nombre'])) {
            $fechaUltVisita = date('Y-m-d H:i:s');
            setcookie('ultima_visita', $fechaUltVisita, time() + 7 * 24 * 60 * 60, '/'); //valida por 7 dias

            $this->vuelosView->inicioVuelos();
        } else {
            header('Location: index.php?controller=User&action=mostrarInicio');
        }
    }
}
