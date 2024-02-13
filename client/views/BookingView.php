<?php
class BookingView
{
    /**
     * Muestra la página con las opciones de pasajes.
     */
    public function Bookings()
    {
?>
        <h2 class="animate-character mt-3">Bookings</h2>
        <div class="main-container__content__btn">

            <a href="index.php?controller=Booking&action=CreateBooking" class="btn-flight">Create Booking</a>
            <a href="index.php?controller=Booking&action=ShowBooking" class="btn-flight">Info Booking</a>
        </div>
    <?php

    }
    /**
     * Método que muestra todos los pasajes en una tabla
     */
    public function ShowBookings($bookings)
    {
        //var_dump($bookings);
    ?>
        <div class="main-container__content__table">
            <h1 class="black-text center">All Bookings</h1>
            <a href="index.php?controller=Booking&action=Bookings" class="btn btn-primary mb-3 ">Back</a>

            <table class="table--bs-table-bg table-striped table-hover table-custom">

                <thead class="table border">
                    <tr>
                        <th scope=" col center">ID BOOKING</th>
                        <th scope="col center">PASSENGER COD</th>
                        <th scope="col center">IDENTIFIER</th>
                        <th scope="col center">NUM SEAT</th>
                        <th scope="col center">CLASS</th>
                        <th scope="col center">PVP</th>
                        <th scope="col center">Edit</th>
                        <th scope="col center">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($bookings as $booking) {
                    ?>
                        <tr class="--bs-table-active-bg">
                            <td class="center"><?= $booking['idpasaje'] ?></td>
                            <td class="center"><?= $booking['pasajerocod'] ?></td>
                            <td class="center"><?= $booking['identificador'] ?></td>
                            <td class="center"><?= $booking['numasiento'] ?></td>
                            <td class="center"><?= $booking['clase'] ?></td>
                            <td class="center"><?= $booking['pvp'] ?></td>

                            <td class="center"><a href="index.php?controller=Booking&action=Bookings" class="btn btn-primary"><i class="bi bi-pencil"></i></a></td>
                            <td class="center"><a href="index.php?controller=Booking&action=DeleteBooking&idpasaje=<?= $booking['idpasaje'] ?>" class="btn btn-outline-danger"><i class="bi bi-trash"></a></td>
                        </tr>
                    <?php
                    }
                    ?>

                </tbody>
            </table>
        </div>
        <a href="index.php?controller=Booking&action=Bookings" class="btn btn-primary mb-3 center ">Back</a>
<?php
    }
}
