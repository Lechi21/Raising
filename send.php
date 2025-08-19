<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include the PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// The paths below assume the PHPMailer files are in the same folder.
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

// Check if the form was submitted using the POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // The email address where you want to receive the form submissions.
    $to = "dakenny21@gmail.com"; 

    // --- Input Sanitization and Validation ---
    $name = filter_var(trim($_POST["name"]), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = filter_var(trim($_POST["subject"]), FILTER_SANITIZE_STRING);
    $identity = filter_var(trim($_POST["identity"]), FILTER_SANITIZE_STRING);
    $message = filter_var(trim($_POST["message"]), FILTER_SANITIZE_STRING);

    if (empty($name) || empty($email) || empty($subject) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400); // Bad Request
        echo "Error: Please complete all required fields with valid information.";
        exit;
    }

    // --- PHPMailer Setup ---
    $mail = new PHPMailer(true);
    $mail->CharSet = "UTF-8";

    try {
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->Host       = 'smtp.gmail.com';
        $mail->Username   = 'dakenny21@gmail.com';
        $mail->Password   = 'wgcf vjyw verz rtsi';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
        // TCP port to connect to.
        $mail->Port       = 587;                                  

        //Recipients
        // Sender's name and email
        $mail->setFrom('dakenny21@gmail.com', 'Raising Young Authors Contact Form');
        $mail->addReplyTo($email, $name);
        $mail->addAddress($to);

        //Content
        $mail->isHTML(true); // Enable HTML
        $mail->Subject = "📩 New Contact Form Message: $subject";

        $email_body = "
        <div style='font-family:Arial, sans-serif; background:#f4f6f9; padding:20px;'>
            <div style='max-width:600px; margin:auto; background:#ffffff; border-radius:10px; box-shadow:0 4px 8px rgba(0,0,0,0.1); padding:20px;'>
                <h2 style='color:#2a9d8f; text-align:center;'>📬 New Contact Form Message</h2>
                <p style='font-size:16px; color:#333;'><strong>Name:</strong> {$name}</p>
                <p style='font-size:16px; color:#333;'><strong>Email:</strong> {$email}</p>
                <p style='font-size:16px; color:#333;'><strong>Subject:</strong> {$subject}</p>
                <p style='font-size:16px; color:#333;'><strong>Identity:</strong> {$identity}</p>
                <hr style='margin:20px 0; border:none; border-top:1px solid #ddd;'>
                <p style='font-size:16px; color:#333;'><strong>Message:</strong></p>
                <p style='font-size:15px; color:#555; background:#f9f9f9; padding:10px; border-left:4px solid #2a9d8f;'>{$message}</p>
                <br>
                <p style='text-align:center; font-size:14px; color:#888;'>— Raising Young Authors Contact Form</p>
            </div>
        </div>";

        $mail->Body = $email_body;

        $mail->send();
        http_response_code(200);
        echo "Success! Your message has been sent. Thank you! ✅";
    } catch (Exception $e) {
        http_response_code(500);
        echo "An error occurred and your message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    // If the script is accessed directly, send a 403 Forbidden status.
    http_response_code(403);
    echo "Access Denied: This page is for form submissions only.";
}
?>