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
            <a href="index.php?controller=Booking&action=DeleteBooking" class="btn-flight">Delete Booking</a>
        </div>
<?php

    }
}
