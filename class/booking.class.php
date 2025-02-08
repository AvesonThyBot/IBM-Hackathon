<?php

require_once ("dbh.class.php");

class Booking extends Dbh
{
    // Properties
    private $id;

    // Construct Method to assign value to properties
    public function __construct($id)
    {
        $this->id = $id;
    }

    //  ---------------------------------- Booking Methods ---------------------------------- 

    // Method to get all upcoming hotel booking
    private function getUpcomingHotel()
    {
        $stmt = $this->connect()->prepare("SELECT * FROM hotel WHERE userID = ? AND startDate > ?");
        $stmt->execute([$this->id, date("Y-m-d")]);
        return $stmt->fetchAll();
    }

    // Method to get all old hotel booking
    private function getOldHotel()
    {
        $stmt = $this->connect()->prepare("SELECT * FROM hotel WHERE userID = ? AND endDate < ?");
        $stmt->execute([$this->id, date("Y-m-d")]);
        return $stmt->fetchAll();
    }

    // Method to get all active hotel booking
    private function getActiveHotel()
    {
        $stmt = $this->connect()->prepare("SELECT * FROM hotel WHERE userID = ? AND (startDate <= ? AND endDate > ?)");
        $stmt->execute([$this->id, date("Y-m-d"), date("Y-m-d")]);
        return $stmt->fetchAll();
    }

    //  ---------------------------------- Ticket Methods ---------------------------------- 

    // Method to get all upcoming tickets
    private function getUpcomingTicket()
    {
        $stmt = $this->connect()->prepare("SELECT * FROM ticket WHERE userID = ? AND startDate > ?");
        $stmt->execute([$this->id, date("Y-m-d")]);
        return $stmt->fetchAll();
    }

    // Method to get all old tickets
    private function getOldTicket()
    {
        $stmt = $this->connect()->prepare("SELECT * FROM ticket WHERE userID = ? AND endDate < ?");
        $stmt->execute([$this->id, date("Y-m-d")]);
        return $stmt->fetchAll();
    }

    // Method to get all active tickets
    private function getActiveTicket()
    {
        $stmt = $this->connect()->prepare("SELECT * FROM ticket WHERE userID = ? AND (startDate <= ? AND endDate > ?)");
        $stmt->execute([$this->id, date("Y-m-d"), date("Y-m-d")]);
        return $stmt->fetchAll();
    }


    //  ---------------------------------- Other Methods ---------------------------------- 

    // Method to return ticket item by id
    private function getTicket($id)
    {
        $stmt = $this->connect()->prepare("SELECT * FROM ticket_info WHERE infoID = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // Method to return hotel info item by id
    private function getRoom($id)
    {
        $stmt = $this->connect()->prepare("SELECT * FROM hotel_info WHERE roomID = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // Method to format date
    private function formatDate($date)
    {
        return date("D F j, Y", strtotime($date));
    }

    // Method to remove ticket from database
    private function removeTicket($id)
    {
        $stmt = $this->connect()->prepare("DELETE FROM ticket WHERE ticketID = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // Method to remove hotel booking from database
    private function removeBooking($id)
    {
        $stmt = $this->connect()->prepare("DELETE FROM hotel WHERE hotelID = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // Method to manage removal of item
    public function removeItem($type, $id)
    {
        // Iterate which item needs to be removed
        if ($type == "ticket") {
            $this->removeTicket($id);
        } else {
            $this->removeBooking($id);
        }
        $this->removePoints($this->getPrice($id));

    }

    // GET Method to return price of a booking
    public function getPrice($id)
    {
        $stmt = $this->connect()->prepare("SELECT price FROM hotel WHERE hotelID = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // Method to remove points to user
    public function removePoints($points)
    {
        $points = $this->getPoints() - ($points * 1000);
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

    // -------- Ticket -------- 

    // Method to display upcoming tickets
    public function displayUCTicket()
    {
        $result = $this->getUpcomingTicket();
        foreach ($result as $key => $value) {
            $ticket = $this->getTicket($value["ticketType"]);
            echo '<li class="list-group-item d-flex justify-content-between"><p>' . $ticket["infoName"] . '</p> <p>Start Date: ' . $this->formatDate($value["startDate"]) . ' <br>End Date: ' . $this->formatDate($value["endDate"]) . '<br>Purchase Date: ' . $this->formatDate($value["purchaseDate"]) . '</p> <p>Quantity: ' . $value["quantity"] . '<bR>Total: £' . number_format($value["price"], 2) . '<form method="post" class="text-end my-auto"><input type="hidden" name="type" value="ticket"><input type="hidden" name="id" value="' . $value["ticketID"] . '"><button name="removeBtn" class="btn btn-danger">Remove</button></form></p></li>';
        }

        if (count($result) == 0) {
            echo '
            <div class="list-group-item" role="alert">
                There is no tickets in this section.
            </div>
            ';
        }
    }

    // Method to display old tickets
    public function displayOldTicket()
    {
        $result = $this->getOldTicket();
        foreach ($result as $key => $value) {
            $ticket = $this->getTicket($value["ticketType"]);
            echo '<li class="list-group-item d-flex justify-content-between"><p>' . $ticket["infoName"] . '</p> <p>Start Date: ' . $this->formatDate($value["startDate"]) . ' <br>End Date: ' . $this->formatDate($value["endDate"]) . '<br>Purchase Date: ' . $this->formatDate($value["purchaseDate"]) . '</p> <p>Quantity: ' . $value["quantity"] . '<bR>Total: £' . number_format($value["price"], 2) . '</p></li>';
        }

        if (count($result) == 0) {
            echo '
            <div class="list-group-item" role="alert">
                There is no tickets in this section.
            </div>
            ';
        }
    }

    // Method to display active tickets
    public function displayActiveTicket()
    {
        $result = $this->getActiveTicket();
        foreach ($result as $key => $value) {
            $ticket = $this->getTicket($value["ticketType"]);
            echo '<li class="list-group-item d-flex justify-content-between"><p>' . $ticket["infoName"] . '</p> <p>Start Date: ' . $this->formatDate($value["startDate"]) . ' <br>End Date: ' . $this->formatDate($value["endDate"]) . '<br>Purchase Date: ' . $this->formatDate($value["purchaseDate"]) . '</p> <p>Quantity: ' . $value["quantity"] . '<bR>Total: £' . number_format($value["price"], 2) . '<form method="post" class="text-end my-auto"><input type="hidden" name="type" value="ticket"><input type="hidden" name="id" value="' . $value["ticketID"] . '"><button name="removeBtn" class="btn btn-danger">Remove</button></form></p></li>';
        }

        if (count($result) == 0) {
            echo '
            <div class="list-group-item" role="alert">
                There is no tickets in this section.
            </div>
            ';
        }
    }

    // -------- Hotel -------- 

    // Method to display upcoming hotel booking
    public function displayUCHotel()
    {
        $result = $this->getUpcomingHotel();
        foreach ($result as $key => $value) {
            $ticket = $this->getRoom($value["hotelID"]);
            echo '<li class="list-group-item d-flex justify-content-between"><p>' . $ticket["roomName"] . ' Room <br> (Room: ' . number_format($ticket["roomID"] / 100, 2) . ')</p> <p>Start Date: ' . $this->formatDate($value["startDate"]) . ' <br>End Date: ' . $this->formatDate($value["endDate"]) . '<br>Purchase Date: ' . $this->formatDate($value["purchaseDate"]) . '</p> Total: £' . number_format($value["price"], 2) . '<form method="post" class="text-end my-auto"><input type="hidden" name="type" value="hotel"><input type="hidden" name="id" value="' . $value["hotelID"] . '"><button name="removeBtn" class="btn btn-danger">Remove</button></form></p></li>';
        }

        if (count($result) == 0) {
            echo '
            <div class="list-group-item" role="alert">
                There is no hotel bookings in this section.
            </div>
            ';
        }
    }

    // Method to display old hotel booking
    public function displayOldHotel()
    {
        $result = $this->getOldHotel();
        foreach ($result as $key => $value) {
            $ticket = $this->getRoom($value["hotelID"]);
            echo '<li class="list-group-item d-flex justify-content-between"><p>' . $ticket["roomName"] . ' Room <br> (Room: ' . number_format($ticket["roomID"] / 100, 2) . ')</p> <p>Start Date: ' . $this->formatDate($value["startDate"]) . ' <br>End Date: ' . $this->formatDate($value["endDate"]) . '<br>Purchase Date: ' . $this->formatDate($value["purchaseDate"]) . '</p> <p>Total: £' . number_format($value["price"], 2) . '</p></li>';
        }

        if (count($result) == 0) {
            echo '
            <div class="list-group-item" role="alert">
                There is no hotel bookings in this section.
            </div>
            ';
        }
    }

    // Method to display active hotel booking
    public function displayActiveHotel()
    {
        $result = $this->getActiveHotel();
        foreach ($result as $key => $value) {
            $ticket = $this->getRoom($value["hotelID"]);
            echo '<li class="list-group-item d-flex justify-content-between"><p>' . $ticket["roomName"] . ' Room <br> (Room: ' . number_format($ticket["roomID"] / 100, 2) . ')</p> <p>Start Date: ' . $this->formatDate($value["startDate"]) . ' <br>End Date: ' . $this->formatDate($value["endDate"]) . '<br>Purchase Date: ' . $this->formatDate($value["purchaseDate"]) . '</p> Total: £' . number_format($value["price"], 2) . '<form method="post" class="text-end my-auto"><input type="hidden" name="type" value="hotel"><input type="hidden" name="id" value="' . $value["hotelID"] . '"><button name="removeBtn" class="btn btn-danger">Remove</button></form></p></li>';
        }

        if (count($result) == 0) {
            echo '
            <div class="list-group-item" role="alert">
                There is no hotel bookings in this section.
            </div>
            ';
        }
    }
}
