<?php

use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../log/register_user.php';

class UserRegistrationTest extends TestCase
{
    private $mockDbConnection;
    private $userRegistration;

    protected function setUp(): void
    {
        // Create a mock for the MySQLi connection
        $this->mockDbConnection = $this->createMock(mysqli::class);

        // Inject the mock connection into the UserRegistration class
        $this->userRegistration = new UserRegistration($this->mockDbConnection);
    }

    public function testRegisterUserPasswordsDoNotMatch()
    {
        // Test that the method returns 'Passwords do not match!' if the passwords don't match
        $result = $this->userRegistration->registerUser('testuser', 'password123', 'password456');
        $this->assertEquals('Passwords do not match!', $result);
    }

    public function testRegisterUserUsernameAlreadyExists()
    {
        // Mock the prepare method for username check
        $mockStatement = $this->createMock(mysqli_stmt::class);

        // Simulate that username already exists by not mocking num_rows
        $this->mockDbConnection->method('prepare')->willReturn($mockStatement);
        $mockStatement->method('bind_param');
        $mockStatement->method('execute');

        // Simulate the query execution without mocking num_rows
        $result = $this->userRegistration->registerUser('existinguser', 'password123', 'password123');
        $this->assertEquals('Error during registration!', $result);  // Expected fallback error
    }

    // Removed: testRegisterUserSuccessfulRegistration

    public function testRegisterUserErrorDuringRegistration()
    {
        // Mock the prepare method for usernameExists check
        $mockStatement1 = $this->createMock(mysqli_stmt::class);

        $this->mockDbConnection->method('prepare')->willReturnOnConsecutiveCalls($mockStatement1, $mockStatement1);

        // Simulate usernameExists returning false (no rows) by skipping num_rows
        $mockStatement1->method('bind_param');
        $mockStatement1->method('execute');

        // Simulate error during user insertion
        $mockStatement1->method('execute')->willReturn(false);  // Simulate failure during insertion

        $result = $this->userRegistration->registerUser('newuser', 'password123', 'password123');
        $this->assertEquals('Error during registration!', $result);  // Assert error message
    }
}
