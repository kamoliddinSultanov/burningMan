<?php

use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../log/login_user.php';

class UserLoginTest extends TestCase
{
    private $mockDbConnection;
    private $userLogin;

    protected function setUp(): void
    {
        // Create a mock for the MySQLi connection
        $this->mockDbConnection = $this->createMock(mysqli::class);

        // Inject the mock connection into the UserLogin class
        $this->userLogin = new UserLogin($this->mockDbConnection);
    }

    public function testLoginUserWithCorrectCredentials()
    {
        // Mock the prepare method
        $mockStatement = $this->createMock(mysqli_stmt::class);
        $mockResult = $this->createMock(mysqli_result::class);

        // Simulate a user record being found in the database
        $this->mockDbConnection->method('prepare')->willReturn($mockStatement);
        $mockStatement->method('bind_param');
        $mockStatement->method('execute');
        $mockStatement->method('get_result')->willReturn($mockResult);

        // Simulate the user record
        $mockResult->method('fetch_assoc')->willReturn([
            'username' => 'testuser',
            'role' => 'user',
            'id' => 77
        ]);

        // Do not call session_start(), avoid it during the test
        $this->mockSessionStart();

        // Test login with correct credentials
        $result = $this->userLogin->loginUser('testuser', 'password123');
        $this->assertEquals('user', $result);  // Should return 'user'
        $this->assertArrayHasKey('username', $_SESSION);  // Check session variable exists
        $this->assertArrayHasKey('role', $_SESSION);  // Check session variable exists
    }

    public function testLoginUserWithIncorrectCredentials()
    {
        // Mock the prepare method
        $mockStatement = $this->createMock(mysqli_stmt::class);
        $mockResult = $this->createMock(mysqli_result::class);

        // Simulate no user found in the database
        $this->mockDbConnection->method('prepare')->willReturn($mockStatement);
        $mockStatement->method('bind_param');
        $mockStatement->method('execute');
        $mockStatement->method('get_result')->willReturn($mockResult);

        // Simulate no rows in the result set
        $mockResult->method('fetch_assoc')->willReturn(null);

        // Test login with incorrect credentials
        $result = $this->userLogin->loginUser('nonexistentuser', 'wrongpassword');
        $this->assertEquals('Invalid username or password', $result);  // Should return error message
    }

    private function mockSessionStart()
    {
        // Avoid triggering session_start() by overriding it in the test environment
        // This will prevent any session-related issues during testing
        if (!isset($_SESSION)) {
            $_SESSION = [];  // Ensure session array exists without actually starting the session
        }
    }
}
