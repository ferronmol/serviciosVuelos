<?php
session_start();

class FlightView
{
    /**
     * Muestra la página de inicio.
     * @param string $mensajeError Mensaje de error a mostrar (opcional).
     */
    public function initFlights()
    {
?>
        <div class="main-container__content">
            <div class="checkout-container">
                <a href="index.php?controller=User&action=closeSession" class="btn-salir"><span>Out Session</span></a>
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
                if (isset($_COOKIE['ultima_visita'])) {
                    echo '<p class="text text--min">Última visita: ' . $_COOKIE['ultima_visita'] . '</p>';
                }
                ?>
            </div>
        </div>

    <?php
        // Llamada al segundo método
        $this->showInfoFlights();
    }

    /**
     * Muestra la información principal de la aplicación mediante botones.
     */
    public function showInfoFlights()
    {
    ?>
        <div class="main-container__flight">
            <div class="main-container__flight-title">
                <h1 class="black-text">Flight Information</h1>
            </div>
            <div class="main-container__content__btn">
                <a href="index.php?controller=Flight&action=AllFlights" class="btn-flight">All Flights</a>
                <a href="index.php?controller=Flight&action=FlightId" class="btn-flight">Flight number</a>
                <a href="index.php?controller=Booking&action=Bookings" class="btn-flight">Bookings</a>
                <a href="index.php?controller=Flight&action=mostrarVuelos" class="btn-flight">I want to fly</a>
            </div>
        </div>
    <?php
    }
    /**
     * Muestra la información de TODOS LOS VUELOS
     * @param Array $vuelos Array con la información de los vuelos.
     */
    public function AllFlights($vuelos)
    {

    ?>
        <div class="main-container__content__table">
            <h1 class="black-text center">All Flights</h1>
            <a href="index.php?controller=Flight&action=initFlight" class="btn btn-primary mb-3 ">Back</a>

            <table class="table--bs-table-bg table-striped table-hover table-custom">

                <thead class="table border">
                    <tr>
                        <th scope=" col center">IDENTIFIER</th>
                        <th scope="col center">SOURCE AIRPORT</th>
                        <th scope="col center">DEPARTURE AIRPORT</th>
                        <th scope="col center">DEPARTURE COUNTRY</th>
                        <th scope="col center">DESTINATION AIRPORT</th>
                        <th scope="col center">ARRIVAL AIRPORT</th>
                        <th scope="col center">ARRIVAL COUNTRY</th>
                        <th scope="col center">FLIGHT TYPE</th>
                        <th scope="col center">NUMBER OF PASSENGERS</th>
                        <th scope="col center">Edit</th>
                        <th scope="col center">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($vuelos as $vuelo) {
                    ?>
                        <tr class="--bs-table-active-bg">
                            <td class="center"><?= $vuelo['Identificador del vuelo'] ?></td>
                            <td class="center"><?= $vuelo['Aeropuerto de origen'] ?></td>
                            <td class="center"><?= $vuelo['Nombre aeropuerto de origen'] ?></td>
                            <td class="center"><?= $vuelo['País de origen'] ?></td>
                            <td class="center"><?= $vuelo['Aeropuerto de destino'] ?></td>
                            <td class="center"><?= $vuelo['Nombre aeropuerto destino'] ?></td>
                            <td class="center"><?= $vuelo['País de destino'] ?></td>
                            <td class="center"><?= $vuelo['Tipo de vuelo'] ?></td>
                            <td class="center"><?= $vuelo['Número de pasajeros del vuelo'] ?></td>
                            <td class="center"><a href="index.php?controller=Flight&action=mostrarInicio" class="btn btn-primary"><i class="bi bi-pencil"></i></a></td>
                            <td class="center"><a href="index.php?controller=Flight&action=mostrarInicio" class="btn btn-outline-danger"><i class="bi bi-trash"></a></td>
                        </tr>
                    <?php
                    }
                    ?>

                </tbody>
            </table>
        </div>
    <?php
    }
    /**
     * Metodo que muestra la informacion de uun  VUELO Y SUS PASAJES
     * @param Recibe un array bidemensional, con la info en el indice 0
     * 
     */
    public function showFlightId($vuelo)
    {
        //var_dump($vuelo);
    ?>
        <div class="main-container__content__table">
            <h1 class="black-text center">All Flights</h1>
            <a href="index.php?controller=Flight&action=initFlight" class="btn btn-primary mb-3 ">Back</a>

            <table class="table--bs-table-bg table-striped table-hover table-custom">

                <thead class="table border">
                    <tr>
                        <th scope="col center">IDENTIFIER</th>
                        <th scope="col center">SOURCE AIRPORT</th>
                        <th scope="col center">DEPARTURE AIRPORT</th>
                        <th scope="col center">DEPARTURE COUNTRY</th>
                        <th scope="col center">DESTINATION AIRPORT</th>
                        <th scope="col center">ARRIVAL AIRPORT</th>
                        <th scope="col center">ARRIVAL COUNTRY</th>
                        <th scope="col center">FLIGHT TYPE</th>
                        <th scope="col center">NUMBER OF PASSENGERS</th>
                        <th scope="col center">Edit</th>
                        <th scope="col center">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="--bs-table-active-bg">
                        <td class="center"><?= $vuelo[0]['Identificador del vuelo'] ?></td>
                        <td class="center"><?= $vuelo[0]['Aeropuerto de origen'] ?></td>
                        <td class="center"><?= $vuelo[0]['Nombre aeropuerto de origen'] ?></td>
                        <td class="center"><?= $vuelo[0]['País de origen'] ?></td>
                        <td class="center"><?= $vuelo[0]['Aeropuerto de destino'] ?></td>
                        <td class="center"><?= $vuelo[0]['Nombre aeropuerto destino'] ?></td>
                        <td class="center"><?= $vuelo[0]['País de destino'] ?></td>
                        <td class="center"><?= $vuelo[0]['Tipo de vuelo'] ?></td>
                        <td class="center"><?= $vuelo[0]['Número de pasajeros del vuelo'] ?></td>
                        <td><a href="index.php?controller=Flight&action=mostrarInicio" class="btn btn-primary">Edit</a></td>
                        <td><a href="index.php?controller=Flight&action=mostrarInicio" class="btn btn-outline-danger"><i class="bi bi-trash"></i></a></td>
                    </tr>
                </tbody>
            </table>
        </div>
<?php
    }
}
