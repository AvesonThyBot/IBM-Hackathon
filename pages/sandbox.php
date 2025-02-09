<?php

require_once("../include/autoloader.inc.php");

// Create object for webpage
$webpage = new Webpage("Sandbox - investED", "sandbox");

// Insert header
require_once("../include/header.inc.php");
?>

<main>
    <!-- Sandbox -->
    <canvas class="container" id="myChart"></canvas>
    <div class="container">
        <span id="gbr-span">GBR: </span>
        <span id="eur-span">EUR: </span>
        <span class="btn btn-success float-end" id="fetch-data">get data</span>
    </div>
</main>


<?php require_once("../include/footer.inc.php"); ?>