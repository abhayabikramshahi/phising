<?php
session_start();
include 'db.php'; // Ensure db.php contains the PDO database connection

$error = "";

// Process login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    try {
        // Retrieve user from the database using PDO
        $sql = "SELECT * FROM users WHERE username = :username";
        $stmt = $pdo->prepare($sql); // Use $pdo here
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        
        // Check if the user exists
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            // Verify password
            if (password_verify($password, $row['password'])) {
                $_SESSION['logged_in'] = 1;
                $_SESSION['username'] = $username;
                header("Location: index.php");
                exit();
            } else {
                $error = "Invalid credentials.";
            }
        } else {
            $error = "User not found.";
        }
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Np0m Official</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <div class="login-container">
        <h2>Login to Np0m</h2>
        <?php if ($error): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <div class="input-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
