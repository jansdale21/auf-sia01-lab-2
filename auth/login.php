<?php
session_start();
include '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $_SESSION['message'] = "Username and password are required.";
        header("Location: ../pages/login-form.php");
        exit();
    }

    try {
        $stmt = $conn->prepare("SELECT passwd, fullname, email FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($db_password, $fullname, $email);
            $stmt->fetch();

            if (password_verify($password, $db_password)) {
                $_SESSION['message'] = "Login successful";
                $_SESSION['is_logged_in'] = true;
                $_SESSION['username'] = $username;
                $_SESSION['fullname'] = $fullname;
                $_SESSION['email'] = $email;
                $_SESSION['login_time'] = date('Y-m-d H:i:s');
                logEvent("LOGIN_SUCCESS", "User '$username' logged in successfully");
                header("Location: ../pages/welcome.php");
                exit();
            } else {
                $_SESSION['message'] = "Invalid username or password";
                logEvent("LOGIN_FAILED", "Failed login attempt for user '$username' - Invalid password");
            }
        } else {
            $_SESSION['message'] = "Invalid username or password";
            logEvent("LOGIN_FAILED", "Failed login attempt for user '$username' - User not found");
        }

        $stmt->close();
    } catch (Exception $e) {
        $_SESSION['message'] = "An error occurred during login. Please try again.";
        $username = $username ?? 'unknown';
        logEvent("LOGIN_ERROR", "Database error during login for user '$username' - " . $e->getMessage());
    }

    if (isset($conn)) {
        $conn->close();
    }

    header("Location: ../pages/login-form.php");
    exit();
}

header("Location: login-form.php");
exit();
?>
