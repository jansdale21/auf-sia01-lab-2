<?php
session_start();
include 'db.php';

if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
    header("Location: login-form.php");
    exit();
}

$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
unset($_SESSION['message']);
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
    <title>Welcome</title>
</head>
<body>
    <div class="welcome-container">
        <?php if ($message): ?>
            <div class="alert alert-success">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <div class="welcome-card">
            <div class="card-header">
                <h5><i class="fa fa-user"></i> Welcome, <?php echo htmlspecialchars($_SESSION['fullname']); ?>!</h5>
            </div>
            <div class="card-body">
                <div class="info-item">
                    <strong><i class="fa fa-user"></i> Username:</strong>
                    <?php echo htmlspecialchars($_SESSION['username']); ?>
                </div>
                <div class="info-item">
                    <strong><i class="fa fa-envelope"></i> Email:</strong>
                    <?php echo htmlspecialchars($_SESSION['email']); ?>
                </div>
                <div class="info-item">
                    <strong><i class="fa fa-id-card"></i> Full Name:</strong>
                    <?php echo htmlspecialchars($_SESSION['fullname']); ?>
                </div>
                <div class="info-item">
                    <strong><i class="fa fa-clock-o"></i> Login Time:</strong>
                    <?php echo htmlspecialchars($_SESSION['login_time']); ?>
                </div>
                <div class="mt-3">
                    <a href="logout.php" class="btn btn-danger">Logout</a>
                </div>
            </div>
        </div>

        <div class="welcome-card">
            <div class="card-header">
                <h5><i class="fa fa-users"></i> All Registered Users</h5>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th><i class="fa fa-hashtag"></i> ID</th>
                                <th><i class="fa fa-user"></i> Full Name</th>
                                <th><i class="fa fa-user"></i> Username</th>
                                <th><i class="fa fa-envelope"></i> Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            try {
                                $stmt = $conn->prepare("SELECT id, fullname, username, email FROM users ORDER BY id DESC");
                                $stmt->execute();
                                $result = $stmt->get_result();
                                
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['fullname']) . "</td>";
                                        echo "<td><span class='badge bg-primary'>" . htmlspecialchars($row['username']) . "</span></td>";
                                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='4' class='text-center py-4'>No users found</td></tr>";
                                }
                                $stmt->close();
                            } catch (Exception $e) {
                                echo "<tr><td colspan='4' class='text-center py-4 text-danger'>An error occurred while loading users. Please try again later.</td></tr>";
                                logEvent("DATABASE_ERROR", "Database error in welcome.php - " . $e->getMessage());
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php
if (isset($conn)) {
    $conn->close();
}
?>
