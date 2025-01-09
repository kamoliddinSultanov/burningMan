<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'db.php';

class UserLogin
{
    private $dbConnection;


    public function __construct($dbConnection = null)
    {
        $this->dbConnection = $dbConnection ?? (new db())->getDbConnection();
    }


    public function loginUser($username, $password)
    {

        $query = "SELECT * FROM users WHERE username = ?";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {

            if (password_verify($password, $row['password'])) {
                $_SESSION['username'] = $row['username'];
                $_SESSION['role'] = $row['role'];
                $_SESSION['user_id'] = $row['id'];

                return $row['role'] === 'admin' ? 'admin' : 'user';
            }
        }

        return 'Invalid username or password';
    }
}


?>

<!--
    Author: Kamoliddin Sultanov
    File purpose: user authoreization

-->