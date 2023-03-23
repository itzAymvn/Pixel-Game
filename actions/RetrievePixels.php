<?php
require_once "../auth/dbConnect.php";

$query = $conn->prepare("SELECT * FROM pixels");
$query->execute();
$allPixels = $query->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($allPixels);
