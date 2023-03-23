<?php
session_start();
if (isset($_SESSION['player'])) {
    session_destroy();
    header('Location: ./login.php');
}
