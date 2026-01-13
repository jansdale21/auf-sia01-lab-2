<?php
session_start();
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
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="../assets/js/script.js"></script>
    <title>Login</title>
</head>
<body>
    <div class="form-container">
        <div class="form-card">
            <div class="form-icon">
                <i class="fa fa-user-circle-o"></i>
            </div>
            <h2 class="form-title">Login</h2>
            
            <?php
            if (isset($_SESSION['message'])) {
                $alertClass = 'alert-info';
                if (strpos($_SESSION['message'], 'success') !== false) {
                    $alertClass = 'alert-success';
                } elseif (strpos($_SESSION['message'], 'Invalid') !== false || strpos($_SESSION['message'], 'error') !== false) {
                    $alertClass = 'alert-danger';
                }
                echo '<div class="alert ' . $alertClass . '">' . htmlspecialchars($_SESSION['message']) . '</div>';
                unset($_SESSION['message']);
            }
            ?>
            
            <form action="../auth/login.php" method="post">
                <div class="form-group">
                    <label for="username">
                        <i class="fa fa-user"></i> Username
                    </label>
                    <input type="text" name="username" id="username" class="form-control" required autofocus>
                </div>
                
                <div class="form-group">
                    <label for="password">
                        <i class="fa fa-lock"></i> Password
                    </label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Login</button>
                </div>
                
                <div class="form-link">
                    <p>Don't have an account? <a href="registration-form.php">Sign up</a></p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
