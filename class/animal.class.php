<?php

require_once ("dbh.class.php");

class Animal extends Dbh
{
    // Properties
    private $type;
    private $animals;

    // Construct method to assign value
    public function __construct($type)
    {
        $this->type = $type;
        $this->animals = $this->getAnimals();
    }

    //  ---------------------------------- Main Methods ---------------------------------- 

    // GET Method to return all animals in database
    private function getAnimals()
    {
        $stmt = $this->connect()->prepare("SELECT animalName FROM animals");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    // GET Method top return hidden if section should be hidden
    public function getSection($section)
    {
        if (strlen($this->type) > 0 && in_array(ucfirst($this->type), $this->animals) && $section == "information") {
            echo "hidden";
        } elseif (strlen($this->type) == 0 && $section == "detail") {
            echo "hidden";
        }

    }

    // GET Method to return if file exists in directory
    private function getAnimalPic($name)
    {
        $filename = '../images/' . lcfirst($name) . '.jfif';
        return file_exists($filename) ? $filename : "../images/logo-white.png";
    }

    // GET Method to return any animal that fit search
    private function getSearch($search)
    {
        $stmt = $this->connect()->prepare("SELECT animalName FROM animals WHERE animalName LIKE ?");
        $stmt->execute(["%" . $search . "%"]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    //  ---------------------------------- Displaying Methods ---------------------------------- 

    // Method to display searched animals
    public function displaySearchedAnimals($search)
    {
        $result = $this->getSearch($search);
        foreach ($result as $key => $value) {
            echo '
                <div class="card" style="width: 18rem;">
                    <img src="' . $this->getAnimalPic($value) . '" class="card-img-top" alt="image of ' . $value . ' width="100px" height="140px" draggable="false"">
                    <div class="card-footer d-flex justify-content-between">
                        <span class="text-start my-auto">' . $value . '</span>
                        <a href="?type=' . lcfirst($value) . '" class="btn btn-light">Read More</a>
                    </div>
                </div>
                ';
        }
        if (count($result) == 0) {
            echo '
                    <div class="alert alert-danger d-flex justify-content-between" role="alert">
                        <p class="my-auto">Sorry! We do not have the animal "<strong>' . $search . '</strong>". Try again. </p>
                        <a class="btn btn-outline-danger" href="animal.php">Return</a>
                    </div>
                ';
        }
    }


    // Displaying Method to display ALL animals
    public function displayAnimals()
    {
        foreach ($this->animals as $key => $value) {
            echo '
            <div class="card" style="width: 18rem;">
                <img src="' . $this->getAnimalPic($value) . '" class="card-img-top" alt="image of ' . $value . ' width="100px" height="140px" draggable="false" ">
                <div class="card-footer d-flex justify-content-between">
                    <span class="text-start my-auto">' . $value . '</span>
                    <a href="?type=' . lcfirst($value) . '" class="btn btn-light">Read More</a>
                </div>
            </div>
            ';
        }
    }

}