<?php

require_once ("../include/autoloader.inc.php");

// Create object for webpage
$webpage = new Webpage("Ticket - RZA", "ticket");

// Create object for ticket
$ticket = new Ticket($_GET["ticket"] ?? '', $_POST["date"] ?? '', $_POST["quantity"] ?? '', $_POST["ticketType"] ?? '');

// Redirect if userID cookie is not set
if (!isset($_COOKIE["userID"])) {
    header("Location:../pages/account.php");
    exit();
}

// Validation request on pay button press
if (isset($_POST['payBtn'])) {
    // Validate & submit
    $ticket->validateTicket();
}


// Insert header
require_once ("../include/header.inc.php");
?>

<main>
    <h2 class="text-center">Ticket Page</h2>
    <hr class="container border border-3 border-light rounded" />
    <!-- Ticket Section -->
    <section class="container-fluid" <?php $ticket->getSection("default") ?>>
        <div class="row d-flex justify-content-center">
            <?php $ticket->displayTickets() ?>
        </div>
        <div class="card mx-auto mt-2 mb-5" style="width: 50dvw;">
            <div class="card-body text-center">
                <h5 class="card-title fw-bolder">Infant & Carers</h5>
                <p class="card-text">Infants (Under age of 3) and legalised carers (for children) can enter for free.
                </p>
            </div>
        </div>
    </section>
    <!-- Information Section -->
    <section class="container" <?php $ticket->getSection("information") ?>>
        <div class="row">
            <div class="col col-md-6 ">
                <form class="row needs-validation d-flex justify-content-center" method="post" novalidate>
                    <!-- Date -->
                    <span class="fs-5 ms-2">Start Date<span class="text-danger">*</span></span>
                    <div class="input-group mb-3 has-validation">
                        <span class="input-group-text">Date</span>
                        <input type="text"
                            class="form-control <?php if (isset($_POST['payBtn']))
                                $ticket->getValid("date") ?>"
                                value="<?php if (isset($_POST['payBtn']))
                                $ticket->getValue("date") ?>" id="startDate"
                                min="today" max="today+30 days" name="date">
                            <div class=" invalid-feedback">
                                Select a valid date.
                            </div>
                        </div>

                        <!-- Quantity -->
                        <span class="fs-5 ms-2">Quantity<span class="text-danger">*</span></span>
                        <div class="input-group mb-3 has-validation">
                            <span class="input-group-text">Qnty</span>
                            <input type="number"
                                class="form-control <?php if (isset($_POST['payBtn']))
                                $ticket->getValid("quantity") ?>"
                                value="<?php if (isset($_POST['payBtn']))
                                $ticket->getValue("quantity") ?>" name="quantity"
                                min="0" step="1">
                            <div class=" invalid-feedback">
                                Quantity must be 1 or more.
                            </div>
                        </div>

                        <!-- Select Length -->
                        <span class="fs-5 ms-2">Ticket Type<span class="text-danger">*</span></span>
                        <div class="input-group mb-3 has-validation">
                            <span class="input-group-text">Type</span>
                            <select class="form-select <?php if (isset($_POST['payBtn']))
                                $ticket->getValid("type") ?>"
                                name="ticketType" required>
                                <option selected disabled value="">Select...</option>
                                <option <?php if (isset($_POST['payBtn']))
                                $ticket->getValue("day") ?> value="day">Day
                                    Ticket</option>
                                <option <?php if (isset($_POST['payBtn']))
                                $ticket->getValue("week") ?> value="week">Week
                                    Ticket</option>
                                <option <?php if (isset($_POST['payBtn']))
                                $ticket->getValue("month") ?> value="month">Month
                                    Ticket</option>
                                <option <?php if (isset($_POST['payBtn']))
                                $ticket->getValue("year") ?> value="year">Year
                                    Ticket</option>
                            </select>
                            <div class="invalid-feedback">
                                Select a ticket type.
                            </div>
                        </div>


                        <!-- Buttons -->
                        <button name="payBtn" type="submit" class="btn btn-primary col-6">Add To Cart!</button>
                    </form>
                </div>

                <!-- Display Prices -->
                <div class="col col-md-6 d-flex gap-2">
                <?php $ticket->displayPrices() ?>
            </div>
        </div>
    </section>
</main>

<?php require_once ("../include/footer.inc.php"); ?>