<?php

use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../log/admin_functions.php';

class AdminFunctionsTest extends TestCase
{
    private $adminFunctions;

    protected function setUp(): void
    {
        // Directly create the AdminFunctions object
        $this->adminFunctions = new AdminFunctions();
    }

    public function testVerifyAdminSession()
    {
        // Simulate a valid admin session
        $_SESSION['username'] = 'adminuser';
        $_SESSION['role'] = 'admin';

        // Verify that the session is valid (no redirect)
        $result = $this->adminFunctions->verifyAdminSession();
        $this->assertNull($result); // No redirect or output if session is valid
    }

    public function testVerifyAdminSessionRedirect()
    {
        // Simulate an invalid admin session
        $_SESSION['username'] = 'nonadminuser';
        $_SESSION['role'] = 'user'; // Role is not admin

        // Capture the output of header() to verify redirection
        ob_start();
        $this->adminFunctions->verifyAdminSession();
        $output = ob_get_clean();

        $this->assertStringContainsString('location: index.php', $output);
    }

    public function testCreateEvent()
    {
        // Directly test the logic, assuming it would work if the database is connected
        $result = $this->adminFunctions->createEvent('Event Title', 'Event Description', '2024-12-25', 1);

        // Since we are not using a database, assume that if no errors are thrown, it should return true
        $this->assertTrue($result);  // You can modify this if the method returns a different type
    }

    public function testDeleteEvent()
    {
        // Directly test the logic, assuming it would work if the database is connected
        $result = $this->adminFunctions->deleteEvent(1);

        // Similar to createEvent, expect it to return true if successful
        $this->assertTrue($result);
    }

    public function testEditEvent()
    {
        // Directly test the logic, assuming it would work if the database is connected
        $result = $this->adminFunctions->editEvent(1, 'Updated Title', 'Updated Description', '2024-12-30');

        // Expecting a true result to indicate success
        $this->assertTrue($result);
    }

    public function testFetchEvents()
    {
        // Directly test the logic, assuming the method would return an array of events
        $events = $this->adminFunctions->fetchEvents();

        // Verify that the result is an array (in real cases, it would come from the DB)
        $this->assertIsArray($events);
    }

    public function testFetchUserEventData()
    {
        // Directly test the logic, assuming the method would return an array of user-event data
        $userEventData = $this->adminFunctions->fetchUserEventData();

        // Verify that the result is an array
        $this->assertIsArray($userEventData);
    }
}
