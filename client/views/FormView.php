<?php
include_once("./controllers/FlightController.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
/**
 * Clase que se encarga de mostrar los formularios de la aplicacion Y SU PRESENTACION
 
 */
class FormView
{

    /**
     * Metodo que muestra el formulario para INSERTAR UN PASAJE
     * 
     */
    public function CreateBooking()
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

            <form class="form" action="index.php?controller=Booking&action=FormBooking" method="post">
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
            <a href="index.php?controller=Flight&action=initFlight" class="btn btn-primary">Back</a>
        </div>

    <?php
    }
    /**
     * Metodo que muestra el formulario para BUSCAR UN PASAJE POR SU IDENTIFICADOR
     * 
     */
    public function formFlightId()
    {

    ?>
        <h5 class="animate-character mt-5">Info Flight</h5>
        <div class="form-container">
            <form class="form" action="index.php?controller=Flight&action=requestFlight" method="post">
                <div class="form-group
}
                <label for=" identificador">Booking Code</label>
                    <input type="text" required name="identificador" class="form-control" id="identificador" placeholder="AVI-345" value="">
                </div>
                <button type="submit" class="btn btn-primary mt-2">Submit</button>
            </form>
            <a href="index.php?controller=Flight&action=initFlight" class="btn btn-primary">Back</a>
        </div>
    <?php
    }
    /**
     * Metodo que muestra el formulario para BORRAR UN PASAJE POR SU IDENTIFICADOR
     * @param array $bookingId
     */
    public function DeleteBooking($bookingId)
    {
        //var_dump($bookingId);
    ?>
        <h5 class="animate-character mt-2">Delete Booking</h5>
        <div class="form-container form">
            <?php
            //var_dump($_SESSION['message-delete']);
            if (isset($_SESSION['message-delete']) && $_SESSION['message-delete'] != "") {
                echo "<div class='alert alert-light' role='alert'>" . $_SESSION['message-delete'] . "</div>";
                unset($_SESSION['message-delete']);
            }
            ?>

            <form class="form" action="index.php?controller=Booking&action=DeleteFactBooking" method="post">
                <div class="form-group">
                    <label for="pasajerocod">Booking Id</label>
                    <input type="number" readonly name="idpasaje" value="<?php echo $bookingId[0]['idpasaje'] ?>">
                    <div class="form-group">
                        <label for="pasajerocod">Passenguer Code</label>
                        <input type="number" readonly name="pasajerocod" class="form-control" id="pasajerocod" placeholder="<?php echo $bookingId[0]['pasajerocod'] ?>" value="">
                    </div>
                    <div class="form-group">
                        <label for="identificador">Booking Code</label>
                        <input type="text" readonly required name="identificador" class="form-control" id="identificador" placeholder="<?php echo $bookingId[0]['identificador'] ?>" value="">
                    </div>
                    <div class="form-group">
                        <label for="numasiento">Seat Number</label>
                        <input type="number" readonly name="numasiento" class="form-control" id="numasiento" placeholder="<?php echo $bookingId[0]['numasiento'] ?>" value="">
                    </div>
                    <div class="form-group">
                        <label for="clase">Class</label>
                        <input type="text" readonly name="clase" class="form-control" id="clase" placeholder="<?php echo $bookingId[0]['clase'] ?>" value="">
                    </div>
                    <div class="form-group">
                        <label for="pvp">Price</label>
                        <input type="number" name="pvp" class="form-control" id="pvp" placeholder="<?php echo $bookingId[0]['pvp'] ?>" value="">
                    </div>

                    <button type="submit" class="btn btn-danger mt-2">DELETE</button>
            </form>
            <a href="index.php?controller=Booking&action=ShowBooking" class="btn btn-primary">Back</a>
        <?php
    }

    /**
     * Metodo que muestra el formulario para ACTUALIZAR UN PASAJE POR SU IDENTIFICADOR
     * @param array $bookingId
     * 
     */
    public function UpdateBooking($bookingId)
    {
        ?>
            <h5 class="animate-character mt-2">Update Booking</h5>
            <div class="form-container form">
                <?php
                if (isset($_SESSION['message-update']) && $_SESSION['message-update'] != "") {
                    echo "<div class='alert alert-light' role='alert'>" . $_SESSION['message-update'] . "</div>";
                    unset($_SESSION['message-update']);
                }
                ?>
                <form class="form" action="index.php?controller=Booking&action=UpdateFactBooking" method="post">
                    <input type="hidden" name="idpasaje" value="<?php echo $bookingId[0]['idpasaje'] ?>">
                    <div class="form-group">
                        <label for="pasajerocod">Passenguer Code</label>
                        <input type="number" required name="pasajerocod" class="form-control" id="pasajerocod" placeholder="<?php echo $bookingId[0]['pasajerocod'] ?>" value="<?php echo $bookingId[0]['pasajerocod'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="identificador">Booking Code</label>
                        <input type="text" required name="identificador" class="form-control" id="identificador" placeholder="<?php echo $bookingId[0]['identificador'] ?>" value="<?php echo $bookingId[0]['identificador'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="numasiento">Seat Number</label>
                        <input type="number" required name="numasiento" class="form-control" id="numasiento" placeholder="<?php echo $bookingId[0]['numasiento'] ?>" value="<?php echo $bookingId[0]['numasiento'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="clase">Class</label>
                        <select name="clase" class="form-select" id="clase">
                            <option value="primera">First Class</option>
                            <option value="turista">Turist</option>
                            <option value="negocios">Business</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="pvp">Price</label>
                        <input type="number" name="pvp" class="form-control" id="pvp" placeholder="<?php echo $bookingId[0]['pvp'] ?>" value="<?php echo $bookingId[0]['pvp'] ?>">
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">UPDATE</button>
                </form>
                <a href="index.php?controller=Booking&action=ShowBooking" class="btn btn-primary">Back</a>
            </div>
        <?php

    }

    /**
     * Metodo que muestra el formulario para MODIFICAR UN VUELO
     *  @param array $vuelo
     */
    public function FormEditFlight($vuelo)
    {
        ?>
            <h5 class="animate-character mt-2">Edit Flight</h5>
            <div class="form-container form">
                <form class="form" action="index.php?controller=Flight&action=UpdateFlight" method="post">
                    <input type="hidden" name="idvuelo" value="<?php echo $vuelo[0]['idvuelo'] ?>">
                    <div class="form-group">
                        <label for="identificador">Flight Code</label>
                        <input type="text" required name="identificador" class="form-control" id="identificador" placeholder="<?php echo $vuelo[0]['identificador'] ?>" value="<?php echo $vuelo[0]['identificador'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="aeropuertoorigen">Source Airport</label>
                        <input type="text" required name="aeropuertoorigen" class="form-control" id="aeropuertoorigen" placeholder="<?php echo $vuelo[0]['aeropuertoorigen'] ?>" value="<?php echo $vuelo[0]['aeropuertoorigen'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="nombreorigen">Departure Airport</label>
                        <input type="text" required name="nombreorigen" class="form-control" id="nombreorigen" placeholder="<?php echo $vuelo[0]['nombreorigen'] ?>" value="<?php echo $vuelo[0]['nombreorigen'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="paisorigen">Departure Country</label>
                        <input type="text" required name="paisorigen" class="form-control" id="paisorigen" placeholder="<?php echo $vuelo[0]['paisorigen'] ?>" value="<?php echo $vuelo[0]['paisorigen'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="aeropuertodestino">Destination Airport</label>
                        <input type="text" required name="aeropuertodestino" class="form-control" id="aeropuertodestino" placeholder="<?php echo $vuelo[0]['aeropuertodestino'] ?>" value="<?php echo $vuelo[0]['aeropuertodestino'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="nombredestino">Arrival Airport</label>
                        <input type="text" required name="nombredestino" class="form-control" id="nombredestino" placeholder="<?php echo $vuelo[0]['nombredestino'] ?>" value="<?php echo $vuelo[0]['nombredestino'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="paisdestino">Arrival Country</label>
                        <input type="text" required name="paisdestino" class="form-control" id="paisdestino" placeholder="<?php echo $vuelo[0]['paisdestino'] ?>" value="<?php echo $vuelo[0]['paisdestino'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="tipovuelo">Flight Type</label>
                        <select name="tipovuelo" class="form-select" id="tipovuelo">
                            <option value="ida">One Way</option>
                            <option value="ida-vuelta">Round Trip</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="numpasajeros">Number of Passengers</label>
                        <input type="number" required name="numpasajeros" class="form-control" id="numpasajeros" placeholder="<?php echo $vuelo[0]['numpasajeros'] ?>" value="<?php echo $vuelo[0]['numpasajeros'] ?>">
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">UPDATE</button>
                </form>
                <a href="index.php?controller=Flight&action=initFlight" class="btn btn-primary">Back</a>
            </div>
        <?php
    }

    /**
     * Metodo que muestra el formulario para INSERTAR UN VUELO
     * @param array $flights con toda la info qu enecesito para cargar lso identificadores
     * @param array $passenguer con toda la info qu enecesito para cargar los nombre s de los pasajeros
     */
    public function InsertBooking($passenguer, $flights)
    {
        //var_dump($flights);
        //var_dump($passenguer);

        //ya tengo toda la info para cargar los select
        ?>
            <h5 class="animate-character mt-2">Insert Booking</h5>
            <div class="form-container form">
                <?php
                if (isset($_SESSION['message-insert']) && $_SESSION['message-insert'] != "") {
                    echo "<div class='alert alert-light' role='alert'>" . $_SESSION['message-insert'] . "</div>";
                    unset($_SESSION['message-insert']);
                }
                if (isset($_SESSION['message']) && $_SESSION['message'] != "") {
                    echo "<div class='alert alert-light' role='alert'>" . $_SESSION['message'] . "</div>";
                    unset($_SESSION['message']);
                }
                ?>

                <form class="form" action="index.php?controller=Booking&action=InsertBooking" method="post">
                    <div class="form-group">
                        <label for="pasajerocod">Insert Passenguer</label>
                        <select name="pasajerocod" class="form-select">
                            <?php
                            foreach ($passenguer as $pasajero) {
                                echo "<option value='" . $pasajero['pasajerocod'] . "'>" . $pasajero['pasajerocod'] . " - " . $pasajero['nombre'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class=" form-group">
                        <label for="pasajerocod">Flight Identifier</label>
                        <select name="identificador" class="form-select" id="identificador">
                            <?php
                            foreach ($flights as $vuelo) {
                                echo "<option value='" .  $vuelo['Identificador del vuelo'] . "'>" .  $vuelo['Identificador del vuelo'] . " - " . $vuelo['Aeropuerto de origen'] . " - " .  $vuelo['Aeropuerto de destino'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <!-- envio de campos ocultos -->
                    <?php
                    foreach ($passenguer as $pasajero) {
                        echo "<input type='hidden' name='pasajerocodSelect' value='" . $pasajero['pasajerocod'] . "'>";
                    }

                    foreach ($flights as $vuelo) {
                        echo "<input type='hidden' name='identificador_vuelo' value='" . $vuelo['Identificador del vuelo'] . "'>";
                    }
                    ?>
                    <div class="form-group">
                        <label for="numasiento">Seat Number</label>
                        <input type="number" name="numasiento" class="form-control" id="numasiento" value="" required>
                    </div>
                    <div class="form-group">
                        <label>Class</label>
                        <div class="container-btn">
                            <?php
                            $clases = ['primera' => 'First Class', 'turista' => 'Turist', 'negocios' => 'Business'];

                            foreach ($clases as $key => $value) {
                                echo "<div class='container-btn'>";
                                echo "<input type='radio' name='clase' id='clase_$value' value='$value' class='' required>";
                                echo "<label for='clase_$value' class='label'>$value</label>";
                                echo "</div>";
                            }
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pvp">Price</label>
                        <input type="number" name="pvp" class="form-control" id="pvp" value="" required>
                    </div>

                    <button type="submit" class="btn btn-success mt-2">Insertar Pasaje</button>
                </form>
                <a href="index.php?controller=Flight&action=initFlight" class="btn btn-primary">Back</a>
        <?php
    }
}
