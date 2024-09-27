<?php
session_start();

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Clear the cookies
if (isset($_COOKIE['email'])) {
    setcookie('email', '', time() - 3600, "/"); // Expire the email cookie
}
if (isset($_COOKIE['password'])) {
    setcookie('password', '', time() - 3600, "/"); // Expire the password cookie
}

// Redirect to login page
header("Location: login.php");
exit();
?>
