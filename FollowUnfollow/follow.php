<?php
// follow.php
// Include database configuration
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
    $follow_username = $_POST['follow_username']; // Get the username to follow

    // Get the IDs of the logged-in user and the user to follow
    $user_id = $conn->query("SELECT id FROM users WHERE username='$username'")->fetch_assoc()['id'];
    $follow_id = $conn->query("SELECT id FROM users WHERE username='$follow_username'")->fetch_assoc()['id'];

    // Insert follow relationship into the database
    $sql = "INSERT INTO follows (follower_id, followed_id) VALUES ('$user_id', '$follow_id')";

   
$query = "SELECT id FROM users WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

// Checking if username exists
$query = "SELECT id FROM users WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // After successfully following a user
header("Location: home.php");
exit();

} else {
    // Redirect to error page if the username does not exist
    header("Location: error.php");
    exit();
}


}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Follow User</title>
</head>
<body>
    <h1>Follow a User</h1>
    <!-- Follow user form -->
    <form method="POST" action="follow.php">
        Username to follow: <input type="text" name="follow_username" required>
        <button type="submit">Follow</button>
    </form>
</body>
</html>
