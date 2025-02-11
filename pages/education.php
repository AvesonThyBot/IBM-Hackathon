<?php

require_once("../include/autoloader.inc.php");

// Create object for webpage
$webpage = new Webpage("Education - investED", "education");

// Insert header
require_once("../include/header.inc.php");
?>

<main>
    <!-- Hero -->
    <img class="d-block mx-auto mb-4 image-fluid w-100" src="../images/hero.jpeg" alt="" id="hero"></img>
    <h1 class="text-center">Education</h1>
    <hr class="container border border-3 border-light rounded" />



    <div class="album py-5">
        <div class="container">

            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">

                <div class="col">
                    <div class="card shadow-lg rounded-4 mx-4">
                        <img src="/images/stock5.jpeg" class="card-img-top rounded-top-4" width="100%" height="225" alt="Top 10 Stocks">
                        <div class="card-header">
                            <h3>Top 10 Stocks</h3>
                        </div>
                        <div class="card-body">
                            <p class="card-text">A curated list of the top-performing stocks based on market trends, growth, and stability.</p>
                            <div>
                                <span class="text-body-secondary float-end">9 mins</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card shadow-lg rounded-4 mx-4">
                        <img src="/images/stock3.jpeg" class="card-img-top rounded-top-4" width="100%" height="225" alt="Top 10 Stocks">
                        <div class="card-header">
                            <h3>How to Analyze Stocks</h3>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Learn key metrics like P/E ratio, EPS, and dividend yield to evaluate stocks effectively.</p>
                            <div>
                                <span class="text-body-secondary float-end">8 mins</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card shadow-lg rounded-4 mx-4">
                        <img src="/images/stocks6.jpg" class="card-img-top rounded-top-4" width="100%" height="225" alt="Top 10 Stocks">
                        <div class="card-header">
                            <h3>Best Dividend Stocks</h3>
                        </div>
                        <div class="card-body">
                            <p class="card-text">A list of stable companies that provide consistent and high dividend payouts to investors.</p>
                            <div>
                                <span class="text-body-secondary float-end">7 mins</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card shadow-lg rounded-4 mx-4">
                        <img src="/images/stock4.jpeg" class="card-img-top rounded-top-4" width="100%" height="225" alt="Top 10 Stocks">
                        <div class="card-header">
                            <h3>Stock Market Trends</h3>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Stay updated on current market trends, sector performances, and investor sentiments.</p>
                            <div>
                                <span class="text-body-secondary float-end">6 mins</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card shadow-lg rounded-4 mx-4">
                        <img src="/images/stocks2.jpeg" class="card-img-top rounded-top-4" width="100%" height="225" alt="Top 10 Stocks">
                        <div class="card-header">
                            <h3>Investing Strategies</h3>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Explore different strategies such as value investing, growth investing, and index funds.</p>
                            <div>
                                <span class="text-body-secondary float-end">10 mins</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card shadow-lg rounded-4 mx-4">
                        <img src="/images/etf.jpeg" class="card-img-top rounded-top-4" width="100%" height="225" alt="Top 10 Stocks">
                        <div class="card-header">
                            <h3>Understanding ETFs</h3>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Learn about Exchange-Traded Funds and how they provide diversified exposure to the market.</p>
                            <div>
                                <span class="text-body-secondary float-end">5 mins</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card shadow-lg rounded-4 mx-4">
                        <img src="/images/stocks.jpeg" class="card-img-top rounded-top-4" width="100%" height="225" alt="Top 10 Stocks">
                        <div class="card-header">
                            <h3>Stock Market Risks</h3>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Understand the risks involved in stock investing and how to manage them effectively.</p>
                            <div>
                                <span class="text-body-secondary float-end">7 mins</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card shadow-lg rounded-4 mx-4">
                        <img src="/images/investment.jpeg" class="card-img-top rounded-top-4" width="100%" height="225" alt="Top 10 Stocks">
                        <div class="card-header">
                            <h3>Long-term vs. Short-term Investing</h3>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Discover the benefits and risks of long-term investing compared to short-term trading.</p>
                            <div>
                                <span class="text-body-secondary float-end">8 mins</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card shadow-lg rounded-4 mx-4">
                        <img src="/images/money.jpeg" class="card-img-top rounded-top-4" width="100%" height="225" alt="Top 10 Stocks">
                        <div class="card-header">
                            <h3>How to Read Stock Charts</h3>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Gain insights into technical analysis and learn how to interpret stock charts.</p>
                            <div>
                                <span class="text-body-secondary float-end">9 mins</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</main>

<?php require_once("../include/footer.inc.php"); ?>