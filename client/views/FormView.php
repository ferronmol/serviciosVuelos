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
            }
            ?>

            <form class="form" action="index.php?controller=Booking&action=DeleteFactBooking" method="post">
                <input type="hidden" name="idpasaje" value="<?php echo $bookingId[0]['idpasaje'] ?>">
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
}
