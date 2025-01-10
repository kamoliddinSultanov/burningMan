<?php

use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../log/register_user.php';

class UserRegistrationTest extends TestCase
{
    public function testRegisterUserPasswordsDoNotMatch()
    {
        $mockDbConnection = $this->createMock(mysqli::class);

        $mockStatement = $this->createMock(mysqli_stmt::class);
        $mockDbConnection->method('prepare')->willReturn($mockStatement);
        $mockStatement->method('bind_param');
        $mockStatement->method('execute');
        $mockStatement->method('get_result')->willReturn(false); // Возвращаем false для отсутствия результата

        $userRegistration = new UserRegistration($mockDbConnection);

        $result = $userRegistration->registerUser('testuser', 'password123', 'password456');
        $this->assertEquals('Passwords do not match!', $result);
    }
}
