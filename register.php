<?php
session_start();
include 'db.php';

function isStrongPassword($password) {
    if (strlen($password) < 8) return false;
    if (!preg_match('/[A-Z]/', $password)) return false;
    if (!preg_match('/[a-z]/', $password)) return false;
    if (!preg_match('/[0-9]/', $password)) return false;
    if (!preg_match('/[^A-Za-z0-9]/', $password)) return false;
    return true;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST['fullname'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($fullname) || empty($username) || empty($email) || empty($password)) {
        $_SESSION['message'] = "All fields are required.";
        $_SESSION['toastClass'] = "#dc3545";
        header("Location: registration-form.php");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['message'] = "Invalid email format.";
        $_SESSION['toastClass'] = "#dc3545";
        header("Location: registration-form.php");
        exit();
    }

    if (!isStrongPassword($password)) {
        $_SESSION['message'] = "Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character.";
        $_SESSION['toastClass'] = "#dc3545";
        header("Location: registration-form.php");
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        $checkStmt = $conn->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
        $checkStmt->bind_param("ss", $email, $username);
        $checkStmt->execute();
        $checkStmt->store_result();

        if ($checkStmt->num_rows > 0) {
            $_SESSION['message'] = "Username or Email already exists";
            $_SESSION['toastClass'] = "#dc3545";
            $checkStmt->close();
            $conn->close();
            header("Location: registration-form.php");
            exit();
        }
        $checkStmt->close();

        $stmt = $conn->prepare("INSERT INTO users (fullname, username, email, passwd) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $fullname, $username, $email, $hashedPassword);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Account created successfully";
            $_SESSION['toastClass'] = "#28a745";
            logEvent("REGISTRATION_SUCCESS", "User '$username' registered successfully");
            $stmt->close();
            $conn->close();
            header("Location: registration-form.php");
            exit();
        } else {
            $_SESSION['message'] = "Error: " . $stmt->error;
            $_SESSION['toastClass'] = "#dc3545";
            $stmt->close();
            $conn->close();
            header("Location: registration-form.php");
            exit();
        }
    } catch (Exception $e) {
        $_SESSION['message'] = "An error occurred during registration. Please try again.";
        $_SESSION['toastClass'] = "#dc3545"; // Danger color
        logEvent("REGISTRATION_ERROR", "Database error during registration for user '$username' - " . $e->getMessage());
        if (isset($conn)) {
            $conn->close();
        }
        header("Location: registration-form.php");
        exit();
    }
} else {
    header("Location: registration-form.php");
    exit();
}
?>

