<!-- 
    Author: Kamoliddin Sultanov 
    File purpose: user authoreization  

-->
<?php

require_once 'db.php';

class UserLogin
{
    private $dbConnection;

    // Constructor to allow dependency injection for the DB connection
    public function __construct($dbConnection = null)
    {
        // Use dependency injection if available, otherwise use the default db connection
        $this->dbConnection = $dbConnection ?? (new db())->getDbConnection(); // Default to real DB connection
    }

    // Login user method
    public function loginUser($username, $password)
    {
        // Prepare the query to check username and password
        $query = "SELECT * FROM users WHERE username = ? AND password = ?";
        $stmt = $this->dbConnection->prepare($query);
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
}


?>

