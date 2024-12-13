<?php
    require_once 'register_user.php';

    $message = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);
        $confirmPassword = htmlspecialchars($_POST['confirm_password']);

        // Call the registration function
        $message = registerUser($username, $password, $confirmPassword);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../css/register.css">
</head>
<body>
    <h2>Register</h2>
    <div class="form">
        <form action="register.php" method="post">
            <label>Username</label>
            <input class="field" type="text" name="username" required><br/>
            <label>Password</label>
            <input class="field" type="password" name="password" required><br/>
            <label>Confirm Password</label>
            <input class="field" type="password" name="confirm_password" required><br/>
            <input class="field" type="submit" name="register" value="Register">
        </form>
    </div>
    <?php if ($message): ?>
        <script>alert('<?php echo $message; ?>');</script>
        <?php if ($message === 'Registration successful!'): ?>
            <script>window.location.href = "index.php";</script>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>
