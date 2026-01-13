<?php
session_start();
$message = "";
$toastClass = "";
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    $toastClass = $_SESSION['toastClass'];
    unset($_SESSION['message']);
    unset($_SESSION['toastClass']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <link rel="shortcut icon" href="https://cdn-icons-png.flaticon.com/512/295/295128.png">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
    <title>Register</title>
</head>
<body>
    <div class="form-container">
        <div class="form-card">
            <?php if ($message): ?>
                <div class="alert <?php echo ($toastClass === '#28a745') ? 'alert-success' : 'alert-danger'; ?>">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>
            
            <div class="form-icon">
                <i class="fa fa-user-plus"></i>
            </div>
            <h2 class="form-title">Create Account</h2>
            
            <form method="post" action="register.php">
                <div class="form-group">
                    <label for="fullname">
                        <i class="fa fa-user"></i> Full Name
                    </label>
                    <input type="text" name="fullname" id="fullname" class="form-control" required autofocus>
                </div>
                
                <div class="form-group">
                    <label for="username">
                        <i class="fa fa-user"></i> Username
                    </label>
                    <input type="text" name="username" id="username" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="email">
                        <i class="fa fa-envelope"></i> Email
                    </label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="password">
                        <i class="fa fa-lock"></i> Password
                    </label>
                    <input type="password" name="password" id="password" class="form-control" required>
                    <small class="form-text">Must be at least 8 characters with uppercase, lowercase, number, and special character</small>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Create Account</button>
                </div>
                
                <div class="form-link">
                    <p>Already have an account? <a href="login-form.php">Login</a></p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
