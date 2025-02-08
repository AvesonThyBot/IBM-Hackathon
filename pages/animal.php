<?php

require_once ("../include/autoloader.inc.php");

// Create object for webpage
$webpage = new Webpage("Animal - RZA", "animal");

// Create object for animal
$animal = new Animal($_GET["type"] ?? '');

// Redirect if userID cookie is not set
if (!isset($_COOKIE["userID"])) {
    header("Location:../pages/account.php");
    exit();
}

// Insert header
require_once ("../include/header.inc.php");
?>

<main>
    <!-- Information -->
    <section class="container my-4" <?php $animal->getSection("information") ?>>
        <!-- Search Bar -->
        <form method="post" class="input-group mb-3">
            <input type="text" class="form-control shadow-none" name="search" placeholder="e.g. Cheetah"
                value="<?php echo $_POST["search"] ?? '' ?>">
            <button class="btn btn-light" type="submit" name="searchBtn">Search</button>
        </form>

        <!-- Display Information -->
        <div class="row gap-3 mx-auto d-flex justify-content-center">
            <?php
            if (isset($_POST["searchBtn"])) {
                $animal->displaySearchedAnimals($_POST["search"]);
            } else {
                $animal->displayAnimals();
            } ?>

        </div>
    </section>
    <!-- Details -->
    <section class="container" <?php $animal->getSection("detail") ?>>
        <h1 class="text-center">Animal Information</h1>
        <hr class="container border border-3 border-light rounded" />

        <!-- Basic Information -->
        <div class="mx-auto row text-bg-light border rounded d-flex justify-content-between mb-3">
            <div class="fs-5 fw-bold text-center">Basic Information</div>
            <div class="col text-start">
                <div class="col api-data">Name:

                    <div class="spinner-border spinner-border-sm" role="status"><span
                            class="visually-hidden">Loading...</span></div>
                </div>
                <div class="col api-data">Location:

                    <div class="spinner-border spinner-border-sm" role="status"><span
                            class="visually-hidden">Loading...</span></div>
                </div>
            </div>
            <div class="col text-end">
                <span class="fs-5 fw-bold">Taxonomy</span>
                <div class="col api-data">Kingdom:

                    <div class="spinner-border spinner-border-sm" role="status"><span
                            class="visually-hidden">Loading...</span></div>
                </div>
                <div class="col api-data">Class:

                    <div class="spinner-border spinner-border-sm" role="status"><span
                            class="visually-hidden">Loading...</span></div>
                </div>
                <div class="col api-data">Family:

                    <div class="spinner-border spinner-border-sm" role="status"><span
                            class="visually-hidden">Loading...</span></div>
                </div>
                <div class="col api-data">Order
                    :
                    <div class="spinner-border spinner-border-sm" role="status"><span
                            class="visually-hidden">Loading...</span></div>
                </div>
            </div>
        </div>

        <!-- Animal Nature -->
        <div class="mx-auto row text-bg-light border rounded d-flex justify-content-between mb-3">
            <div class="fs-5 fw-bold text-center">Animal Characteristics</div>
            <div class="col text-start">
                <div class="col api-data">Prey:

                    <div class="spinner-border spinner-border-sm" role="status"><span
                            class="visually-hidden">Loading...</span></div>
                </div>
                <div class="col api-data">Name
                    of Young:
                    <div class="spinner-border spinner-border-sm" role="status"><span
                            class="visually-hidden">Loading...</span></div>
                </div>
                <div class="col api-data">Group
                    Behaviour:
                    <div class="spinner-border spinner-border-sm" role="status"><span
                            class="visually-hidden">Loading...</span></div>
                </div>
                <div class="col api-data">Biggest
                    Threat:
                    <div class="spinner-border spinner-border-sm" role="status"><span
                            class="visually-hidden">Loading...</span></div>
                </div>
                <div class="col api-data">Life
                    Span:
                    <div class="spinner-border spinner-border-sm" role="status"><span
                            class="visually-hidden">Loading...</span></div>
                </div>
                <div class="col api-data">Height:

                    <div class="spinner-border spinner-border-sm" role="status"><span
                            class="visually-hidden">Loading...</span></div>
                </div>
                <div class="col api-data">Weight:

                    <div class="spinner-border spinner-border-sm" role="status"><span
                            class="visually-hidden">Loading...</span></div>
                </div>
            </div>
            <div class="col text-end">
                <div class="col api-data">Estimated
                    Population Size:
                    <div class="spinner-border spinner-border-sm" role="status"><span
                            class="visually-hidden">Loading...</span></div>
                </div>
                <div class="col api-data">Distinct
                    Features:
                    <div class="spinner-border spinner-border-sm" role="status"><span
                            class="visually-hidden">Loading...</span></div>
                </div>
                <div class="col api-data">Habitat:

                    <div class="spinner-border spinner-border-sm" role="status"><span
                            class="visually-hidden">Loading...</span></div>
                </div>
                <div class="col api-data">Diet
                    :
                    <div class="spinner-border spinner-border-sm" role="status"><span
                            class="visually-hidden">Loading...</span></div>
                </div>
                <div class="col api-data">Skin
                    Type:
                    <div class="spinner-border spinner-border-sm" role="status"><span
                            class="visually-hidden">Loading...</span></div>
                </div>
                <div class="col api-data">Slogan:

                    <div class="spinner-border spinner-border-sm" role="status"><span
                            class="visually-hidden">Loading...</span></div>
                </div>
            </div>
        </div>

        <!-- Return back -->
        <div class="alert alert-light d-flex justify-content-between" role="alert">
            <p class="my-auto fw-bold">Vist us to see more information in person!</p>
            <a class="btn btn-outline-light" href="animal.php">Return</a>
        </div>
    </section>
</main>


<?php require_once ("../include/footer.inc.php"); ?>