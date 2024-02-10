<?php
session_start();

class VuelosView
{
    /**
     * Muestra la página de inicio.
     * @param string $mensajeError Mensaje de error a mostrar (opcional).
     */
    public function inicioVuelos()
    {
?>
        <div class="main-container__content">
            <div class="checkout-container">
                <a href="index.php?controller=User&action=cerrarSesion" class="btn-salir"><span>Out Session</span></a>
            </div>
            <div class="main-container__content__title">
                <h1 class="animate-character">Ferron Airlines</h1>
            </div>
            <div class="main-container__content__subtitle">
                <h2 class="text txt-white">Take off to the future</h2>
            </div>
            <div class="main-container__content__btn">
                <?php
                if (isset($_SESSION) && isset($_SESSION['nombre'])) {
                    echo '<p class="text text--min">User: ' . $_SESSION['nombre'] . '</p>';
                } else {
                    echo '<p class="text text--min">Usuario no autenticado</p>';
                }
                ?>
            </div>
        </div>

    <?php
        // Llamada al segundo método
        $this->mostrarInfoVuelos();
    }

    /**
     * Muestra la información de los vuelos.
     */
    public function mostrarInfoVuelos()
    {
    ?>
        <div class="main-container__flight">
            <div class="main-container__flight-title">
                <h1 class="black-text">Flight Information</h1>
            </div>
            <div class="main-container__content__btn">
                <a href="index.php?controller=Vuelos&action=mostrarVuelos" class="btn-flight">All Flights</a>
                <a href="index.php?controller=Vuelos&action=mostrarVuelos" class="btn-flight">Flight number</a>
                <a href="index.php?controller=Vuelos&action=mostrarVuelos" class="btn-flight">Tickets</a>
                <a href="index.php?controller=Vuelos&action=mostrarVuelos" class="btn-flight">I want to fly</a>
            </div>
        </div>
<?php
    }
}
