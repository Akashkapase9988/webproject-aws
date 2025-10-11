<?php
include 'config.php';

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    
    if (empty($username) || empty($email) || empty($password)) {
        $error = "Please fill all fields.";
    } elseif ($password != $confirm_password) {
        $error = "Passwords do not match.";
    } elseif (strlen($password) < 6) {
        $error = "Password must have at least 6 characters.";
    } else {
        $sql = "SELECT id FROM users WHERE username = :username OR email = :email";
        
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":username", $username, PDO::PARAM_STR);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            
            if ($stmt->execute()) {
                if ($stmt->rowCount() > 0) {
                    $error = "Username or email already exists.";
                } else {
                    $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
                    
                    if ($stmt = $pdo->prepare($sql)) {
                        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                        $stmt->bindParam(":username", $username, PDO::PARAM_STR);
                        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
                        $stmt->bindParam(":password", $hashed_password, PDO::PARAM_STR);
                        
                        if ($stmt->execute()) {
                            $success = "Registration successful. You can now <a href='login.php'>login</a>.";
                        } else {
                            $error = "Something went wrong. Please try again.";
                        }
                    }
                }
            }
            unset($stmt);
        }
    }
    unset($pdo);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Word Population System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="login-form">
            <h2>Register New Account</h2>
            <?php if (!empty($error)): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>
            <?php if (!empty($success)): ?>
                <div class="success"><?php echo $success; ?></div>
            <?php endif; ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" name="confirm_password" required>
                </div>
                <div class="form-group">
                    <button type="submit">Register</button>
                </div>
            </form>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </div>
    </div>
</body>
</html>