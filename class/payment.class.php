<?php

require_once ("dbh.class.php");

class Payment extends Dbh
{
    // Properties
    private $errors = array();
    private $values;
    private $type;
    private $payment;
    private $total;

    // Construct Method to assign value to properties
    public function __construct($type)
    {
        $this->type = $type;
    }

    // Method to pay & empty the cart
    public function payCart()
    {
        // Check if payment is done
        if (isset($_POST)) {
            // Insert into ticket
            $this->addTicket();

            // Add Points to account
            $this->addPoints();

            // Remove from cart
            $this->destroyCart();

            // Redirect
            header("location:../pages/bookings.php");
            exit();
        }
    }

    // Method to add cart tickets to ticket
    private function addTicket()
    {
        $result = $this->getCart($_COOKIE["userID"]);
        $currentDate = date("Y-m-d H:i:s");
        foreach ($result as $key => $value) {
            $stmt = $this->connect()->prepare("INSERT INTO ticket (ticketType,userID,startDate,endDate,price,quantity,purchaseDate) VALUES (?,?,?,?,?,?,?)");
            $stmt->execute([$value["itemID"], $_COOKIE["userID"], $value["startDate"], $this->getEndDB($value["startDate"], $value["type"]), number_format($value["price"] * $value["quantity"], 2), $value["quantity"], $currentDate]);
        }
    }

    // Method to add loyalty points to accounts
    public function addPoints()
    {
        $total = 0;
        $result = $this->getCart($_COOKIE["userID"]);
        foreach ($result as $key => $value) {
            $total += $value["price"] * $value["quantity"];
        }
        $points = $this->getPoints() + ($total * 1000);
        $stmt = $this->connect()->prepare("UPDATE users SET points = ? WHERE userID = ?");
        $stmt->execute([$points, $_COOKIE["userID"]]);
    }

    // GET Method to return value of points
    public function getPoints()
    {
        $stmt = $this->connect()->prepare("SELECT points FROM users WHERE userID = ?");
        $stmt->execute([$_COOKIE["userID"]]);
        return $stmt->fetch()["points"];
    }

    // Method to remove cart items
    private function destroyCart()
    {
        $id = $_COOKIE["userID"];
        $stmt = $this->connect()->prepare("DELETE FROM cart WHERE userID = ?");
        $stmt->execute([$id]);
    }

    //  ---------------------------------- Validation Methods ---------------------------------- 


    // Method to validate card
    public function validateCard($number, $name, $date, $cvv)
    {
        // Assign Values
        $this->values = [
            "number" => $number,
            "name" => $name,
            "date" => $date,
            "cvv" => $cvv,
        ];

        // Validate Inputs
        $this->validateNumber(trim($number));
        $this->validateName($name);
        $this->validateDate($date);
        $this->validateCvv($cvv);

        if (empty($this->errors)) {
            $this->payment = "card";
        }
    }

    // Method to validate paypal 
    public function validatePaypal($email)
    {
        // Assign Values
        $this->values = [
            "email" => $email,
        ];

        // Validate Inputs
        $this->validateEmail($email);

        if (empty($this->errors)) {
            $this->payment = "paypal";
        }
    }

    // Method to validate email
    private function validateEmail($email)
    {
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($this->errors, "email");
        }
    }

    // Method to validate number
    private function validateNumber($number)
    {
        if (!strlen($number) == 16) {
            array_push($this->errors, "number");
        }
    }

    // Method to validate name
    private function validateName($name)
    {
        if (empty($name) || strlen($name) < 5) {
            array_push($this->errors, "name");
        }
    }

    // Method to validate date
    private function validateDate($date)
    {
        if (!strlen($date) == 5) {
            array_push($this->errors, "date");
        }
    }

    // Method to validate number
    private function validateCvv($cvv)
    {
        if (empty($cvv)) {
            array_push($this->errors, "cvv");
        }
    }

    //  ---------------------------------- Other Methods ---------------------------------- 

    // GET Method to check if a error is present
    public function getValid($error)
    {
        return in_array($error, $this->errors) ? "is-invalid" : "is-valid";
    }

    // GET Method to return input values
    public function getValue($value)
    {
        return $this->values[$value];
    }

    // Method to return start date
    private function getStart($date)
    {
        return date("D F j, Y", strtotime($date));
    }

    // Method to return start date
    private function getEnd($date, $duration)
    {
        $start = strtotime($date);
        return date("D F j, Y", strtotime("+1 $duration", $start));
    }

    // Method to return start date
    private function getEndDB($date, $duration)
    {
        $start = strtotime($date);
        return date("Y-m-d", strtotime("+1 $duration", $start));
    }

    // Method to return cart data of id
    private function getCart($id)
    {
        $stmt = $this->connect()->prepare("SELECT * FROM cart WHERE userID = ?");
        $stmt->execute([$id]);
        return $stmt->fetchAll();
    }

    // Method to return item by id
    private function getItem($id)
    {
        $stmt = $this->connect()->prepare("SELECT * FROM ticket_info WHERE infoID = ?");
        $stmt->execute([$id]);
        return $stmt->fetch()["infoName"];
    }
    //  ---------------------------------- Displaying  Methods ---------------------------------- 

    // Method to display cart
    public function displayCart($id)
    {
        $result = $this->getCart($id);
        foreach ($result as $key => $value) {
            $this->total += $value["price"] * $value["quantity"];
            echo
                '<div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Item Information</h5>
                    <div class="d-flex justify-content-between">
                        <p class="card-text"><span class="fw-medium">Item:</span> ' . $this->getItem($value["itemID"]) . " (" . ucfirst($value["type"]) . ")" . '<br><span class="fw-medium">Start Date:</span> ' . $this->getStart($value["startDate"]) . '<br><span class="fw-medium">End Date:</span> ' . $this->getEnd($value["startDate"], $value["type"]) . '</p>
                        <div>
                            <button class="btn btn-danger">Delete</button>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between me-5">
                        <p class="card-text">Price: <br> £' . number_format($value["price"], 2) . '</p>
                        <p class="card-text">Quantity: <br>' . $value["quantity"] . '</p>
                        <p class="card-text">Total: <br> £' . number_format($value["price"] * $value["quantity"], 2) . '</p>
                    </div>
                </div>
            </div>';
        }

        if (count($result) == 0) {
            echo '
            <div class="alert alert-dark" role="alert">
                There is no items in your cart.
            </div>
            ';
        }
    }

    // Method to display purchase summary
    public function displaySummary()
    {
        echo
            '<div class="card-body">
            <h5 class="card-title">Payment Summary</h5>
            <div class="mb-1 small d-flex justify-content-between">
                <span>Sub-Total:</span>
                <span>£' . number_format($this->total, 2) . '</span>
            </div>
            <div class="mb-1 small d-flex justify-content-between">
                <span>Discount:</span>
                <span class="fw-light text-danger">-£0.00</span>
            </div>
            <hr>
            <div class="mb-2 small d-flex justify-content-between">
                <span>Total:</span>
                <span class="fw-bold">£' . number_format($this->total, 2) . '</span>
            </div>
            <div class="mb-2 small d-flex justify-content-between">
                <span>Points:</span>
                <span class="fw-bold">' . number_format($this->total * 1000) . '</span>
            </div>
            <p>By paying you have agreed to the <a target="_blank" href="../index.php?type=tcs">terms and conditions</a>.</p>
            <form method="post"><button class="btn btn-success w-100" name="payBtn">Pay</button></form>
        </div>
        ';
    }
}
