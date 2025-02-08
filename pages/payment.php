<?php

require_once ("../include/autoloader.inc.php");

// Create object for webpage
$webpage = new Webpage("Cart - RZA", "payment");

// Create object for payment
$payment = new Payment($_GET["type"] ?? '');

// Redirect if userID cookie is not set
if (!isset($_COOKIE["userID"])) {
    header("Location:../pages/account.php");
    exit();
}

// Validate for card
if (isset($_POST['cardBtn'])) {
    $payment->validateCard($_POST["number"] ?? "", $_POST["name"] ?? "", $_POST["date"] ?? "", $_POST["cvv"] ?? "");
}

// Validate for paypal
if (isset($_POST['paypalBtn'])) {
    $payment->validatePaypal($_POST["email"] ?? "");
}

// Payment Button
if (isset($_POST['payBtn'])) {
    $payment->payCart();
}

echo $payment->addPoints();

// Insert header
require_once ("../include/header.inc.php");
?>

<main class="container">
    <h2 class="text-center">Cart Page</h2>
    <hr class="container border border-3 border-light rounded" />

    <!-- Payment -->
    <div class="row">
        <div class="col-lg-9">
            <!-- Display Cart Item -->
            <h4>Cart Items</h4>
            <div class="accordion mb-3" id="cartAccordion">
                <h2 class="accordion-header h5 mb-2">
                    <div class="accordion-button d-flex justify-content-between align-items-center rounded border"
                        type="button" data-bs-toggle="collapse" data-bs-target="#cart-body" aria-expanded="true"
                        aria-controls="card">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                            class="me-2 bi bi-cart-fill" viewBox="0 0 16 16">
                            <path
                                d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2" />
                        </svg>
                        Cart
                    </div>
                </h2>
                <div id="cart-body" class="accordion-collapse collapse" data-bs-parent="#cartAccordion">
                    <?php $payment->displayCart($_COOKIE["userID"]) ?>
                </div>
            </div>
            <!-- Payment Accordion -->
            <h4>Payment Details</h4>
            <div class="accordion mb-3" id="paymentAccordion">
                <!-- Card -->
                <div class="accordion-item mb-3">
                    <h2 class="accordion-header h5 ">
                        <div class="accordion-button d-flex justify-content-between align-items-center" type="button"
                            data-bs-toggle="collapse" data-bs-target="#card" aria-expanded="true" aria-controls="card">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                class="me-2 bi bi-credit-card-2-front-fill" viewBox="0 0 16 16">
                                <path
                                    d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2.5 1a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h2a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm0 3a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm3 0a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm3 0a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm3 0a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1z" />
                            </svg>
                            Card<span class="text-danger">*</span>
                        </div>
                    </h2>
                    <div id="card" class="accordion-collapse collapse" data-bs-parent="#paymentAccordion">
                        <!-- Card Information -->
                        <div class="accordion-body">
                            <form method="post" class="needs-validation" novalidate>
                                <div class="mb-3">
                                    <label class="form-label">Card Number</label>
                                    <input type="text" class="form-control <?php if (isset($_POST["cardBtn"]))
                                        echo $payment->getValid("number") ?>" value="<?php if (isset($_POST["cardBtn"]))
                                        echo $payment->getValue("number") ?>" placeholder="0000 0000 0000 0000"
                                            maxlength="19" name="number">
                                        <div class="invalid-feedback">
                                            Card number needs to be 16 characters long.
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label">Name on card</label>
                                                <input type="text" class="form-control <?php if (isset($_POST["cardBtn"]))
                                        echo $payment->getValid("name") ?>" value="<?php if (isset($_POST["cardBtn"]))
                                        echo $payment->getValue("name") ?>" placeholder="Full Name" maxlength="80"
                                                    name="name">
                                                <div class="invalid-feedback">
                                                    Enter Valid Card Name.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label class="form-label">Expiry date</label>
                                                <input type="text" class="form-control <?php if (isset($_POST["cardBtn"]))
                                        echo $payment->getValid("date") ?>" value="<?php if (isset($_POST["cardBtn"]))
                                        echo $payment->getValue("date") ?>" placeholder="MM/YY" maxlength="5"
                                                    name="date">
                                                <div class="invalid-feedback">
                                                    Expiry date needs to be in MM/YY format.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label class="form-label">CVV Code</label>
                                                <input type="password" class="form-control <?php if (isset($_POST["cardBtn"]))
                                        echo $payment->getValid("cvv") ?>" value="<?php if (isset($_POST["cardBtn"]))
                                        echo $payment->getValue("cvv") ?>" maxlength="3" placeholder="***" name="cvv">
                                                <div class="invalid-feedback">
                                                    CVV must be 3 numbers only.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button class="btn btn-primary" name="cardBtn">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Paypal -->
                    <div class="accordion-item rounded border">
                        <h2 class="accordion-header h5 d-flex justify-content-between align-items-center">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#paypal" aria-expanded="false" aria-controls="paypal">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                    class="me-2 bi bi-paypal" viewBox="0 0 16 16">
                                    <path
                                        d="M14.06 3.713c.12-1.071-.093-1.832-.702-2.526C12.628.356 11.312 0 9.626 0H4.734a.7.7 0 0 0-.691.59L2.005 13.509a.42.42 0 0 0 .415.486h2.756l-.202 1.28a.628.628 0 0 0 .62.726H8.14c.429 0 .793-.31.862-.731l.025-.13.48-3.043.03-.164.001-.007a.35.35 0 0 1 .348-.297h.38c1.266 0 2.425-.256 3.345-.91q.57-.403.993-1.005a4.94 4.94 0 0 0 .88-2.195c.242-1.246.13-2.356-.57-3.154a2.7 2.7 0 0 0-.76-.59l-.094-.061ZM6.543 8.82a.7.7 0 0 1 .321-.079H8.3c2.82 0 5.027-1.144 5.672-4.456l.003-.016q.326.186.548.438c.546.623.679 1.535.45 2.71-.272 1.397-.866 2.307-1.663 2.874-.802.57-1.842.815-3.043.815h-.38a.87.87 0 0 0-.863.734l-.03.164-.48 3.043-.024.13-.001.004a.35.35 0 0 1-.348.296H5.595a.106.106 0 0 1-.105-.123l.208-1.32z" />
                                </svg>
                                Paypal<span class="text-danger">*</span>
                            </button>
                        </h2>
                        <div id="paypal" class="accordion-collapse collapse" data-bs-parent="#paymentAccordion">
                            <div class="accordion-body">
                                <form class="needs-validation" method="post">
                                    <span class="fs-5 ms-2">Enter PayPal Email</span>
                                    <div class="input-group mb-3 has-validation">
                                        <span class="input-group-text">Email</span>
                                        <input name="email" type="text" class="form-control <?php if (isset($_POST["paypalBtn"]))
                                        echo $payment->getValid("email") ?>" value="<?php if (isset($_POST["paypalBtn"]))
                                        echo $payment->getValue("email") ?>" placeholder="Email" aria-label="Email"
                                            name="email">
                                        <div class="invalid-feedback">
                                            Email is invalid or taken.
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button class="btn btn-primary" name="paypalBtn">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Payment Summary -->
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body">
                    <?php $payment->displaySummary() ?>
                </div>
            </div>
        </div>
    </div>
</main>


<?php require_once ("../include/footer.inc.php"); ?>