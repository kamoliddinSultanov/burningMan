<!--
    Author: Kamolidin Sultanov
    Purpose: Connction to database

-->

<?php
class db
{

    public function getDbConnection()
    {
        $host = getenv('DB_HOST') ?: 'localhost';
        $user = getenv('DB_USER') ?: 'root';
        $pass = getenv('DB_PASSWORD') ?: '';
        $dbname = getenv('DB_NAME') ?: 'burningman_db';

        $conn = mysqli_connect($host, $user, $pass, $dbname);
        if (!$conn) {
            die('Unable to connect to the database: ' . mysqli_connect_error());
        }
        return $conn;
    }


    public function getPdoConnection()
    {
        $host = getenv('DB_HOST') ?: 'localhost';
        $db = getenv('DB_NAME') ?: 'burningman_db';
        $user = getenv('DB_USER') ?: 'root';
        $pass = getenv('DB_PASSWORD') ?: '';

        try {
            $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die("Error connecting to the database: " . $e->getMessage());
        }
    }
}
?>
