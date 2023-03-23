<?php
session_start();
if (isset($_SESSION['player'])) {
    header('Location: ./index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="src/auth-forms.css">
    <title>Login</title>
</head>

<body>
    <div class="auth-forms">
        <h1>Login</h1>
        <form action="actions/login.php" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" name="login" value="Login">
            <a href="register.php">Register</a>
        </form>
        <?php
        if (isset($_GET['error'])) {
            if ($_GET['error'] == 'user_not_exists') {
                echo '<p class="error">User not found</p>';
            } else if ($_GET['error'] == 'wrong_password') {
                echo '<p class="error">Wrong password</p>';
            }
        }
        ?>
    </div>
</body>

</html>