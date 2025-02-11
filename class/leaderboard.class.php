<?php

require_once("dbh.class.php");

class Leaderboard extends Dbh {
    // Properties
    private $user_id;
    private $score;

    // Constructor (optional user ID assignment)
    public function __construct($user_id = null) {
        $this->user_id = $user_id;
    }

    // --------------------------- Retrieve Data ---------------------------

    // Get a user's score by ID
    public function getScoreByUserId() {
        $stmt = $this->connect()->prepare("SELECT score FROM gamification WHERE user_id = ?");
        $stmt->execute([$this->user_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result["score"] : 0; // Return 0 if no score found
    }

    // Get full leaderboard (top scores first)
    public function getLeaderboard($limit = 10) {
        $stmt = $this->connect()->prepare("
        SELECT users.firstName, users.lastName, gamification.score 
        FROM gamification 
        JOIN users ON gamification.user_id = users.UserID
        ORDER BY gamification.score DESC
        LIMIT ?
        ");
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }

    // --------------------------- Update Data ---------------------------

    // Add or update a user's score
    public function updateScore($newScore) {
        // Check if user already has a score entry
        $stmt = $this->connect()->prepare("SELECT score FROM gamification WHERE user_id = ?");
        $stmt->execute([$this->user_id]);

        if ($stmt->rowCount() > 0) {
            // Update existing score
            $stmt = $this->connect()->prepare("UPDATE gamification SET score = ?, date_and_time = NOW() WHERE user_id = ?");
            $stmt->execute([$newScore, $this->user_id]);
        } else {
            // Insert new score entry
            $stmt = $this->connect()->prepare("INSERT INTO gamification (user_id, score) VALUES (?, ?)");
            $stmt->execute([$this->user_id, $newScore]);
        }
    }
}
