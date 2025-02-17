<?php

// Start session
session_start();
?>

<!doctype html>
<html lang="en">

<head>
    <title><?php echo $webpage->getTitle() ?></title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Favicon -->
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
    <!-- Bootstrap CSS 5.3.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Other CSS -->
    <link rel="stylesheet" href="../styles/mystyles.css">
</head>

<body data-bs-theme="light">
    <nav class="navbar navbar-expand-lg bg-body-tertiary nav-pills">
        <div class="container-fluid">
            <img class="navbar-brand" src="../images/logo.png" height="60px" draggable="false" />
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Nav links -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 text-center">
                    <li class="nav-item">
                        <a class="nav-link <?php echo $webpage->getActive("home") ?>" href="../index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $webpage->getActive("about") ?>" href="../pages/about.php">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $webpage->getActive("leaderboard") ?>" href="../pages/leaderboard.php">Leaderboard</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?php echo $webpage->getActive("dropdown") ?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Education
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item <?php echo $webpage->getActive("education") ?>" href="../pages/education.php">Education</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item <?php echo $webpage->getActive("sandbox") ?>" href="../pages/sandbox.php">Sandbox</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <!-- Button -->
                <div class="d-flex gap-2 my-1 me-2 d-flex justify-content-center">
                    <!-- Theme Toggle -->
                    <button class="btn btn-light" id="themeBtn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-sun-fill" viewBox="0 0 16 16">
                            <path d="M8 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8M8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0m0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13m8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5M3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8m10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0m-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0m9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707M4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708" />
                        </svg>
                    </button>

                </div>
                <!-- Drop Down -->
                <div class="navbar-nav me-2">
                    <li class="nav-item dropdown text-center">
                        <a class="nav-link dropdown-toggle button text-bg-light" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Account</a>
                        <ul class="dropdown-menu dropdown-menu-end mt-1">
                            <?php if (isset($_COOKIE["userID"])) { ?>
                                <li><a class="dropdown-item" href="../pages/profile.php">Account</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="../pages/profile.php?type=logout">Logout</a></li>
                            <?php } else { ?>
                                <li><a class="dropdown-item" href="../pages/account.php?type=login">Login</a></li>
                                <li><a class="dropdown-item" href="../pages/account.php?type=register">Register</a></li>
                            <?php } ?>
                        </ul>
                    </li>
                </div>
            </div>
        </div>
    </nav>