<?php

require_once ("../include/autoloader.inc.php");

// Create object for webpage
$webpage = new Webpage("Bookings - RZA", "booking");

// Create object for Booking
$booking = new Booking($_COOKIE["userID"] ?? '');

// Redirect if userID cookie is not set
if (!isset($_COOKIE["userID"])) {
    header("Location:../pages/account.php");
    exit();
}

// Delete certain item
if (isset($_POST["removeBtn"])) {
    $booking->removeItem($_POST["type"], $_POST["id"]);
}


// Insert header
require_once ("../include/header.inc.php");
?>

<main class="container">
    <h2 class="text-center">View Boookings & Tickets</h2>
    <hr class="container border border-3 border-light rounded" />

    <!-- Accordion -->
    <div class="accordion mb-3" id="ticketAccordion">
        <!-- Ticket -->
        <h2 class="accordion-header h5 mb-2">
            <div class="accordion-button d-flex justify-content-between align-items-center rounded border" type="button"
                data-bs-toggle="collapse" data-bs-target="#ticket-body" aria-expanded="true" aria-controls="card">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                    class="me-2 bi bi-ticket-perforated-fill" viewBox="0 0 16 16">
                    <path
                        d="M0 4.5A1.5 1.5 0 0 1 1.5 3h13A1.5 1.5 0 0 1 16 4.5V6a.5.5 0 0 1-.5.5 1.5 1.5 0 0 0 0 3 .5.5 0 0 1 .5.5v1.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 11.5V10a.5.5 0 0 1 .5-.5 1.5 1.5 0 1 0 0-3A.5.5 0 0 1 0 6zm4-1v1h1v-1zm1 3v-1H4v1zm7 0v-1h-1v1zm-1-2h1v-1h-1zm-6 3H4v1h1zm7 1v-1h-1v1zm-7 1H4v1h1zm7 1v-1h-1v1zm-8 1v1h1v-1zm7 1h1v-1h-1z" />
                </svg>
                Tickets
            </div>
        </h2>
        <div id="ticket-body" class="accordion-collapse collapse show" data-bs-parent="#ticketAccordion">
            <!-- Upcoming -->
            <div class="card mb-3">
                <div class="card-header h5">
                    Upcoming
                </div>
                <ul class="list-group list-group-flush">
                    <?php $booking->displayUCTicket() ?>
                </ul>
            </div>
            <hr class="container border border-3 border-primary rounded">
            <!-- Active -->
            <div class="card mb-3">
                <div class="card-header h5">
                    Active
                </div>
                <ul class="list-group list-group-flush">
                    <?php $booking->displayActiveTicket() ?>
                </ul>
            </div>
            <hr class="container border border-3 border-primary rounded">
            <!-- Outdated -->
            <div class="card mb-3">
                <div class="card-header h5">
                    Outdated
                </div>
                <ul class="list-group list-group-flush">
                    <?php $booking->displayOldTicket() ?>
                </ul>
            </div>
        </div>


        <!-- Hotel -->
        <h2 class="accordion-header h5 mb-2">
            <div class="accordion-button d-flex justify-content-between align-items-center rounded border" type="button"
                data-bs-toggle="collapse" data-bs-target="#hotel-body" aria-expanded="false" aria-controls="card">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                    class="me-2 bi bi-building-fill" viewBox="0 0 16 16">
                    <path
                        d="M3 0a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h3v-3.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5V16h3a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1zm1 2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3.5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5M4 5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zM7.5 5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5m2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zM4.5 8h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5m2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3.5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5" />
                </svg>
                Hotel
            </div>
        </h2>
        <div id="hotel-body" class="accordion-collapse collapse" data-bs-parent="#ticketAccordion">
            <!-- Upcoming -->
            <div class="card mb-3">
                <div class="card-header h5">
                    Upcoming
                </div>
                <ul class="list-group list-group-flush">
                    <?php $booking->displayUCHotel() ?>
                </ul>
            </div>
            <hr class="container border border-3 border-primary rounded">
            <!-- Active -->
            <div class="card mb-3">
                <div class="card-header h5">
                    Active
                </div>
                <ul class="list-group list-group-flush">
                    <?php $booking->displayActiveHotel() ?>
                </ul>
            </div>
            <hr class="container border border-3 border-primary rounded">
            <!-- Outdated -->
            <div class="card mb-3">
                <div class="card-header h5">
                    Outdated
                </div>
                <ul class="list-group list-group-flush">
                    <?php $booking->displayOldHotel() ?>
                </ul>
            </div>
        </div>
    </div>
</main>


<?php require_once ("../include/footer.inc.php"); ?>