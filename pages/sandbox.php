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
        <span class="btn btn-success float-end" id="fetch-data">Get Data</span>
    </div>

    <!-- Trading Section -->
    <div class="container mt-4">
        <h3>Trade EUR/GBP</h3>
        <div class="row">
            <div class="col-md-6">
                <p class="badge text-bg-info" id="balance-eur">EUR: 100.00</p>
                <p class="badge text-bg-info" id="balance-gbp">GBP: 0.00</p>
                <p id="total-value">Total Value: £0.00</p>
            </div>
            <div class="col-lg-2">
                <div class="input-group">
                    <span class="input-group-btn">
                        <div class="btn disabled">£</div>
                    </span>
                    <input type="text" id="quantity" name="quantity" class="form-control input-number" value="10" min="1" max="100">
                    <span class="input-group-btn">
                        <button type="button" class="quantity-left-minus btn btn-danger btn-number" data-type="minus" data-field="">
                            <span class="glyphicon glyphicon-minus">Buy</span>
                        </button>
                    </span>
                    <span class="input-group-btn">
                        <button type="button" class="quantity-right-plus btn btn-success btn-number" data-type="plus" data-field="">
                            <span class="glyphicon glyphicon-plus">Sell</span>
                        </button>
                    </span>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                <p id="trade-result"></p>
            </div>
        </div>
    </div>
</main>
<?php require_once("../include/footer.inc.php"); ?>