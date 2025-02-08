<?php

require_once ("../include/autoloader.inc.php");

// Create object for webpage
$webpage = new Webpage("Facility - RZA", "facility");

// Redirect if userID cookie is not set
if (!isset($_COOKIE["userID"])) {
    header("Location:../pages/account.php");
    exit();
}

// Insert header
require_once ("../include/header.inc.php");
?>

<main>
    <h2 class="text-center">Facility Information & Attractions</h2>
    <hr class="container border border-3 border-light rounded" />

    <!-- Cards -->
    <div class="container mb-5">
        <div class="row gap-2 mx-auto">
            <!-- Facility -->
            <div class="card mt-1" style="width: 26rem;">
                <div class="card-body">
                    <h5 class="card-title">Facility Information</h5>
                    <h6 class="card-subtitle mb-2 text-body-secondary">Riget Zoo Adventures</h6>
                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nesciunt sit
                        repudiandae labore nam quis. Enim in amet cumque commodi! Modi, neque cum ipsum sit perferendis
                        tempora. Deserunt aut sint harum!</p>
                    <div class="card-footer d-flex justify-content-end mt-auto">
                        <a href="../pages/ticket.php" class="btn btn-outline-light">Read More</a>
                    </div>
                </div>
            </div>
            <!-- Ticket -->
            <div class="card mt-1" style="width: 26rem;">
                <div class="card-header">
                    Information
                </div>
                <p class="card-text">Visit these pages to see information about what we offer, including educational
                    visits & information</p>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Click here: <a class="text-white fw-bold fs-5"
                            href="../pages/hotel.php">Hotel</a></li>
                    <li class="list-group-item">Click here: <a class="text-white fw-bold fs-5"
                            href="../pages/ticket.php">Ticket</a></li>
                    <li class="list-group-item">Click here: <a class="text-white fw-bold fs-5"
                            href="../pages/loyalty.php">Loyalty
                            Scheme</a>
                    </li>
                    <li class="list-group-item">Click here: <a class="text-white fw-bold fs-5"
                            href="../pages/payment.php">Cart</a>
                    </li>
                    <li class="list-group-item">Click here: <a class="text-white fw-bold fs-5"
                            href="../pages/bookings.php">Bookings</a>
                    </li>
                </ul>
            </div>
            <!-- Educational Information & Attraction -->
            <div class="card mt-1" style="width: 26rem;">
                <div class="card-header">
                    Attraction & Educational Information
                </div>
                <p class="card-text">Visit our animal page to get information on variety of different animals we have in
                    our zoo.</p>
                <p>We offer many animal information and visiting us will let you see them in
                    person and
                    have more information. We also offer facts about animals by the driver when you are in a safari.</p>
                <ul class="list-group list-group-flush mt-auto">
                    <li class="list-group-item">Click here: <a class="text-white fw-bold fs-5"
                            href="../pages/animal.php">Animal</a>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</main>


<?php require_once ("../include/footer.inc.php"); ?>