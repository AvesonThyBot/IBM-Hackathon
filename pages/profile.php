<?php

require_once("../include/autoloader.inc.php");

// Create object for webpage
$webpage = new Webpage("Profile - investED", "profile");

// Create object for profile
$profile = new Profile($_COOKIE["userID"] ?? '', $_POST["firstName"] ?? '', $_POST["lastName"] ?? '', $_POST["email"] ?? '', $_POST["password"] ?? '', $_POST["password2"] ?? '');

// Redirect if userID cookie is not set
if (!isset($_COOKIE["userID"])) {
    header("Location:../pages/account.php");
    exit();
}

// Logout & Redirect if type is logout
if (isset($_GET["type"]) && $_GET["type"] == "logout") {
    setcookie("userID", "", -1, "/");
    if (isset($_COOKIE["isAdmin"]))
        setcookie("isAdmin", "", -1, "/");
    header("Location:../pages/account.php?login");
    exit();
}

// Delete Account & Redirect if type is delete
if (isset($_GET["type"]) && $_GET["type"] == "delete") {
    setcookie("userID", "", -1, "/");
    $profile->deleteAccount();
    header("Location:../pages/account.php?login");
    exit();
}

// Validation request on update button press
if (isset($_POST['updateBtn'])) {
    // Validate & submit
    $profile->validateUpdate();
}

// Validation request on password button press
if (isset($_POST['passwordBtn'])) {
    // Validate & submit
    $profile->validatePassword();
}

// Insert header
require_once("../include/header.inc.php");
?>


<main>
    <h2 class="text-center">Profile Page</h2>
    <hr class="container border border-3 border-light rounded" />

    <!-- Main details -->
    <div class="container">
        <h2 class="h5">Basic Information</h2>
        <hr class="border border-1 w-25 border-light rounded" />

        <form class="row needs-validation d-flex justify-content-center" method="post" novalidate>
            <!-- First Name -->
            <span class="fs-5 ms-2">First Name<span class="text-danger">*</span></span>
            <div class="input-group mb-3 has-validation ">
                <span class="input-group-text">First</span>
                <input name="firstName" type="text" class="form-control <?php if (isset($_POST["updateBtn"]))
                                                                            echo $profile->getError("firstName") ?>" value="<?php echo $profile->getValue("firstName") ?>"
                    placeholder="First Name" aria-label="First Name">
                <div class="invalid-feedback">
                    First Name must be more than 3 letters and less than 20.
                </div>
            </div>

            <!-- Last Name -->
            <span class="fs-5 ms-2">Last Name<span class="text-danger">*</span></span>
            <div class="input-group mb-3 has-validation ">
                <span class="input-group-text">Last</span>
                <input name="lastName" type="text" class="form-control <?php if (isset($_POST["updateBtn"]))
                                                                            echo $profile->getError("lastName") ?>" value="<?php echo $profile->getValue("lastName") ?>"
                    placeholder="Last Name" aria-label="Last Name">
                <div class="invalid-feedback">
                    Last Name must be more than 3 letters and less than 20.
                </div>
            </div>

            <!-- Email -->
            <span class="fs-5 ms-2">Email<span class="text-danger">*</span></span>
            <div class="input-group mb-3 has-validation ">
                <span class="input-group-text">Email</span>
                <input name="email" type="text" class="form-control <?php if (isset($_POST["updateBtn"]))
                                                                        echo $profile->getError("email") ?>" value="<?php echo $profile->getValue("email") ?>"
                    placeholder="Email" aria-label="Email">
                <div class="invalid-feedback">
                    Email is invalid or taken.
                </div>
            </div>

            <!-- Submit Button -->
            <button name="updateBtn" type="submit" class="btn btn-outline-success col-3">Update</button>
        </form>
    </div>

    <!-- Reset Password -->
    <div class="container">
        <h2 class="h5">Reset Password</h2>
        <hr class="border border-1 w-25 border-light rounded" />

        <form class="row needs-validation d-flex justify-content-center" method="post" novalidate>
            <!-- Password -->
            <span class="fs-5 ms-2">Password<span class="text-danger">*</span></span>
            <div class="input-group mb-3 has-validation ">
                <span class="input-group-text">Password</span>
                <input name="password" type="password" class="form-control <?php if (isset($_POST["passwordBtn"]))
                                                                                echo $profile->getError("password") ?>" value="<?php if (isset($_POST["passwordBtn"]))
                                                                        echo $profile->getValue("password") ?>" placeholder="Password" aria-label="Password">
                <div class="invalid-feedback">
                    Password must be more than 5 characters and less than 40.
                </div>
            </div>

            <!-- Re-enter Password -->
            <span class="fs-5 ms-2">Re-enter Password<span class="text-danger">*</span></span>
            <div class="input-group mb-3 has-validation ">
                <span class="input-group-text">Password</span>
                <input name="password2" type="password" class="form-control <?php if (isset($_POST["passwordBtn"]))
                                                                                echo $profile->getError("password2") ?>" value="<?php if (isset($_POST["passwordBtn"]))
                                                                        echo $profile->getValue("password2") ?>" placeholder="Re-enter Password"
                    aria-label="Re-enter Password">
                <div class="invalid-feedback">
                    Re-enter Password needs to match password.
                </div>
            </div>

            <!-- Submit -->
            <button name="passwordBtn" type="submit" class="btn btn-outline-success col-3">Update</button>
        </form>
    </div>

    <!-- Other Button -->
    <div class="container d-flex justify-content-end gap-2">
        <a class="btn btn-secondary" href="?type=logout">Log Out</a>
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">Delete
            Account</button>
    </div>

    <!-- Account Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteModalLabel">Delete Account?</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body fs-5">
                    Do you want to delete this account? <div class="fw-bold">(This is irreversible.)</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a class="btn btn-danger" href="?type=delete">Delete</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Message -->
    <div class="toast align-items-center show border-0 position-fixed bottom-0 end-0 mb-3 text-bg-success" <?php if (!isset($_GET["message"]) || !$_GET["message"] == "success")
                                                                                                                echo "hidden" ?>>
        <div class="d-flex">
            <div class="toast-body">
                Sucessfully Updated Information!
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                aria-label="Close"></button>
        </div>
    </div>
</main>


<?php require_once("../include/footer.inc.php"); ?>