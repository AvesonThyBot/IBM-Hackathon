<?php 

require_once("dbh.class.php");

class Profile extends Dbh{
    // Properties
    private $id;
    private $values = [];
    private $errors = array();

    // Construct Method to assign value to properties
    public function __construct($id,$firstName,$lastName,$email,$password,$password2) {
        // Assign Values
        $this->id = $id;
        $this->values = [
            "firstName" => $firstName,
            "lastName" => $lastName,
            "email" => $email,
            "password" => $password,
            "password2" => $password2,

        ];
    }

    //  ---------------------------------- Profile Validation ---------------------------------- 
    
    // Method to validate names
    private function validateName($name,$type){
        if (empty($name) || strlen($name) < 3 || strlen($name) > 20 || !ctype_alpha($name)) {
            array_push($this->errors,$type);
        }
    } 

    // Method to validate email
    private function validateEmail($email){
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL) || $this->checkEmail($email)) {
            array_push($this->errors,"email");
        }
    } 

    // Method to validate password
    public function validatePassword(){
        if (empty($this->values["password"]) || strlen($this->values["password"]) < 5 || strlen($this->values["password"]) > 40 || ctype_alnum($this->values["password"]) == false) {
            array_push($this->errors,"password");
        }
        if (empty($this->values["password2"]) || strlen($this->values["password2"]) < 5 || strlen($this->values["password2"]) > 40 || ctype_alnum($this->values["password2"]) == false || $this->values["password"] !== $this->values["password2"]) {
            array_push($this->errors,"password2");
        }

        // Save data
        if(count($this->errors) == 0){
            $this->updatePassword($this->values["password"]);
            header("Location:?message=success");
            exit();
        }
    } 

    // Method to check validation for all inputs
    public function validateUpdate(){
        // Check errors for all input types
        $this->validateName($this->values["firstName"],"firstName");
        $this->validateName($this->values["lastName"],"lastName");
        $this->validateEmail($this->values["email"]);

        // Save data
        if(count($this->errors) == 0){
            $this->updateInfo($this->values["firstName"],$this->values["lastName"],$this->values["email"]);
            header("Location:?message=success");
            exit();
        }
    }

    //  ---------------------------------- Other Methods ---------------------------------- 

    // Method to update basic information on the database
    private function updateInfo($firstName,$lastName,$email){
        $stmt = $this->connect()->prepare("UPDATE users SET firstName = ?, lastName = ?, email = ? WHERE userID = ?");
        $stmt->execute([$firstName,$lastName,$email,$this->id]);
        return $stmt->rowCount() > 0;
    }
    
    // Method to update password on the database
    private function updatePassword($password){
        $stmt = $this->connect()->prepare("UPDATE users SET password_txt = ?");
        $password = password_hash($password, CRYPT_BLOWFISH); //encrypt password
        $stmt->execute([$password]);
        return $stmt->rowCount() > 0;
    }

    // GET Method to check if a certain error is present
    public function getError($error){
        return in_array($error,$this->errors) ? "is-invalid" : "is-valid";
    } 

    // Method to check if email is in database already
    private function checkEmail($email){
        $stmt = $this->connect()->prepare("SELECT * FROM users WHERE email = ? AND userID != ?");
        $stmt->execute([$email,$this->id]);
        return $stmt->rowCount() > 0;
    }

    // Method to fetch account data based on id
    private function getData(){
        $stmt = $this->connect()->prepare("SELECT * FROM users WHERE userID = ?");
        $stmt->execute([$this->id]);
        return $stmt->fetch();
    }

    // GET Method to return input values
    public function getValue($value){
        // Fetch data
        $data = $this->getData();
        // Change assoc key name 'password_txt' to 'password'
        $data['password'] = $data['password_txt'];
        unset($data['password_txt']);

        if (empty($this->values[$value]) && $value !== "password2" && $value !== "password") {
            return $data[$value];
        }elseif (($value == "password2" || $value == "password") && empty($this->values[$value]) ) {
            return "";
        }
        else {
            return $this->values[$value];
        }
    } 

    // Method to delete account from database
    public function deleteAccount(){
        $stmt = $this->connect()->prepare("DELETE FROM users WHERE userID = ?");
        $stmt->execute([$this->id]);
    }

}
