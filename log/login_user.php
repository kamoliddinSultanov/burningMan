<!-- 
    Author: Kamoliddin Sultanov 
    File purpose: user authoreization  

-->
<?php
require_once 'db.php';

function loginUser($username, $password) {
    $conn = getDbConnection();

    // Check if the username and password match
    $query = "SELECT * FROM users WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        // Start a session and set user details
        session_start();
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];
        $_SESSION['user_id'] = $row['id'];

        return $row['role'] === 'admin' ? 'admin' : 'user';
    }

    return 'Invalid username or password';
}
?>
