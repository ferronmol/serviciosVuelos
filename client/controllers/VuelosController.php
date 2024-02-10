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
     * Muestra la página de inicio.
     */
    public function inicioVuelos()
    {
        $this->vuelosView->inicioVuelos();
    }
}
