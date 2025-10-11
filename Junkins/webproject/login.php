<?php
include 'config.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    if (!empty($username) && !empty($password)) {
        $sql = "SELECT id, username, password FROM users WHERE username = :username";
        
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":username", $username, PDO::PARAM_STR);
            
            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    $user = $stmt->fetch();
                    if (password_verify($password, $user['password'])) {
                        session_start();
                        $_SESSION["loggedin"] = true;
                        $_SESSION["id"] = $user['id'];
                        $_SESSION["username"] = $user['username'];
                        header("location: dashboard.php");
                        exit;
                    } else {
                        $error = "Invalid password.";
                    }
                } else {
                    $error = "No account found with that username.";
                }
            } else {
                $error = "Oops! Something went wrong. Please try again later.";
            }
            unset($stmt);
        }
    } else {
        $error = "Please enter username and password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Word Population System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="login-form">
            <h2>Login to Word Population System</h2>
            <?php if (!empty($error)): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>
                <div class="form-group">
                    <button type="submit">Login</button>
                </div>
            </form>
            <p>Don't have an account? <a href="register.php">Register here</a>.</p>
        </div>
    </div>
</body>
</html>