<?php

require_once ("../include/autoloader.inc.php");

// Create object for webpage
$webpage = new Webpage("Loyalty - RZA", "loyalty");

// Create object for payment
$payment = new Payment($_GET["type"] ?? '');

// Redirect if userID cookie is not set
if (!isset($_COOKIE["userID"])) {
    header("Location:../pages/account.php");
    exit();
}

// Insert header
require_once ("../include/header.inc.php");
?>

<main>
    <h2 class="text-center">Loyalty Page</h2>
    <hr class="container border border-3 border-light rounded" />

    <div class="container my-5 rounded text-bg-dark p-2">
        <div class="col-md-2">
            <div class="progress" role="progressbar" aria-label="Animated striped example" aria-valuenow="75"
                aria-valuemin="0" aria-valuemax="100">
                <div class="progress-bar progress-bar-striped progress-bar-animated text-bg-danger"
                    style="width: <?php echo number_format($payment->getPoints() / 10000) ?>%"></div>
                <?php echo number_format($payment->getPoints() / 10000) ?>%
            </div>
        </div>
        <p class="fs-5">Total Points: <span class="fw-bold"><?php echo number_format($payment->getPoints()) ?></span>
        </p>
        <p>Every 100,000 points you can 10% off (This stacks up to 40% maximum.)</p>
        <p>Applicable on hotel and ticket.</p>
    </div>
</main>


<?php require_once ("../include/footer.inc.php"); ?>