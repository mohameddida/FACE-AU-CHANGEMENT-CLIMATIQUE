<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';

$email = "mohamed.rahali@esprit.tn";
$token = rand(100000, 999999);

// Function to send email with the provided token using PHPMailer
function sendEmail($to, $subject, $body) {
    try {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'mohamed.rahali@esprit.tn';
        $mail->Password = '13289204 ';
        $mail->Port = 465;
        $mail->SMTPSecure = 'ssl';
        $mail->isHTML(true);
        $mail->setFrom('info@yourwebsite.com', 'Your Website');
        $mail->addAddress($to);
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->send();

        return true; // Email sent successfully
    } catch (Exception $e) {
        return false; // Email sending failed
    }
}
$subject = "Your Resent Email Verification Token";
$body = "Your token is: " . $token;
$result = sendEmail($email, $subject, $body);

// Display the result of the email sending operation
if ($result) {
    echo '<script>alert("The email  was sent successfully!");</script>';
} else {
    echo '<script>alert("There was a problem sending the email.");</script>';
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forget Password</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <form id="resetForm">
            <h2>Reset Password</h2>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <button type="button" onclick="sendVerificationCode()">Send Code</button>
            <label for="code">Verification Code:</label>
            <input type="text" id="code" name="code" required>
            <label for="newPassword">New Password:</label>
            <input type="password" id="newPassword" name="newPassword" required>
            <button type="button" onclick="resetPassword()">Reset Password</button>
        </form>
    </div>

    <script src="script.js"></script>
    <style>

body {
    font-family: Arial, sans-serif;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
    margin: 0;
}

.container {
    width: 300px;
}

form {
    display: flex;
    flex-direction: column;
}

label {
    margin-top: 10px;
}

button {
    margin-top: 10px;
    cursor: pointer;
}

</style>

<script>
function sendVerificationCode() {
    // Simulate sending verification code via email
    const email = document.getElementById('email').value;
    const code = Math.floor(1000 + Math.random() * 9000); // Generate a random 4-digit code
    // In a real scenario, you would send this code to the user's email
    console.log(`Verification code ${code} sent to ${email}`);
}

function resetPassword() {
    const enteredCode = document.getElementById('code').value;
    // In a real scenario, you would compare enteredCode with the code sent to the user
    // For simplicity, let's assume the correct code is 1234
    if (enteredCode === '1234') {
        const newPassword = document.getElementById('newPassword').value;
        console.log(`Password reset successful. New password: ${newPassword}`);
    } else {
        console.log('Invalid verification code');
    }
}


</script>
</body>
</html>
