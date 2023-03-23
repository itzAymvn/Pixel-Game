<?php

require_once "../auth/dbConnect.php";
session_start();

$postedData = json_decode(file_get_contents('php://input'), true);

if (isset($postedData['player_id']) && isset($postedData['color']) && isset($postedData['pixelIndex']) && isset($postedData['placed_at'])) {

    $player_id = $postedData['player_id'];
    $color = $postedData['color'];
    $pixelIndex = $postedData['pixelIndex'];
    $placed_at = $postedData['placed_at'];

    try {
        $query = $conn->prepare("INSERT INTO pixels (player_id, color, pixelIndex, placed_at) VALUES (:player_id, :color, :pixelIndex, :placed_at)");
        $query->bindParam(':player_id', $player_id);
        $query->bindParam(':color', $color);
        $query->bindParam(':pixelIndex', $pixelIndex);
        $query->bindParam(':placed_at', $placed_at);
        $query->execute();

        // Update player's lastPlacedPixel
        $query = $conn->prepare("UPDATE players SET lastPlacedPixel = :lastPlacedPixel WHERE id = :id");
        $query->bindParam(':lastPlacedPixel', $placed_at);
        $query->bindParam(':id', $player_id);
        $query->execute();

        // Update the session
        $_SESSION['player']['lastPlacedPixel'] = $placed_at;




        // Send response
        echo "Pixel placed successfully";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request";
}
