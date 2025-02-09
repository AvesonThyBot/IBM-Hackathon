<?php

class Dbh {
    // Properties
    private $host   = 'localhost';
    private $user   = 'root';
    private $password   = '';
    private $dbname = 'invested';

    // Method to connect to database
    protected function connect() {
        $pdo = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->user, $this->password);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    }
}
