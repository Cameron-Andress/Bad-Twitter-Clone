<?php
session_start();
require_once '../Database_Configuration/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tweet_id'])) {
    $tweet_id = $_POST['tweet_id'];

    // Update the likes count
    $query = "UPDATE tweets SET likes = likes + 1 WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $tweet_id);
    if ($stmt->execute()) {
        // Redirect back to home page
        header("Location: home.php");
        exit();
    } else {
        echo "Error updating likes.";
    }
} else {
    echo "Invalid request.";
}

