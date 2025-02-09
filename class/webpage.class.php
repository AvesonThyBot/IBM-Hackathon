<?php

class Webpage {
    // Properties
    private $title;
    private $active;

    // Construct Method to assign value to properties
    public function __construct($title, $active) {
        $this->title = $title;
        $this->active = $active;
    }

    // GETTER Method to return value of title 
    public function getTitle() {
        return $this->title;
    }

    // GETTER Method to return value of active  
    public function getActive($type) {
        // Discover page
        if ($type == "dropdown") {
            return in_array($this->active, ["education", "sandbox"]) ? 'active text-bg-light' : '';
        }

        return $type == $this->active ? 'active text-bg-light' : '';
    }

    // GETTER Method to return if footer should be hidden
    public function disableFooter() {
        echo in_array($this->active, ["account", "profile"]) ? "hidden" : '';
    }

    // GETTER Method to return if section should be hidden
    public function getSectionDisplay($type) {
        if (isset($_GET["type"]) && $_GET["type"] !== $type) {
            echo "hidden";
        }
    }

    // GETTER Method to return if the current page is sandbox
    public function getAPI() {
        return $this->active == "sandbox";
    }
}
