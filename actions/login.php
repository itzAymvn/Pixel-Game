<?php
session_start();
require_once "../auth/dbConnect.php";
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Remove whitespaces

    $username = preg_replace('/\s+/', '', $username);
    $password = preg_replace('/\s+/', '', $password);

    // Check if username doesn't exist
    $query = $conn->prepare("SELECT * FROM players WHERE username = :username");
    $query->bindParam(':username', $username);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
    if (!$result) {
        header('Location: ../login.php?error=user_not_exists');
    } else {
        // Check if password is correct
        if (password_verify($password, $result['password'])) {
            // Start session
            $_SESSION['player'] = $result;
            header('Location: ../index.php');
        } else {
            header('Location: ../login.php?error=wrong_password');
        }
    }
}
