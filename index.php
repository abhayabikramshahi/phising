<?php
// Start session
session_start();

// Check if user is logged in (assuming $_SESSION['logged_in'] is used for tracking login status)
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != 1) {
    header("Location: login.php");
    exit(); // Ensure the script stops after redirection
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Np0m Official</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <div class="navbar">
        <div class="logo">
            <a href="#"><img src="favicon/logo.png" alt="Np0m"></a>
        </div>
        <div class="navitems">
            <ul>
                <li><a href="#">Languages</a></li>
                <li><a href="#">Login</a></li>
                <li><a href="#">Register</a></li>
            </ul>

            <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == 1): ?>
                <div class="loggedin">
                    <a href="#">Welcome, User!</a>
                    <a href="logout.php">Logout</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
