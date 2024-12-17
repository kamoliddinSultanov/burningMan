<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../log/db.php';

class DbTest extends TestCase
{
    private $db;

    protected function setUp(): void
    {
        // Instantiate the db class
        $this->db = new db();
    }

    public function testGetDbConnection()
    {
        // Test the MySQLi connection
        $connection = $this->db->getDbConnection();
        $this->assertInstanceOf(mysqli::class, $connection, 'MySQLi connection failed.');
        $this->assertTrue($connection->ping(), 'Unable to ping MySQLi connection.');
        $connection->close();
    }

    public function testGetPdoConnection()
    {
        // Test the PDO connection
        $pdo = $this->db->getPdoConnection();
        $this->assertInstanceOf(PDO::class, $pdo, 'PDO connection failed.');

        // Test the PDO connection by running a simple query
        $stmt = $pdo->query('SELECT 1');
        $this->assertNotFalse($stmt, 'PDO query failed.');
    }
}
