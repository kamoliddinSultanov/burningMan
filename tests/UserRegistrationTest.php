<?php

use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../log/register_user.php';

class UserRegistrationTest extends TestCase
{
    public function testRegisterUserPasswordsDoNotMatch()
    {
        // Создаем mock для MySQLi подключения
        $mockDbConnection = $this->createMock(mysqli::class);

        // Настройка mock для методов
        $mockStatement = $this->createMock(mysqli_stmt::class);
        $mockDbConnection->method('prepare')->willReturn($mockStatement);
        $mockStatement->method('bind_param');
        $mockStatement->method('execute');
        $mockStatement->method('get_result')->willReturn(false); // Возвращаем false для отсутствия результата

        // Внедряем mock соединение в класс UserRegistration
        $userRegistration = new UserRegistration($mockDbConnection);

        // Проверяем, что метод возвращает 'Passwords do not match!' при несовпадении паролей
        $result = $userRegistration->registerUser('testuser', 'password123', 'password456');
        $this->assertEquals('Passwords do not match!', $result);
    }
}
