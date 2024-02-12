<?php
include_once("./controllers/VueloController.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class InfoView
{
    /**
     * Muestra la información de los vuelos.
     * @param string $mensajeError Mensaje de error a mostrar (opcional).
     */
    public function AllFlights($vuelos)
    {

?>
        <div class="main-container__content__table">
            <h1 class="black-text center">All Flights</h1>
            <a href="index.php?controller=Vuelo&action=inicioVuelos" class="btn btn-primary mb-3 ">Back</a>

            <table class="table table-striped table-dark table-custom">

                <thead>
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
                    <?php
                    foreach ($vuelos as $vuelo) {
                    ?>
                        <tr>
                            <td><?= $vuelo['Identificador del vuelo'] ?></td>
                            <td><?= $vuelo['Aeropuerto de origen'] ?></td>
                            <td><?= $vuelo['Nombre aeropuerto de origen'] ?></td>
                            <td><?= $vuelo['País de origen'] ?></td>
                            <td><?= $vuelo['Aeropuerto de destino'] ?></td>
                            <td><?= $vuelo['Nombre aeropuerto destino'] ?></td>
                            <td><?= $vuelo['País de destino'] ?></td>
                            <td><?= $vuelo['Tipo de vuelo'] ?></td>
                            <td><?= $vuelo['Número de pasajeros del vuelo'] ?></td>
                            <td><a href="index.php?controller=Vuelos&action=mostrarInicio" class="btn btn-primary">Edit</a></td>
                            <td><a href="index.php?controller=Vuelos&action=mostrarInicio" class="btn btn-primary">Delete</a></td>
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
     * Metodo que muestra el formulario para insertar un pasaje
     * 
     */
    public function FlightBooking()
    {

    ?>
        <h5 class="animate-character mt-5">Create Booking</h5>
        <div class="form-container form">
            <?php
            if (isset($_SESSION['message'])) {
                echo "<div class='alert alert-light' role='alert'>" . $_SESSION['message'] . "</div>";
                unset($_SESSION['message']);
            }
            ?>

            <form class="form" action="index.php?controller=Pasaje&action=FormBooking" method="post">
                <div class="form-group">
                    <label for="pasajerocod">Passenguer Code</label>
                    <input type="number" required name="pasajerocod" class="form-control" id="pasajerocod" placeholder="7" value="">
                </div>
                <div class="form-group">
                    <label for="identificador">Booking Code</label>
                    <input type="text" required name="identificador" class="form-control" id="identificador" placeholder="AVI-345" value="">
                </div>
                <div class="form-group">
                    <label for="numasiento">Seat Number</label>
                    <input type="number" required name="numasiento" class="form-control" id="numasiento" placeholder="10" value="">
                </div>
                <div class="form-group">
                    <label for="clase">Class</label>
                    <select name="clase" class="form-select" id="clase">
                        <option value="primera">First Class</option>
                        //opcion por defecto seleccionada
                        <option value="turista" selected>Turist</option>
                        <option value="negocios">Business</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="pvp">Price</label>
                    <input type="number" name="pvp" class="form-control" id="pvp" placeholder="250" value="">
                </div>

                <button type="submit" class="btn btn-primary mt-2">Submit</button>
            </form>
            <a href="index.php?controller=Vuelo&action=inicioVuelos" class="btn btn-primary">Back</a>
        </div>

    <?php
    }
    /**
     * Metodo que muestra el formulario para pedir el identificador de un vuelo
     * 
     */
    public function formFlightId()
    {

    ?>
        <h5 class="animate-character mt-5">Info Flight</h5>
        <div class="form-container">
            <form class="form" action="index.php?controller=Vuelo&action=requestFlight" method="post">
                <div class="form-group
}
                <label for=" identificador">Booking Code</label>
                    <input type="text" required name="identificador" class="form-control" id="identificador" placeholder="AVI-345" value="">
                </div>
                <button type="submit" class="btn btn-primary mt-2">Submit</button>
            </form>
            <a href="index.php?controller=Vuelo&action=inicioVuelos" class="btn btn-primary">Back</a>
        </div>
    <?php
    }
    /**
     * Metodo que muestra la informacion de un pasaje
     * @param Recibe un array bidemensional, con la info en el indice 0
     * 
     */
    public function showFlightId($vuelo)
    {
        //var_dump($vuelo);
    ?>
        <div class="main-container__content__table">
            <h1 class="black-text center">All Flights</h1>
            <a href="index.php?controller=Vuelo&action=inicioVuelos" class="btn btn-primary mb-3 ">Back</a>

            <table class="table table-striped table-dark table-custom">

                <thead>
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
                    <tr>
                        <td><?= $vuelo[0]['Identificador del vuelo'] ?></td>
                        <td><?= $vuelo[0]['Aeropuerto de origen'] ?></td>
                        <td><?= $vuelo[0]['Nombre aeropuerto de origen'] ?></td>
                        <td><?= $vuelo[0]['País de origen'] ?></td>
                        <td><?= $vuelo[0]['Aeropuerto de destino'] ?></td>
                        <td><?= $vuelo[0]['Nombre aeropuerto destino'] ?></td>
                        <td><?= $vuelo[0]['País de destino'] ?></td>
                        <td><?= $vuelo[0]['Tipo de vuelo'] ?></td>
                        <td><?= $vuelo[0]['Número de pasajeros del vuelo'] ?></td>
                        <td><a href="index.php?controller=Vuelos&action=mostrarInicio" class="btn btn-primary">Edit</a></td>
                        <td><a href="index.php?controller=Vuelos&action=mostrarInicio" class="btn btn-primary">Delete</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
<?php
    }
}
