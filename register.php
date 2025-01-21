<?php
session_start();
include 'db.php'; // Ensure db.php contains the PDO database connection

$error = "";
$success = "";

// Process registration form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Basic validation
    if (empty($username) || empty($password) || empty($confirm_password)) {
        $error = "All fields are required.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        try {
            // Check if username already exists
            $sql = "SELECT id FROM users WHERE username = :username";
            $stmt = $pdo->prepare($sql);  // Use $pdo instead of $conn
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $error = "Username already taken.";
            } else {
                // Hash the password before storing
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);

                // Insert new user into the database
                $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
                $stmt = $pdo->prepare($sql);  // Use $pdo here as well
                $stmt->bindParam(':username', $username, PDO::PARAM_STR);
                $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);

                if ($stmt->execute()) {
                    $success = "Registration successful! <a href='login.php'>Login here</a>";
                } else {
                    $error = "Something went wrong. Please try again.";
                }
            }
        } catch (PDOException $e) {
            $error = "Database error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Np0m Official</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <div class="register-container">
        <h2>Register for Np0m</h2>

        <?php if (!empty($error)): ?>
            <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <p style="color: green;"><?php echo htmlspecialchars($success); ?></p>
        <?php endif; ?>

        <form action="register.php" method="POST">
            <div class="input-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="input-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit">Register</button>
        </form>

        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>
