<?php

require_once ("dbh.class.php");

class Hotel extends Dbh
{
    // Properties
    private $values;
    private $room;
    private $errors = array();

    // SET Method to assign values to properties
    public function __construct($range, $type)
    {
        // Assign Values
        $this->values = [
            "startDate" => strlen($range) > 0 ? trim(explode(" to ", $range)[0]) : "",
            "endDate" => strlen($range) > 0 ? trim(explode(" to ", $range)[1]) : "",
            "type" => in_array(ucfirst($type), ["Single", "Double", "Deluxe", "Family"]) ? $type : "",
        ];
    }

    //  ---------------------------------- Hotel Validation ---------------------------------- 
    // Method to check validation for all inputs
    public function validateHotel()
    {
        // Check errors for all input types
        $this->validateDate($this->values["startDate"], "startDate");
        $this->validateDate($this->values["endDate"], "endDate");
        $this->validateType($this->values["type"]);

        // Save data
        if (count($this->errors) == 0) {
            $this->room = $this->getAvailable()["roomID"];
        }
    }

    // Method to validate date
    private function validateDate($date, $type)
    {
        if (strlen($date) == 0) {
            array_push($this->errors, $type);
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

    // Method to return only available dates
    private function getAvailable()
    {

        $startDate = (new DateTime($this->values["startDate"]))->format('Y-m-d');
        $endDate = (new DateTime($this->values["endDate"]))->format('Y-m-d');

        // Set up SQL statement
        $sql = "SELECT roomID
        FROM hotel_info 
        WHERE hotel_info.roomName = ?
        AND NOT EXISTS (
            SELECT 1
            FROM hotel
            WHERE hotel.hotelType = hotel_info.roomID
            AND (
                (hotel.startDate <= ? AND hotel.endDate >= ?) OR
                (hotel.startDate >= ? AND hotel.endDate <= ?) OR
                (hotel.endDate >= ? AND hotel.endDate <= ?)
            )
        )";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([ucfirst($this->values["type"]), $startDate, $endDate, $startDate, $endDate, $startDate, $endDate]);
        return $stmt->fetch(); // Fetches only one room
    }

    // GET Method to get all rooms that are avaialble
    private function getRooms()
    {
        $stmt = $this->connect()->prepare("SELECT DISTINCT roomName,roomDescription,roomPrice FROM hotel_info");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // GET Method to get certain room by id
    private function getRoom($id)
    {
        $stmt = $this->connect()->prepare("SELECT * FROM hotel_info WHERE roomID = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // GET Method to return "hidden" for certain sections
    public function getSection($type)
    {
        if ((isset($_GET["type"]) && $_GET["type"] == "payment" && $type == "default") || !isset($_GET["type"]) && $type == "payment") {
            echo "hidden";
        }
    }

    // GET Method to check amount of errors
    public function errorCount()
    {
        return count($this->errors);
    }

    // GET Method to format description
    private function formatDescription($string)
    {
        $string = explode(". ", $string);
        return join(".<br>", $string);
    }

    // GET Method to return validation class
    public function getValid($type)
    {
        echo in_array($type, $this->errors) ? "is-invalid" : "is-valid";
    }

    // Method to return date in a human friendly format
    private function getDate($date)
    {
        return date("D F j, Y", strtotime($date));
    }


    // Method to return full name
    private function getFullname()
    {
        $stmt = $this->connect()->prepare("SELECT firstName,lastName FROM users WHERE userID = ?");
        $stmt->execute([$_COOKIE["userID"]]);
        $data = $stmt->fetch();
        return ucfirst($data["firstName"]) . " " . ucfirst($data["lastName"]);
    }

    // Method to return difference between two dates
    private function getDifference()
    {
        return date_diff(
            date_create($this->values["startDate"]),
            date_create($this->values["endDate"])
        )->format('%a') + 1;
    }

    // Method to add to hotel table
    private function addHotel($id, $room, $start, $end, $price, $date)
    {
        $this->addPoints($price);
        $stmt = $this->connect()->prepare("INSERT INTO hotel (userID,hotelType,startDate,endDate,price,purchaseDate) VALUES (?,?,?,?,?,?)");
        return $stmt->execute([$id, $room, $start, $end, $price, $date]);
    }

    // Method to add points to user
    public function addPoints($points)
    {
        $points = $this->getPoints() + ($points * 1000);
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

    //  ---------------------------------- Displaying Methods ---------------------------------- 

    // Method to display all hotel rooms
    public function displayRooms()
    {
        $results = $this->getRooms();
        foreach ($results as $key => $value) {
            # code...
            echo
                '
            <div class="card m-1" style="width: 24rem;">
                <img src="../images/hotel.jfif" class="card-img-top" alt="animal image">
                <div class="card-body">
                    <h5 class="card-title text-center border-bottom">' . $value["roomName"] . ' Room</h5>
                    <p class="card-text">' . $this->formatDescription($value["roomDescription"]) . '</p>
                    <div class="card-footer d-flex justify-content-between">    
                        <span class="fs-5">£' . number_format($value["roomPrice"], 2) . '/day</span>
                        <a href="?type=payment&room=' . lcfirst($value["roomName"]) . '" class="btn btn-outline-light">Check Out</a>
                    </div>
                </div>
            </div>
            ';
        }
    }

    // Method to display information about room available
    public function displayInformation()
    {
        $result = $this->getRoom($this->room);
        echo '
            <div class="container my-5">
            <div class="row p-2">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Booking Information</h5>
                        <div class="d-flex justify-content-between">
                            <p class="card-text"><span class="fw-medium">Room:</span> ' . $result["roomName"] . ' Room<br><span class="fw-medium">Room Number:</span> ' . number_format($this->room / 100, 2) . '<br><span class="fw-medium">Start Date:</span> ' . $this->getDate($this->values["startDate"]) . '<br><span class="fw-medium">End Date:</span> ' . $this->getDate($this->values["endDate"]) . '</p>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between me-5">
                            <p class="card-text"><span class="fw-medium">Full Name:</span> <br>' . $this->getFullname() . '</p>
                            <p class="card-text"><span class="fw-medium">Days Booked:</span> <br>' . $this->getDifference() . ' Days</p>
                            <p class="card-text"><span class="fw-medium">Price:</span> <br> £' . number_format($result["roomPrice"] * $this->getDifference(), 2) . ' (£' . number_format($result["roomPrice"], 2) . '/day)</p>
                        </div>
                    </div>
                    <div class="alert alert-success" role="alert">
                        Your booking was a success! Check out your booking <a href="../pages/bookings.php">here</a>.
                    </div>
                </div>
            </div>
        </div>
        ';
        $this->addHotel($_COOKIE["userID"], $this->room, $this->values["startDate"], $this->values["endDate"], number_format($result["roomPrice"] * $this->getDifference(), 2), date("Y-m-d H:i:s"));
    }
}
