<?php

require_once ("../include/autoloader.inc.php");

// Create object for webpage
$webpage = new Webpage("Hotel - RZA", "hotel");

// Create object for hotel
$hotel = new Hotel($_POST["startDate"] ?? ' to ', $_GET["room"] ?? '');

// Redirect if userID cookie is not set
if (!isset($_COOKIE["userID"])) {
    header("Location:../pages/account.php");
    exit();
}

// Validation request on hotelBtn press
if (isset($_POST['hotelBtn'])) {
    // Validate & submit
    $hotel->validateHotel();
}

// Insert header
require_once ("../include/header.inc.php");
?>

<main>
    <h2 class="text-center">Hotel Booking</h2>
    <hr class="container border border-3 border-light rounded" />

    <!-- Hotel Information -->
    <section class="container-fluid" <?php $hotel->getSection("default") ?>>
        <div class="row">
            <!-- Information -->
            <div class="row gap-3 mx-auto d-flex justify-content-center">
                <?php $hotel->displayRooms() ?>
            </div>
    </section>

    <!-- Confirming booking -->
    <section class="container" <?php $hotel->getSection("payment") ?>>
        <!-- Form -->
        <form class="col col-8 container needs-validation" method="post">
            <!-- Date -->
            <span class="fs-5 ms-2">Pick Date Range<span class="text-danger">*</span></span>
            <div class="d-flex col gap-2 mb-3 ">
                <input type="text" class="form-control has-validation  <?php if (isset($_POST['hotelBtn']))
                    $hotel->getValid("startDate") ?>" value="<?php echo $_POST["startDate"] ?? "" ?>"
                    placeholder="Start Date" id="range1" name="startDate" min="today" max="today + 30 days" required>
                <input type="text" class="form-control has-validation  <?php if (isset($_POST['hotelBtn']))
                    $hotel->getValid("endDate") ?>" placeholder="End Date" id="range2" min="today"
                        max="today + 30 days" required>
                </div>

                <!-- Room Type -->
                <span class="fs-5 ms-2">Room Type<span class="text-danger">*</span></span>
                <div class="input-group mb-3 has-validation">
                    <input type="text" class="form-control" value="<?php echo ucfirst($_GET["room"]) ?? '' ?>"
                    placeholder="Type" disabled>
            </div>

            <div class="d-flex justify-content-end"><button class="btn btn-success" name="hotelBtn">Submit</button>
            </div>
        </form>

        <!-- Display information -->
        <?php if (isset($_POST["hotelBtn"]) && $hotel->errorCount() == 0)
            $hotel->displayInformation() ?>
        </section>
    </main>


<?php require_once ("../include/footer.inc.php"); ?>