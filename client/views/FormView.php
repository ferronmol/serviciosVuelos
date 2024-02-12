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
     * 
     */
    public function DeleteBooking()
    {
    ?>
        <h5 class="animate-character mt-5">Delete Booking</h5>
        <div class="form-container">
            <form class="form" action="index.php?controller=Booking&action=DeleteBooking" method="post">
                <div class="form-group">
                    <label for="idpasaje">Booking Code</label>
                    <input type="text" required name="idpasaje" class="form-control" id="idpasaje" placeholder="AVI-345" value="">
                </div>
                <button type="submit" class="btn btn-primary mt-2">Submit</button>
            </form>
            <a href="index.php?controller=Flight&action=initFlight" class="btn btn-primary">Back</a>
        </div>
<?php
    }
}
