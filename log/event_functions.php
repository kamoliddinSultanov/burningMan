<!-- 
    Author: Kamoliddin Sultanov 
    File purpose: operations with events

-->
<?php
require_once 'db.php';

// Verify if the user is logged in
function verifyUserSession() {
    session_start();
    if (!isset($_SESSION['username'])) {
        header("Location: login.php");
        exit;
    }
}

// Join an event
function joinEvent($user_id, $event_id) {
    $pdo = getPdoConnection();
    $stmt = $pdo->prepare("INSERT INTO user_events (user_id, event_id) VALUES (?, ?)");
    return $stmt->execute([$user_id, $event_id]);
}

// Leave an event
function leaveEvent($user_id, $event_id) {
    $pdo = getPdoConnection();
    $stmt = $pdo->prepare("DELETE FROM user_events WHERE user_id = ? AND event_id = ?");
    return $stmt->execute([$user_id, $event_id]);
}

// Get events the user has joined
function getUserEvents($user_id) {
    $pdo = getPdoConnection();
    $stmt = $pdo->prepare("
        SELECT events.* 
        FROM events 
        JOIN user_events ON events.id = user_events.event_id 
        WHERE user_events.user_id = ?
    ");
    $stmt->execute([$user_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Get events the user has not joined
function getAvailableEvents($user_id) {
    $pdo = getPdoConnection();
    $stmt = $pdo->prepare("
        SELECT * 
        FROM events 
        WHERE id NOT IN (SELECT event_id FROM user_events WHERE user_id = ?)
    ");
    $stmt->execute([$user_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
