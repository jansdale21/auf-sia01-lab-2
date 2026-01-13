<?php
session_start();

if (isset($_SESSION['username'])) {
    include 'db.php';
    logEvent("LOGOUT_SUCCESS", "User '" . $_SESSION['username'] . "' logged out successfully");
}

session_unset();
session_destroy();

session_start();
$_SESSION['message'] = "Logout successful. You have been logged out.";
header("Location: login-form.php");
exit();
?>