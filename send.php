<?php

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
        // Set email format to plain text
        $mail->isHTML(false);
        $mail->Subject = $subject;
        
        $email_body = "A new message from Raising Young Authors contact form.\n\n";
        $email_body .= "Name: {$name}\n";
        $email_body .= "Email: {$email}\n";
        $email_body .= "Subject: {$subject}\n";
        $email_body .= "Identity: {$identity}\n";
        $email_body .= "Message:\n{$message}\n";

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