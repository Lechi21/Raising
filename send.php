<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mail = new PHPMailer(true);

    $name     = htmlspecialchars($_POST["name"]);
    $email    = htmlspecialchars($_POST["email"]);
    $subject  = htmlspecialchars($_POST["subject"]);
    $identity = htmlspecialchars($_POST["identity"]);
    $message  = htmlspecialchars($_POST["message"]);

    $body = "You have received a new message:\n\n" .
            "Name: $name\n" .
            "Email: $email\n" .
            "Subject: $subject\n" .
            "Identity: $identity\n\n" .
            "Message:\n$message";

    try {
        // SMTP Configuration (Gmail)
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'dakenny@gmail.com';  
        $mail->Password   = 'ypeq doqx slol uaam';  
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Email content
        $mail->setFrom($email, $name);
        $mail->addAddress('dakenny21@gmail.com');          // Admin inbox
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
        echo "Message sent successfully!";
    } catch (Exception $e) {
        echo "Failed to send message. Error: " . $mail->ErrorInfo;
    }
}
?>
