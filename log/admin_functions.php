<?php
require_once 'db.php';

class AdminFunctions
{
    private $dbConnection;

    public function __construct()
    {
        $this->dbConnection = (new DB())->getDbConnection();
    }

    public function verifyAdminSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
            header("location: index.php");
            exit();
        }
    }

    public function createEvent($title, $description, $date, $created_by)
    {
        $stmt = $this->dbConnection->prepare("INSERT INTO events (title, description, date, created_by) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('sssi', $title, $description, $date, $created_by);
        return $stmt->execute();
    }

    public function deleteEvent($event_id)
    {
        $stmt = $this->dbConnection->prepare("DELETE FROM user_events WHERE event_id = ?");
        $stmt->bind_param('i', $event_id);
        $stmt->execute();

        $stmt = $this->dbConnection->prepare("DELETE FROM events WHERE id = ?");
        $stmt->bind_param('i', $event_id);
        return $stmt->execute();
    }

    public function editEvent($event_id, $title, $description, $date)
    {
        $stmt = $this->dbConnection->prepare("UPDATE events SET title = ?, description = ?, date = ? WHERE id = ?");
        $stmt->bind_param('sssi', $title, $description, $date, $event_id);
        return $stmt->execute();
    }

    public function fetchEvents()
    {
        $result = $this->dbConnection->query("SELECT * FROM events");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function fetchUserEventData()
    {
        $query = "
            SELECT 
                users.username, 
                events.title AS event_title, 
                events.date AS event_date 
            FROM 
                user_events
            JOIN 
                users ON user_events.user_id = users.id
            JOIN 
                events ON user_events.event_id = events.id
            ORDER BY 
                events.date ASC
        ";
        $result = $this->dbConnection->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}




// Author: Kamoliddin Sultanov
// File purpose: operations that can perform only admin



