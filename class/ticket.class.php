<?php

require_once ("dbh.class.php");

class Ticket extends Dbh
{
    // Properties
    private $multiplier = [1, 5, 25, 300];
    private $values;
    private $errors = array();
    private $ticket;

    // Construct Method to assign values to properties
    public function __construct($ticket, $date, $quantity, $type)
    {
        // Assign Values
        $this->ticket = $ticket;
        $this->values = [
            "date" => $date,
            "quantity" => $quantity,
            "type" => $type,
        ];
    }

    //  ---------------------------------- Ticket Validation ---------------------------------- 

    // Method to check validation for all inputs
    public function validateTicket()
    {
        // Check errors for all input types
        $this->validateDate($this->values["date"]);
        $this->validateQuantity($this->values["quantity"]);
        $this->validateType($this->values["type"]);

        // Save data
        if (count($this->errors) == 0) {
            $prices = $this->getPrices($this->ticket);
            $price = $prices[ucfirst($this->values["type"])];

            // Add information to cart
            $this->addToCart($_COOKIE["userID"], $this->getItemID(), $this->values["quantity"], $this->values["date"], $this->values["type"], $price);
            header("location:payment.php");
            exit();
        }
    }

    // Method to validate date
    private function validateDate($date)
    {
        if (strlen($date) == 0) {
            array_push($this->errors, "date");
        }
    }

    // Method to validate quantity
    private function validateQuantity($qnty)
    {
        if ($qnty <= 0 || empty($qnty)) {
            array_push($this->errors, "quantity");
        }
    }

    // Method to validate type
    private function validateType($type)
    {
        if (strlen($type) == 0) {
            array_push($this->errors, "type");
        }
    }

    //  ---------------------------------- Other Methods ---------------------------------- 

    // Method to insert data into cart
    private function addToCart($id, $item, $qnty, $start, $type, $price)
    {
        $stmt = $this->connect()->prepare("INSERT INTO cart (userID,itemID,quantity,startDate,`type`,price) VALUES (?,?,?,?,?,?)");
        $stmt->execute([$id, $item, $qnty, $start, $type, $price]);
    }

    // GET Method to return id of the ticket
    private function getItemID()
    {
        $stmt = $this->connect()->prepare("SELECT infoID FROM ticket_info WHERE infoName = ?");
        $stmt->execute([ucfirst($this->ticket) . " Ticket"]);
        return $stmt->fetch()["infoID"];
    }

    // GET Method to return validation class
    public function getValid($type)
    {
        echo in_array($type, $this->errors) ? "is-invalid" : "is-valid";
    }

    // GET Method to return value
    public function getValue($value)
    {
        if ($value == "date") {
            echo $this->values["date"];
        } else if ($value == "quantity") {
            echo $this->values["quantity"];
        } else if ($value == $this->values["type"]) {
            echo "selected";
        }
    }

    // GET Method to format description
    private function formatDescription($string)
    {
        $string = explode(". ", $string);
        return join(".<br>", $string);
    }

    // GET Method to fetch all ticket information
    private function getData()
    {
        $stmt = $this->connect()->prepare("SELECT * FROM ticket_info");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // GET Method to fetch certain ticket information
    private function getTicket($ticket)
    {
        $stmt = $this->connect()->prepare("SELECT * FROM ticket_info WHERE infoName = ?");
        $stmt->execute([$ticket . " Ticket"]);
        return $stmt->fetch();
    }

    // GET Method to return "hidden" for certain sections
    public function getSection($type)
    {
        if ((isset($_GET["type"]) && $_GET["type"] == "payment" && $type == "default") || !isset($_GET["type"]) && $type == "information") {
            echo "hidden";
        }
    }

    // GET Method to return prices of each ticket type for certain ticket
    private function getPrices($ticket)
    {
        $result = $this->getTicket($ticket);
        return ["Day" => $result["infoPrice"] * $this->multiplier[0], "Week" => $result["infoPrice"] * $this->multiplier[1], "Month" => $result["infoPrice"] * $this->multiplier[2], "Year" => $result["infoPrice"] * $this->multiplier[3]];
    }

    //  ---------------------------------- Displaying Methods ---------------------------------- 

    // Method to display ticket information
    public function displayTickets()
    {
        $results = $this->getData();
        foreach ($results as $key => $value) {
            echo
                '<div class="card m-1" style="width: 24rem;">
                <img src="../images/panda.jfif" class="card-img-top" alt="animal image">
                <div class="card-body">
                    <h5 class="card-title text-center border-bottom">' . $value["infoName"] . '</h5>
                    <p class="card-text">' . $this->formatDescription($value["infoDescription"]) . '</p>
                    <div class="card-footer d-flex justify-content-between">
                        <span class="fs-5">Starts at £' . number_format($value["infoPrice"], 2) . '</span>
                        <a href="?type=payment&ticket=' . lcfirst(explode(" ", $value["infoName"])[0]) . '" class="btn btn-outline-light">Buy</a>
                    </div>
                </div>
            </div>';
        }
    }

    // Method to display ticket prices for each ticket type
    public function displayPrices()
    {
        $prices = $this->getPrices($this->ticket);
        foreach ($prices as $key => $value) {
            echo
                '
            <div class="col">
                <div class="card" style="width: 10rem;">
                    <div class="card-body text-center">
                        <h5 class="card-title">' . $key . ' Ticket</h5>
                        <p class="card-text">Price: £' . number_format($value, 2) . '</p>
                    </div>
                </div>
            </div>
            ';
        }
    }
}
