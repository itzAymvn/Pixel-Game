<?php
require_once "../auth/dbConnect.php";
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Remove whitespaces
    $username = preg_replace('/\s+/', '', $username);
    $password = preg_replace('/\s+/', '', $password);

    // Check if username already exists
    $query = $conn->prepare("SELECT * FROM players WHERE username = :username");
    $query->bindParam(':username', $username);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
    if ($result) {
        header('Location: ../register.php?error=user_exists');
    } else {
        // Insert new user
        $query = $conn->prepare("INSERT INTO players (username, password) VALUES (:username, :password)");
        $query->bindParam(':username', $username);
        $query->bindParam(':password', password_hash($password, PASSWORD_DEFAULT));
        $query->execute();
        header('Location: ../login.php');
    }
}
