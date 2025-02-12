<?php

require_once("dbh.class.php");

class Leaderboard extends Dbh {
    // Properties
    private int $user_id;
    private float $score;

    // Constructor (optional user ID assignment)
    public function __construct(int $user_id = null) {
        $this->user_id = $user_id ?? 0; // Default to 0 if no ID is provided
    }

    // --------------------------- Retrieve Data ---------------------------

    // Get a user's score by ID
    public function getScoreByUserId(): float {
        $stmt = $this->connect()->prepare("SELECT score FROM gamification WHERE user_id = ?");
        $stmt->execute([$this->user_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? (float)$result["score"] : 0.0; // Return 0 if no score found
    }

    // Get full leaderboard (top scores first)
    public function getLeaderboard(): array {
        $stmt = $this->connect()->prepare("
            SELECT users.firstName, users.lastName, gamification.score 
            FROM gamification 
            JOIN users ON gamification.user_id = users.UserID
            ORDER BY gamification.score DESC
            LIMIT 10
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // --------------------------- Update Data ---------------------------

    // Add or update a user's score
    public function updateScore(float $newScore): bool {
        $stmt = $this->connect()->prepare("SELECT score FROM gamification WHERE user_id = ?");
        $stmt->execute([$this->user_id]);

        if ($stmt->rowCount() > 0) {
            // Update existing score
            $stmt = $this->connect()->prepare("UPDATE gamification SET score = ?, date_and_time = NOW() WHERE user_id = ?");
            return $stmt->execute([$newScore, $this->user_id]);
        } else {
            // Insert new score entry
            $stmt = $this->connect()->prepare("INSERT INTO gamification (user_id, score) VALUES (?, ?)");
            return $stmt->execute([$this->user_id, $newScore]);
        }
    }
}
