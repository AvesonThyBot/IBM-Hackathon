<?php 

require_once("../include/autoloader.inc.php");

// Create object for webpage
$webpage = new Webpage("Account - RZA","account");


// Create object for account
$account = new Account($_POST["firstName"] ?? '',$_POST["lastName"] ?? '',$_POST["email"] ?? '',$_POST["password"] ?? '',$_POST["password2"] ?? '');

// Validation request on button press
if(isset($_POST['registerBtn'])){
    // Validate & submit
    $account->validateRegister();
}

// Validation request on button press
if(isset($_POST['loginBtn'])){
    // Validate & login
    $account->validateLogin();
}

// Redirect if theres no type in url
if (!isset($_GET["type"])) {
    header("Location:account.php?type=register");
    exit();
}

// Redirect if userID cookie is not set
if (isset($_COOKIE["userID"])) {
    header("Location:../pages/account.php");
    exit();
}

// Insert header    
require_once("../include/header.inc.php");
?>

<main>
    <!-- Register -->
    <section class="container" <?php $webpage->getSectionDisplay('register');?>>
        <h2 class="text-center">Register Page</h2>
        <hr class="container border border-3 border-light rounded"/>

        <form class="row needs-validation d-flex justify-content-center" method="post" novalidate>
            <!-- First Name -->
            <span class="fs-5 ms-2">First Name<span class="text-danger">*</span></span>
            <div class="input-group mb-3 has-validation ">
                <span class="input-group-text">First</span>
                <input name="firstName" type="text" class="form-control <?php if (isset($_POST["registerBtn"])) echo $account->getError("firstName")?>" value="<?php if (isset($_POST["registerBtn"])) echo $account->getValue("firstName") ?>" placeholder="First Name" aria-label="First Name">
                <div class="invalid-feedback">
                    First Name must be more than 3 letters and less than 20.
                </div>
            </div>
            
            <!-- Last Name -->
            <span class="fs-5 ms-2">Last Name<span class="text-danger">*</span></span>
            <div class="input-group mb-3 has-validation ">
                <span class="input-group-text">Last</span>
                <input name="lastName" type="text" class="form-control <?php if (isset($_POST["registerBtn"])) echo $account->getError("lastName")?>" value="<?php if (isset($_POST["registerBtn"])) echo $account->getValue("lastName") ?>" placeholder="Last Name" aria-label="Last Name">
                <div class="invalid-feedback">
                    Last Name must be more than 3 letters and less than 20.
                </div>
            </div>

            <!-- Email -->
            <span class="fs-5 ms-2">Email<span class="text-danger">*</span></span>
            <div class="input-group mb-3 has-validation ">
                <span class="input-group-text">Email</span>
                <input name="email" type="text" class="form-control <?php if (isset($_POST["registerBtn"])) echo $account->getError("email")?>" value="<?php if (isset($_POST["registerBtn"])) echo $account->getValue("email") ?>" placeholder="Email" aria-label="Email">
                <div class="invalid-feedback">
                    Email is invalid or taken.
                </div>                
            </div>

            <!-- Password -->
            <span class="fs-5 ms-2">Password<span class="text-danger">*</span></span>
            <div class="input-group mb-3 has-validation ">
                <span class="input-group-text">Password</span>
                <input name="password" type="password" class="form-control <?php if (isset($_POST["registerBtn"])) echo $account->getError("password")?>" value="<?php if (isset($_POST["registerBtn"])) echo $account->getValue("password") ?>" placeholder="Password" aria-label="Password">
                <div class="invalid-feedback">
                    Password must be more than 5 characters and less than 40.
                </div>                
            </div>

            <!-- Re-enter Password -->
            <span class="fs-5 ms-2">Re-enter Password<span class="text-danger">*</span></span>
            <div class="input-group mb-3 has-validation ">
                <span class="input-group-text">Password</span>
                <input name="password2" type="password" class="form-control <?php if (isset($_POST["registerBtn"])) echo $account->getError("password2")?>" value="<?php if (isset($_POST["registerBtn"])) echo $account->getValue("password2") ?>" placeholder="Re-enter Password" aria-label="Re-enter Password">
                <div class="invalid-feedback">
                    Re-enter Password needs to match password.
                </div>                
            </div>

            <!-- Submit Button -->
            <button name="registerBtn" type="submit" class="btn btn-light col-6">Register</button>
        </form> 

        <!-- Other form of login -->
        <div class="container d-flex col justify-content-center mt-3">
            <hr class="w-25">
            <div class="text-center mx-4">Or Sign Up Using</div>
            <hr class="w-25">
        </div>
    
        <div class="container d-flex justify-content-center col-12 text-center mt-3 mb-3 gap-3">
            <button type="button" class="btn btn-outline-success">Google</button>
            <button type="button" class="btn btn-outline-light">Twitter</button>
            <button type="button" class="btn btn-outline-primary">Facebook</button>
        </div>

        <div class="text-center">Already have an account? <a href="account.php?type=login">Log in.</a></div>
    </section>

    <!-- Login -->
    <section class="container" <?php  $webpage->getSectionDisplay('login');?>>
    <h2 class="text-center">Login Page</h2>
        <hr class="container border border-3 border-light rounded"/>

        <form class="row needs-validation d-flex justify-content-center" method="post" novalidate>
            <!-- Email -->
            <span class="fs-5 ms-2">Email<span class="text-danger">*</span></span>
            <div class="input-group mb-3 has-validation ">
                <span class="input-group-text">Email</span>
                <input name="email" type="text" class="form-control <?php if (isset($_POST["loginBtn"])) echo $account->getError("email")?>" value="<?php if (isset($_POST["loginBtn"])) echo $account->getValue("email") ?>" placeholder="Email" aria-label="Email">
                <div class="invalid-feedback">
                    Email is invalid.
                </div>                
            </div>

            <!-- Password -->
            <span class="fs-5 ms-2">Password<span class="text-danger">*</span></span>
            <div class="input-group mb-3 has-validation ">
                <span class="input-group-text">Password</span>
                <input name="password" type="password" class="form-control <?php if (isset($_POST["loginBtn"])) echo $account->getError("password")?>" value="<?php if (isset($_POST["loginBtn"])) echo $account->getValue("password") ?>" placeholder="Password" aria-label="Password">
                <div class="invalid-feedback">
                    Password must be more than 5 characters and less than 40.
                </div>                
            </div>

            <!-- Submit Button -->
            <button name="loginBtn" type="submit" class="btn btn-light col-6">Login</button>
        </form> 

        <!-- Other form of login -->
        <div class="container d-flex col justify-content-center mt-3">
            <hr class="w-25">
            <div class="text-center mx-4">Or Sign In Using</div>
            <hr class="w-25">
        </div>
    
        <div class="container d-flex justify-content-center col-12 text-center mt-3 mb-3 gap-3">
            <button type="button" class="btn btn-outline-success">Google</button>
            <button type="button" class="btn btn-outline-light">Twitter</button>
            <button type="button" class="btn btn-outline-primary">Facebook</button>
        </div>

        <div class="text-center">Don't have a account? <a href="account.php?type=register">Create Now.</a></div>
    </section>

</main>


<?php require_once("../include/footer.inc.php"); ?>