<?php

require_once("include/autoloader.inc.php");

// Create Webpage Object
$webpage = new Webpage("Home - investED", "home");

// Insert Header
require_once("include/header.inc.php");
?>

<main>
    <!-- Hero Section -->
    <section class="hero">
        <img class="d-block mx-auto mb-4 img-fluid w-100" src="images/hero.jpeg" alt="InvestED Hero" id="hero">
        <div class="container text-center">
            <h1 class="fw-bold">Welcome to InvestED</h1>
            <p class="fs-5 text-muted">Master Forex Trading with Simulations & Market Insights</p>
        </div>
        <hr class="container border border-3 border-light rounded" />
    </section>

    <!-- Feature Cards -->
    <div class="container mb-5">
        <div class="row justify-content-center">
            <!-- Market Insights -->
            <div class="col-lg-4 col-md-6">
                <div class="card shadow-lg rounded-4 mx-2">
                    <img src="images/finance.jpg" class="card-img-top rounded-top-4" alt="Market Insights">
                    <div class="card-body">
                        <h5 class="card-title text-center border-bottom pb-2">Market Insights</h5>
                        <p class="card-text">Stay updated with the latest trends, stock market movements, and expert analysis.</p>
                        <div class="card-footer d-flex justify-content-end">
                            <a href="pages/market.php" class="btn btn-outline-primary">Read Insights</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Trading Simulator -->
            <div class="col-lg-4 col-md-6">
                <div class="card shadow-lg rounded-4 mx-2">
                    <img src="images/investment.jpeg" class="card-img-top rounded-top-4" alt="Trading Simulator">
                    <div class="card-body">
                        <h5 class="card-title text-center border-bottom pb-2">Trading Simulator</h5>
                        <p class="card-text">Practice forex trading in a risk-free environment with real-time market data.</p>
                        <div class="card-footer d-flex justify-content-end">
                            <a href="pages/simulator.php" class="btn btn-outline-primary">Start Trading</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Leaderboard -->
            <div class="col-lg-4 col-md-6">
                <div class="card shadow-lg rounded-4 mx-2">
                    <img src="images/stock4.jpeg" class="card-img-top rounded-top-4" alt="Leaderboard">
                    <div class="card-body">
                        <h5 class="card-title text-center border-bottom pb-2">Leaderboard</h5>
                        <p class="card-text">Compete with fellow investors, track your trading skills, and climb the ranks.</p>
                        <div class="card-footer d-flex justify-content-end">
                            <a href="pages/leaderboard.php" class="btn btn-outline-primary">View Leaderboard</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>

<?php require_once("include/footer.inc.php"); ?>