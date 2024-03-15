<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'C:\xampp\htdocs\ebulletin\libraries\PHPMailer-master\src\Exception.php';
require 'C:\xampp\htdocs\ebulletin\libraries\PHPMailer-master\src\PHPMailer.php';
require 'C:\xampp\htdocs\ebulletin\libraries\PHPMailer-master\src\SMTP.php';


// Sender's email address
$sender_email = 'ninjgalla1@gmail.com'; // Change this to your Gmail address

// Receiver's email address
$receiver_email = $_POST['email']; // Assuming you're getting the receiver's email from a form

// Generate a unique token
$token = bin2hex(random_bytes(20));

// Send password reset email using PHPMailer
$mail = new PHPMailer(true); // Passing `true` enables exceptions

try {
    // Server settings
    $mail->isSMTP(); // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com'; // Specify main and backup SMTP servers
    $mail->SMTPAuth = true; // Enable SMTP authentication
    $mail->Username = 'ninjgalla1@gmail.com'; // Your Gmail username
    $mail->Password = 'JANiNEjr.galla'; // Your Gmail password
    $mail->SMTPSecure = 'tls'; // Enable TLS encryption; `ssl` also accepted
    $mail->Port = 587; // TCP port to connect to

    // Recipients
    $mail->setFrom($sender_email);
    $mail->addAddress($receiver_email);

    // Content
    $mail->isHTML(true); // Set email format to HTML
    $mail->Subject = 'Password Reset Request';
    $mail->Body = '
        <p>You are receiving this email because a password reset request was made for your account.</p>
        <p>To reset your password, click the following link:</p>
        <a href="http://localhost:3000/reset-password/' . $token . '">Reset Password</a>
        <p>If you did not request this, please ignore this email.</p>
    ';

    $mail->send();
    echo 'Password reset email sent';
} catch (Exception $e) {
    echo 'Error sending password reset email: ' . $mail->ErrorInfo;
}
?>
