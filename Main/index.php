<?php
// Start the session
session_start();

// Check if the user is logged in, if not redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

// If the user is logged in, redirect to home.php
header("location: home.php");
exit;
