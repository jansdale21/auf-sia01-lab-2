<?php
date_default_timezone_set('Asia/Manila');

/**
 * Reusable Logging Function
 * Logs events with standardized format including timestamp, event type, and description
 * 
 * @param string $eventType The type of event (e.g., REGISTRATION_SUCCESS, LOGIN_SUCCESS, LOGIN_FAILED)
 * @param string $message The description of the event
 * @return void
 */
function logEvent($eventType, $message) {
    $timestamp = date('Y-m-d H:i:s');
    error_log("$eventType: $message at $timestamp");
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sia01_lab2";

// Create connection
try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    $conn->report_mode = MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT;
} catch (Exception $e) {
    // Start session if not already started
    if (session_status() !== PHP_SESSION_ACTIVE) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    $_SESSION['message'] = "Database connection failed. Please try again later.";
    $_SESSION['toastClass'] = "#dc3545"; 
    logEvent("DATABASE_CONNECTION_ERROR", "Database connection failed - " . $e->getMessage());
    header("Location: index.php");
    exit();
}

?>
