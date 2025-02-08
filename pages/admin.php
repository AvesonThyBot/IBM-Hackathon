<?php

require_once("../include/autoloader.inc.php");

// Create object for webpage
$webpage = new Webpage("Admin - RZA", "admin");

// Redirect if userID cookie is not set
if (!isset($_COOKIE["userID"])) {
    header("Location:../pages/account.php");
    exit();
}

// Insert header
require_once("../include/header.inc.php");
?>

<main></main>


<?php require_once("../include/footer.inc.php"); ?>