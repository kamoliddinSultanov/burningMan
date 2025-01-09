<!-- 
    Author: Kamoliddin Sultanov 
    File purpose: registration pannel

-->
<?php
// Include the necessary class files
require_once 'register_user.php';

$message = '';

// Handle the registration process
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    $confirmPassword = htmlspecialchars($_POST['confirm_password']);

    // Create an instance of the UserRegistration class
    $userRegistration = new UserRegistration();
    // Call the registerUser method and get the result message
    $message = $userRegistration->registerUser($username, $password, $confirmPassword);
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
<a href="../main.php">< Back to home ></a>
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
    <p>Already have an account?</p>
    <a href="index.php">Login to system</a>
</div>

<?php if ($message): ?>
    <script>alert('<?php echo $message; ?>');</script>
<?php if ($message === 'Registration successful!'): ?>
    <script>window.location.href = "index.php";</script>
<?php endif; ?>
<?php endif; ?>
</body>
</html>
