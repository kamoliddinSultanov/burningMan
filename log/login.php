<?php
    require_once 'event_functions.php';

    // Verify session
    verifyUserSession();

    // Get user ID
    $user_id = $_SESSION['user_id'];

    // Handle join or leave event actions
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $event_id = $_POST['event_id'] ?? null;

        if (isset($_POST['join_event']) && $event_id) {
            $result = joinEvent($user_id, $event_id);
        } elseif (isset($_POST['leave_event']) && $event_id) {
            $result = leaveEvent($user_id, $event_id);
        }
    }

    // Fetch events data
    $user_events = getUserEvents($user_id);
    $all_events = getAvailableEvents($user_id);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events</title>
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
    <h2>Welcome, <?= htmlspecialchars($_SESSION['username']); ?></h2>
    <a href="logout.php">Logout</a>

    <h1>Events You Have Joined</h1>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Date</th>
                <th>Operation</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($user_events)): ?>
                <?php foreach ($user_events as $event): ?>
                    <tr>
                        <td><?= htmlspecialchars($event['title']); ?></td>
                        <td><?= htmlspecialchars($event['description']); ?></td>
                        <td><?= htmlspecialchars($event['date']); ?></td>
                        <td>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="event_id" value="<?= $event['id']; ?>">
                                <button type="submit" name="leave_event">Withdraw</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">You have not joined any events.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <h2>Available Events</h2>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Date</th>
                <th>Operation</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($all_events)): ?>
                <?php foreach ($all_events as $event): ?>
                    <tr>
                        <td><?= htmlspecialchars($event['title']); ?></td>
                        <td><?= htmlspecialchars($event['description']); ?></td>
                        <td><?= htmlspecialchars($event['date']); ?></td>
                        <td>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="event_id" value="<?= $event['id']; ?>">
                                <button type="submit" name="join_event">Join</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No events available to join.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
