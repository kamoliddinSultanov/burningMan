<!-- 
    Author: Kamoliddin Sultanov 
    File purpose: database connection

-->


<?php
    function getDbConnection() {
        $conn = mysqli_connect('localhost', 'root', '', 'burningman_db');
        if (!$conn) {
            die('Unable to connect to the database');
        }
        return $conn;
    }

    // Function to get PDO connection
    function getPdoConnection() {
        $host = 'localhost';
        $db = 'burningman_db';
        $user = 'root';
        $pass = '';

        try {
            $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die("Error connection: " . $e->getMessage());
        }
    }
?>