<?php

require_once("dbh.class.php");

class Account extends Dbh {
    // Properties
    private $values = [];
    private $errors = array();

    // Construct Method to assign value to properties
    public function __construct($firstName, $lastName, $email, $password, $password2) {
        // Assign Values
        $this->values = [
            "firstName" => $firstName,
            "lastName" => $lastName,
            "email" => $email,
            "password" => $password,
            "password2" => $password2
        ];
    }

    //  ---------------------------------- Register Validation ---------------------------------- 

    // Method to validate names
    private function validateName($name, $type) {
        if (empty($name) || strlen($name) < 3 || strlen($name) > 20 || !ctype_alpha($name)) {
            array_push($this->errors, $type);
        }
    }

    // Method to validate email
    private function validateEmail($email) {
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL) || $this->checkEmail($email)) {
            array_push($this->errors, "email");
        }
    }

    // Method to validate password
    private function validatePassword($password, $password2) {
        if (empty($password) || strlen($password) < 5 || strlen($password) > 40 || ctype_alnum($password) == false) {
            array_push($this->errors, "password");
        }
        if (empty($password2) || strlen($password2) < 5 || strlen($password2) > 40 || ctype_alnum($password2) == false || $password !== $password2) {
            array_push($this->errors, "password2");
        }
    }

    // Method to check validation for all inputs
    public function validateRegister() {
        // Check errors for all input types
        $this->validateName($this->values["firstName"], "firstName");
        $this->validateName($this->values["lastName"], "lastName");
        $this->validateEmail($this->values["email"]);
        $this->validatePassword($this->values["password"], $this->values["password2"]);

        // Save data
        if (count($this->errors) == 0) {
            $this->registerAccount($this->values["firstName"], $this->values["lastName"], $this->values["email"], $this->values["password"]);

            // Assign customerID cookie
            setcookie("userID", $this->getID($this->values["email"])["userID"], time() + (86400 * 30), "/");
            header("Location:../index.php");
            exit();
        }
    }

    // Method to insert data into database
    private function registerAccount($firstName, $lastName, $email, $password) {
        $stmt = $this->connect()->prepare("INSERT INTO users (firstName,lastName,email,password_txt) VALUES (?,?,?,?)");
        $password = password_hash($password, CRYPT_BLOWFISH); //encrypt password
        $stmt->execute([$firstName, $lastName, $email, $password]);
    }


    //  ---------------------------------- Login Validation ---------------------------------- 
    // Method to check validation for all inputs
    public function validateLogin() {
        // Check errors for all input types
        $this->validateLoginEmail($this->values["email"]);
        $this->validateLoginPassword($this->values["password"]);

        // Save data
        if (count($this->errors) == 0) {
            $this->loginAccount();
        }
    }

    // Method to insert data into database
    private function loginAccount() {
        // Fetch ID
        $id = $this->getID($this->values["email"]);
        // Assign customerID cookie
        setcookie("userID", $id["userID"], time() + (86400 * 30), "/");

        if ($id["isAdmin"] == 1) {
            setcookie("isAdmin", true, time() + (86400 * 30), "/");
        }
        header("Location:../index.php");
        exit();
    }

    // Method to validate login email
    private function validateLoginEmail($email) {
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL) || !$this->checkEmail($email)) {
            array_push($this->errors, "email");
        }
    }

    // Method to validate login password
    private function validateLoginPassword($password) {
        $dbPassword = $this->setPassword();
        if (empty($password) || strlen($password) < 5 || strlen($password) > 40 || ctype_alnum($password) == false || !password_verify($password, $dbPassword)) {
            array_push($this->errors, "password");
        }
    }

    // Method to fetch password for account
    private function setPassword() {
        $stmt = $this->connect()->prepare("SELECT password_txt FROM users WHERE email = ?");
        $stmt->execute([$this->values["email"]]);
        return $stmt->rowCount() !== 0 ? $stmt->fetch()["password_txt"] : '';
    }

    //  ---------------------------------- Other Methods ---------------------------------- 

    // GET Method to check if a certain error is present
    public function getError($error) {
        return in_array($error, $this->errors) ? "is-invalid" : "is-valid";
    }

    // Method to check if email is in database already
    private function checkEmail($email) {
        $stmt = $this->connect()->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->rowCount() > 0;
    }

    // Method to check if email is in database already
    private function getID($email) {
        $stmt = $this->connect()->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    // GET Method to return input values
    public function getValue($value) {
        return $this->values[$value];
    }
}
