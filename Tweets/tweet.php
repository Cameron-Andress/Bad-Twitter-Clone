<?php
// tweet.php
include 'db.php';

session_start(); // Start session management

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_SESSION['username']; // Get the logged-in username
    $content = $_POST['content']; // Get tweet content
    $image = "";

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = 'uploads/' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image);
    }

    // Get the logged-in user's ID
    $user_id = $conn->query("SELECT id FROM users WHERE username='$username'")->fetch_assoc()['id'];

    // Insert new tweet into the database
    $sql = "INSERT INTO tweets (user_id, content, image) VALUES ('$user_id', '$content', '$image')";

    if ($conn->query($sql) === TRUE) {
        echo "Tweet created successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>New Tweet</title>
</head>
<body>
    <h1>Create a New Tweet</h1>
    <!-- New tweet form -->
    <form method="POST" action="tweet.php" enctype="multipart/form-data">
        Content: <textarea name="content" required></textarea>
        Image: <input type="file" name="image">
        <button type="submit">Tweet</button>
    </form>
</body>
</html>
