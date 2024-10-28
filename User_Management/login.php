<?php
// login.php
include 'db.php';

session_start(); // Start session management

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve login credentials
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch user data from the database
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verify password
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $username; // Set session variable
            header("Location: home.php"); // Redirect to home page
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <!-- Login form -->
    <form method="POST" action="login.php">
        Username: <input type="text" name="username" required>
        Password: <input type="password" name="password" required>
        <button type="submit">Login</button>
    </form>
</body>
</html>
