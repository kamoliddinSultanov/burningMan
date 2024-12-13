<?php
require_once 'db.php';

// Verify that the session is for admin users
function verifyAdminSession() {
    session_start();
    if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
        header("location: index.php");
        exit();
    }
}

// Function to create an event
function createEvent($title, $description, $date, $created_by) {
    $conn = getDbConnection();  // Get the database connection

    $stmt = $conn->prepare("INSERT INTO events (title, description, date, created_by) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('sssi', $title, $description, $date, $created_by);
    return $stmt->execute();
}

// Function to delete an event
function deleteEvent($event_id) {
    $conn = getDbConnection();  // Get the database connection

    // Delete connected records from user_events
    $stmt = $conn->prepare("DELETE FROM user_events WHERE event_id = ?");
    $stmt->bind_param('i', $event_id);
    $stmt->execute();

    // Delete the event itself
    $stmt = $conn->prepare("DELETE FROM events WHERE id = ?");
    $stmt->bind_param('i', $event_id);
    return $stmt->execute();
}

// Function to edit an event
function editEvent($event_id, $title, $description, $date) {
    $conn = getDbConnection();  // Get the database connection
    $stmt = $conn->prepare("UPDATE events SET title = ?, description = ?, date = ? WHERE id = ?");
    $stmt->bind_param('sssi', $title, $description, $date, $event_id);
    return $stmt->execute();
}

// Function to fetch all events
function fetchEvents() {
    $conn = getDbConnection();  // Get the database connection
    $result = $conn->query("SELECT * FROM events");
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Function to fetch user-event data
function fetchUserEventData() {
    $conn = getDbConnection();  // Get the database connection
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
    $result = $conn->query($query);
    return $result->fetch_all(MYSQLI_ASSOC);
}
?>
