<?php

require_once("../include/autoloader.inc.php");
// Create Webpage Object
$webpage = new Webpage("Leaderboard - investED", "leaderboard");

$leaderboard = new Leaderboard($_COOKIE["userID"] ?? 0);

// Fetch data
$userScore = $leaderboard->getScoreByUserId();
$topPlayers = $leaderboard->getLeaderboard();

// Insert header
require_once("../include/header.inc.php");
?>

<main>
    <!-- Hero Section -->
    <img class="d-block mx-auto mb-4 img-fluid w-100" src="../images/hero.jpeg" alt="Leaderboard Hero Image" id="hero">
    <h1 class="text-center">Leaderboard</h1>
    <hr class="container border border-3 border-light rounded" />

    <div class="container mt-4">
        <!-- User Score -->
        <div class="card shadow-lg rounded-4 mb-4">
            <div class="card-header bg-primary text-white text-center">
                <h2>Your Score</h2>
            </div>
            <div class="card-body text-center">
                <h3 class="text-success">£<?= number_format($userScore, 2); ?></h3>
            </div>
        </div>

        <!-- Leaderboard Table -->
        <div class="card shadow-lg rounded-4">
            <div class="card-header text-center bg-primary text-white">
                <h2 class="mb-0">Top Traders</h2>
            </div>
            <div class="card-body">
                <table class="table table-striped text-center">
                    <thead>
                        <tr>
                            <th scope="col">Rank</th>
                            <th scope="col">Trader</th>
                            <th scope="col">Score</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($topPlayers)):
                            $rank = 1;
                            foreach ($topPlayers as $player): ?>
                                <tr>
                                    <td><strong>#<?= $rank++; ?></strong></td>
                                    <td><?= htmlspecialchars($player["firstName"] . " " . $player["lastName"]); ?></td>
                                    <td>£<?= number_format($player["score"], 2); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-muted">No traders found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<?php require_once("../include/footer.inc.php"); ?>