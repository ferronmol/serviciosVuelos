<?php
include_once("./controllers/VuelosController.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class InfoView
{
    /**
     * Muestra la información de los vuelos.
     * @param string $mensajeError Mensaje de error a mostrar (opcional).
     */
    public function AllFlights()
    {

?>
        <div class="main-container__content__table">
            <h1 class="black-text center">All Flights</h1>
            <a href="index.php?controller=Hotel&action=inicioHoteles" class="btn btn-primary ">Back</a>

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
                        <td>2022-10-10</td>
                        <td>2022-10-15</td>
                        <td>1</td>
                        <td>John Doe</td>
                        <td>1</td>
                        <td>Hotel California</td>
                        <td>1</td>
                        <td>101</td>
                        <td>54</td>
                        <td><a href="index.php?controller=Vuelos&action=mostrarInicio" class="btn btn-primary">Edit</a></td>
                        <td><a href="index.php?controller=Vuelos&action=mostrarInicio" class="btn btn-primary">Delete</a></td>
                    </tr>
                    <tr>
                </tbody>
            </table>
        </div>
    <?php
    }

    /**
     * Metodo que muestra el formulario para insertar uun pasaje
     * 
     */
    public function FlightBooking()
    {

    ?>
        <h5 class="animate-character mt-5">Create Booking</h5>
        <div class="form-container form">
            <form class="form" action="index.php?controller=Vuelos&action=recibirFormularioBooking" method="post">
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
            <a href="index.php?controller=Vuelos&action=inicioVuelos" class="btn btn-primary">Back</a>
        </div>

    <?php
    }
    /**
     * Metodo que muestra el formulario para pedir el identificador de un vuelo
     * 
     */
    public function formularioVuelos()
    {

    ?>
        <h5 class="animate-character mt-5">Info Flight</h5>
        <div class="form-container">
            <form class="form" action="index.php?controller=Vuelos&action=obtenerInfoVuelo" method="post">
                <div class="form-group
}
                <label for=" identificador">Booking Code</label>
                    <input type="text" required name="identificador" class="form-control" id="identificador" placeholder="AVI-345" value="">
                </div>
                <button type="submit" class="btn btn-primary mt-2">Submit</button>
            </form>
            <a href="index.php?controller=Vuelos&action=inicioVuelos" class="btn btn-primary">Back</a>
        </div>
<?php
    }
    /**
     * Metodo que muestra la informacion del vuelo
     * 
     */
    public function mostrarInfoVuelo()
    {
        // Muestra la información del vuelo
        if (!empty($resultado)) {
            echo "<h1>Información del vuelo</h1>";
            echo "<p>Identificador: " . $resultado['identificador'] . "</p>";
            echo "<p>Origen: " . $resultado['origen'] . "</p>";
            echo "<p>Destino: " . $resultado['destino'] . "</p>";
            echo "<p>Fecha de salida: " . $resultado['fechasalida'] . "</p>";
            echo "<p>Fecha de llegada: " . $resultado['fechallegada'] . "</p>";
            echo "<p>Numero de pasajeros: " . $resultado['numpasajeros'] . "</p>";
            echo "<p>Clase: " . $resultado['clase'] . "</p>";
            echo "<p>Precio: " . $resultado['pvp'] . "</p>";
        } else {
            echo "<h1>No se ha encontrado el vuelo</h1>";
        }
    }
}
?>