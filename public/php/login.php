<?php
session_start();

// Set the fixed username and password
$fixed_username = "admin";
$fixed_password = "admin1234
";

// Get the submitted form data
$username = $_POST['username'];
$password = $_POST['password'];
$remember = isset($_POST['remember']);

// Check if the entered username and password match the fixed values
if ($username === $fixed_username && $password === $fixed_password) {
    // Login successful
    $_SESSION['username'] = $username;

    // Handle "Remember Me" checkbox
    if ($remember) {
        setcookie("username", $username, time() + (86400 * 30), "/"); // Set a 30-day cookie
    }

    echo "Login successful! Welcome, " . htmlspecialchars($username) . ".";
} else {
    // Login failed
    echo "Invalid username or password.";
}
?>

