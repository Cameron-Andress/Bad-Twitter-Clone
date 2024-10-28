<?php
// home.php
include 'db.php';

session_start(); // Start session management

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username']; // Get the logged-in username

// Fetch tweets from followed users
$query = "SELECT tweets.id, tweets.content, tweets.image, tweets.likes, users.username FROM tweets 
          JOIN users ON tweets.user_id = users.id 
          WHERE tweets.user_id IN (SELECT followed_id FROM follows WHERE follower_id = ?) 
          ORDER BY tweets.created_at DESC";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    echo "<div class='tweet'>";
    echo "<p>{$row['username']}: {$row['content']}</p>";
    if ($row['image']) {
        echo "<img src='uploads/{$row['image']}' alt='Tweet Image'>";
    }
    echo "<p>Likes: {$row['likes']}</p>";
    echo "<form method='post' action='like.php'>
            <input type='hidden' name='tweet_id' value='{$row['id']}'>
            <button type='submit'>Like</button>
          </form>";
    echo "</div>";
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
</head>
<body>
    <h1>Welcome, <?php echo $username; ?></h1>
    <a href="logout.php">Logout</a>
    <h2>Newest Tweets</h2>
    <?php
    // Display tweets
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<p>" . $row['username'] . ": " . $row['content'];
            if ($row['image']) {
                echo "<br><img src='" . $row['image'] . "' alt='Tweet Image'>";
            }
            echo "<br>Likes: " . $row['likes'] . "</p>";
        }
    } else {
        echo "No tweets to show.";
    }
    ?>
</body>
</html>
