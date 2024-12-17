<!-- 
    Author: Kamoliddin Sultanov 
    File purpose: user registration  

-->

<?php

require_once 'db.php';  // Include the db class

class UserRegistration
{
    private $dbConnection;

    // Constructor to allow dependency injection for the DB connection
    public function __construct($dbConnection = null)
    {
        // Use dependency injection if available, otherwise use the default db connection
        $this->dbConnection = $dbConnection ?? (new db())->getDbConnection(); // Default to real DB connection
    }

    // Check if username already exists
    private function usernameExists($username)
    {
        $query = "SELECT * FROM users WHERE username = ?";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0; // Return true if username exists
    }

    // Register user method
    public function registerUser($username, $password, $confirmPassword)
    {
        // Check if passwords match
        if ($password !== $confirmPassword) {
            return 'Passwords do not match!';
        }

        // Check if the username already exists
        if ($this->usernameExists($username)) {
            return 'Username already exists!';
        }

        // Prepare the query to insert the user
        $query = "INSERT INTO users (username, password, role) VALUES (?, ?, 'user')";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bind_param("ss", $username, $password);

        if ($stmt->execute()) {
            return 'Registration successful!';
        } else {
            return 'Error during registration!';
        }
    }
}

?>