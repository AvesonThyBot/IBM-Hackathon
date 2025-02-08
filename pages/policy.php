<?php

require_once ("../include/autoloader.inc.php");

// Create object for webpage
$webpage = new Webpage("Policy - RZA", "policy");

// Redirect if userID cookie is not set
if (!isset($_COOKIE["userID"])) {
    header("Location:../pages/account.php");
    exit();
}

// Insert header
require_once ("../include/header.inc.php");
?>

<main class="container mt-5">
    <p>Policy</p>
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque inventore nesciunt doloribus labore eligendi
        sapiente, doloremque nihil qui incidunt libero reiciendis vel? Quas ducimus, ullam suscipit molestias temporibus
        repellat quae!</p>
</main>


<?php require_once ("../include/footer.inc.php"); ?>