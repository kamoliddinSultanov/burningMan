<?php
require_once 'admin_functions.php';

// Instantiate AdminFunctions class
$adminFunctions = new AdminFunctions();

// Verify session
$adminFunctions->verifyAdminSession();

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create_event'])) {
        $title = htmlspecialchars($_POST['title']);
        $description = htmlspecialchars($_POST['description']);
        $date = htmlspecialchars($_POST['date']);
        $created_by = $_SESSION['user_id'];

        if ($adminFunctions->createEvent($title, $description, $date, $created_by)) {
            $message = "Event created successfully!";
        } else {
            $message = "Failed to create event.";
        }
    }

    if (isset($_POST['delete_event'])) {
        $event_id = htmlspecialchars($_POST['event_id']);
        if ($adminFunctions->deleteEvent($event_id)) {
            $message = "Event deleted successfully!";
        } else {
            $message = "Failed to delete event.";
        }
    }

    if (isset($_POST['edit_event'])) {
        $event_id = htmlspecialchars($_POST['event_id']);
        $title = htmlspecialchars($_POST['title']);
        $description = htmlspecialchars($_POST['description']);
        $date = htmlspecialchars($_POST['date']);

        if ($adminFunctions->editEvent($event_id, $title, $description, $date)) {
            $message = "Event updated successfully!";
        } else {
            $message = "Failed to update event.";
        }
    }
}

// Fetch data
$events = $adminFunctions->fetchEvents();
$user_event_data = $adminFunctions->fetchUserEventData();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="../css/admin.css">
    <script>
        function toggleEditForm(eventId) {
            const form = document.getElementById('edit-form-' + eventId);
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        }
    </script>
</head>
<body>
<h1>Welcome, Admin!</h1>
<a href="logout.php">Logout</a>

<?php if ($message): ?>
    <p><?= htmlspecialchars($message); ?></p>
<?php endif; ?>

<h1>Create New Event</h1>
<form method="POST">
    <input type="text" name="title" placeholder="Name" required>
    <textarea name="description" placeholder="Description" required></textarea>
    <input type="datetime-local" name="date" required>
    <button type="submit" name="create_event">Create Event</button>
</form>

<h2>List of Events</h2>
<table>
    <thead>
    <tr>
        <th>Name</th>
        <th>Description</th>
        <th>Date</th>
        <th>Operations</th>
    </tr>
    </thead>
    <tbody>
    <?php if (!empty($events)): ?>
        <?php foreach ($events as $event): ?>
            <tr>
                <td><?= htmlspecialchars($event['title']); ?></td>
                <td><?= htmlspecialchars($event['description']); ?></td>
                <td><?= htmlspecialchars($event['date']); ?></td>
                <td>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="event_id" value="<?= $event['id']; ?>">
                        <button type="submit" name="delete_event">Delete</button>
                    </form>
                    <button onclick="toggleEditForm(<?= $event['id']; ?>)">Edit</button>
                    <form id="edit-form-<?= $event['id']; ?>" class="edit-form" method="POST" style="display:none;">
                        <input type="hidden" name="event_id" value="<?= $event['id']; ?>">
                        <input type="text" name="title" value="<?= htmlspecialchars($event['title']); ?>" required>
                        <textarea name="description" required><?= htmlspecialchars($event['description']); ?></textarea>
                        <input type="datetime-local" name="date" value="<?= date('Y-m-d\TH:i', strtotime($event['date'])); ?>" required>
                        <button type="submit" name="edit_event">Save</button>
                        <button type="button" onclick="toggleEditForm(<?= $event['id']; ?>)">Cancel</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="4">There are no events</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>

<h2>Users Joined to Events</h2>
<table>
    <thead>
    <tr>
        <th>Username</th>
        <th>Event Name</th>
        <th>Date</th>
    </tr>
    </thead>
    <tbody>
    <?php if (!empty($user_event_data)): ?>
        <?php foreach ($user_event_data as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['username']); ?></td>
                <td><?= htmlspecialchars($row['event_title']); ?></td>
                <td><?= htmlspecialchars($row['event_date']); ?></td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="3">No one has joined any events.</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>
</body>
</html>
<!--
    Author: Kamoliddin Sultanov
    File purpose: displays admin panel

-->

