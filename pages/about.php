<?php

require_once ("../include/autoloader.inc.php");

// Create object for webpage
$webpage = new Webpage("About Us - RZA", "about");

// Insert header
require_once ("../include/header.inc.php");
?>

<main>
    <!-- Hero -->
    <img class="d-block mx-auto mb-4 image-fluid w-100" src="../images/about.jfif" alt="" id="hero">
    <h1 class="text-center">About Us Page</h1>
    <hr class="container border border-3 border-light rounded" />

    <!-- Cards -->
    <div class="container mb-5">
        <div class="row gap-2 mx-auto">
            <!-- History -->
            <div class="card mt-1" style="width: 26rem;">
                <div class="card-body">
                    <h5 class="card-title">History</h5>
                    <h6 class="card-subtitle mb-2 text-body-secondary">Riget Zoo Adventures</h6>
                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nesciunt sit
                        repudiandae labore nam quis. Enim in amet cumque commodi! Modi, neque cum ipsum sit perferendis
                        tempora. Deserunt aut sint harum!</p>
                    <div class="card-footer d-flex justify-content-end">
                        <a href="../pages/ticket.php" class="btn btn-outline-light">Read More</a>
                    </div>
                </div>
            </div>
            <!-- Contact Information -->
            <div class="card mt-1" style="width: 26rem;">
                <div class="card-header">
                    Contacts
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Number: (+44) <a href="tel:07#########">07#########</a></li>
                    <li class="list-group-item">Support Email: <a href="mailto:support@rza.com">support@rza.com</a></li>
                    <li class="list-group-item">Information Email: <a
                            href="mailto:information@rza.com">information@rza.com</a>
                    </li>
                    <li class="list-group-item">Address: <a target="_blank"
                            href="https://maps.app.goo.gl/arr9ktPT4soNyMGA6">RZA</a>
                    </li>
                </ul>
            </div>
            <!-- FAQ Accordion -->
            <div class="card m-1" style="width: 26rem;">
                <div class="card-body">
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    FAQ 1
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Deleniti, atque itaque?
                                    Dolorem provident, voluptas distinctio, reprehenderit voluptatum modi ut quos dolore
                                    alias culpa maxime quaerat, dolorum deleniti. Harum, autem iure?</div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    FAQ 2
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Deleniti, atque itaque?
                                    Dolorem provident, voluptas distinctio, reprehenderit voluptatum modi ut quos dolore
                                    alias culpa maxime quaerat, dolorum deleniti. Harum, autem iure?</div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    FAQ 3
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Deleniti, atque itaque?
                                    Dolorem provident, voluptas distinctio, reprehenderit voluptatum modi ut quos dolore
                                    alias culpa maxime quaerat, dolorum deleniti. Harum, autem iure?</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>


<?php require_once ("../include/footer.inc.php"); ?>