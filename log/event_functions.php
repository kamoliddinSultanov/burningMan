<?php
require_once 'db.php';

class EventFunctions {
    private $pdo;

    public function __construct() {
        $db = new db();
        $this->pdo = $db->getPdoConnection();
    }

    public function joinEvent($user_id, $event_id) {
        $stmt = $this->pdo->prepare("INSERT INTO user_events (user_id, event_id) VALUES (?, ?)");
        return $stmt->execute([$user_id, $event_id]);
    }

    public function leaveEvent($user_id, $event_id) {
        $stmt = $this->pdo->prepare("DELETE FROM user_events WHERE user_id = ? AND event_id = ?");
        return $stmt->execute([$user_id, $event_id]);
    }

    public function getUserEvents($user_id) {
        $stmt = $this->pdo->prepare("
            SELECT e.id, e.title, e.description, e.date 
            FROM events e 
            JOIN user_events ue ON e.id = ue.event_id 
            WHERE ue.user_id = ?
        ");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAvailableEvents($user_id) {
        $stmt = $this->pdo->prepare("
            SELECT e.id, e.title, e.description, e.date 
            FROM events e 
            WHERE e.id NOT IN (SELECT event_id FROM user_events WHERE user_id = ?)
        ");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function verifyUserSession() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['username']) || !isset($_SESSION['user_id'])) {
            header("Location: login.php");
            exit();
        }
    }
}

// Author: Kamoliddin Sultanov
// File purpose: operations with events


