<!-- 
    Author: Kamoliddin Sultanov 
    File purpose: user registration  

-->
<?php
    require_once 'db.php';

    function registerUser($username, $password, $confirmPassword) {
        $conn = getDbConnection();

        // Check if passwords match
        if ($password !== $confirmPassword) {
            return 'Passwords do not match!';
        }

        // Check if username already exists
        $query = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return 'Username already exists!';
        }

        // Insert new user into the database without hashing password
        $query = "INSERT INTO users (username, password, role) VALUES (?, ?, 'user')";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $username, $password);

        if ($stmt->execute()) {
            return 'Registration successful!';
        } else {
            return 'Error during registration!';
        }
    }
?>
