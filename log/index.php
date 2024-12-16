<!-- 
    Author: Kamoliddin Sultanov 
    File purpose: login in to system

-->
<?php
require_once 'login_user.php';

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    // Call the login function
    $result = loginUser($username, $password);

    if ($result === 'admin') {
        header("Location: admin.php");
        exit();
    } elseif ($result === 'user') {
        header("Location: login.php");
        exit();
    } else {
        $message = $result;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/index.css">
</head>
<body>
    <a href="../main.php">Back to home</a>
    <h2>Login</h2>
    <div>
        <form action="index.php" method="post">
            <label>Username</label>
            <input class="field" type="text" name="username" required><br/>
            <label>Password</label>
            <input class="field" type="password" name="password" required><br/>
            <input class="field" type="submit" name="login" value="Login"> 
        </form>
        <p>Don't have an account?</p>
        <a href="register.php">Sign up</a>
    </div>
    <?php if ($message): ?>
        <script>alert('<?php echo $message; ?>');</script>
    <?php endif; ?>
</body>
</html>
