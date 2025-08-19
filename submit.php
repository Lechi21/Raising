<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Smalot\PdfParser\Parser;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

// Database connection
$host = "localhost";
$user = "qvecmzzj_authors"; 
$pass = "Rock2025";
$dbname = "qvecmzzj_authors_db"; 

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Collect form data
$fullName = $_POST['fullName'];
$email    = $_POST['email'];
$age      = $_POST['age'];
$title    = $_POST['title'];
$workType = $_POST['workType'];
$message  = $_POST['message'] ?? '';

// Handle uploads
$uploadDir = "uploads/";
if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

$photoPath = null;
$filePath  = null;
$pdfText   = null;

if (!empty($_FILES['userPhoto']['name'])) {
    $photoPath = $uploadDir . time() . "_" . basename($_FILES['userPhoto']['name']);
    move_uploaded_file($_FILES['userPhoto']['tmp_name'], $photoPath);
}

if (!empty($_FILES['userFile']['name'])) {
    $filePath = $uploadDir . time() . "_" . basename($_FILES['userFile']['name']);
    move_uploaded_file($_FILES['userFile']['tmp_name'], $filePath);

    // If it's a PDF, extract text
    $fileType = pathinfo($filePath, PATHINFO_EXTENSION);
    if (strtolower($fileType) === "pdf") {
        require __DIR__ . '/../bin/vendor/autoload.php';
        $parser  = new Parser();
        $pdf     = $parser->parseFile($filePath);
        $pdfText = $pdf->getText();

        if (trim($pdfText) === "") {
            $pdfText = "[Unable to extract text from PDF. Please download the file instead.]";
        } else {
            // Format extracted text into paragraphs
            $pdfText = nl2br(htmlspecialchars($pdfText));
        }
    }
}

// Decide what to store in DB
$content = $message;
if ($pdfText) {
    $content = $pdfText;
}

// Insert into DB
$stmt = $conn->prepare("
    INSERT INTO submissions 
    (fullName, email, age, title, workType, message, photo, userFile) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)
");
$stmt->bind_param("ssssssss", $fullName, $email, $age, $title, $workType, $content, $photoPath, $filePath);
$stmt->execute();
$id = $stmt->insert_id;
$stmt->close();

// Generate token for approval links
$secretKey = getenv("SECRET_KEY") ?: "mySecretKey123"; 
$token = md5($id . $secretKey);

// Email setup
$clientEmail = "dakenny21@gmail.com";

$approveLink = "https://raisingyoungauthors.com/action.php?id=$id&action=approve&token=$token";
$reviewLink  = "https://raisingyoungauthors.com/action.php?id=$id&action=review&token=$token";
$declineLink = "https://raisingyoungauthors.com/action.php?id=$id&action=decline&token=$token";

$subject = "New Writing: $title";
$body = "
<html>
<head>
  <style>
    body { font-family: Arial, sans-serif; color: #333; }
    .container { padding: 20px; border: 1px solid #ddd; border-radius: 10px; background: #f9f9f9; }
    h2 { color: #2c3e50; }
    p { line-height: 1.5; }
    .btn {
      display: inline-block;
      margin: 5px 10px 5px 0;
      padding: 10px 15px;
      font-weight: bold;
      border-radius: 5px;
      color: #fff;
      text-decoration: none;
    }
    .btn-approve { background-color: #28a745; color: #fff !important }
    .btn-review  { background-color: #ffc107; color: #000 !important; }
    .btn-decline { background-color: #dc3545; color: #fff !important }
  </style>
</head>
<body>
  <div class='container'>
    <h2>📩 New Writing Received</h2>
    <p><strong>Name:</strong> $fullName</p>
    <p><strong>Email:</strong> $email</p>
    <p><strong>Age:</strong> $age</p>
    <p><strong>Title:</strong> $title</p>
    <p><strong>Type:</strong> $workType</p>
    <p><strong>Message:</strong><br><br> $message<br><br></p>
    
    <hr>
    <h3>✅ Take Action</h3>
    <a href='$approveLink' class='btn btn-approve'>Approve</a>
    <a href='$reviewLink' class='btn btn-review'>Review</a>
    <a href='$declineLink' class='btn btn-decline'>Decline</a>
  </div>
</body>
</html>
";

$mail = new PHPMailer(true);
$mail->CharSet = "UTF-8";

try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'dakenny21@gmail.com';
    $mail->Password   = 'wgcf vjyw verz rtsi'; // App Password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    $mail->setFrom('dakenny21@gmail.com', 'Raising Young Authors Writers Form');
    $mail->addReplyTo($email, $fullName);
    $mail->addAddress($clientEmail);
    $mail->addCC($email);

    // Attach uploaded files
    if ($photoPath) {
        $mail->addAttachment($photoPath);
    }
    if ($filePath) {
        $mail->addAttachment($filePath);
    }

    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body    = $body;

    $mail->send();
    echo "✅ Thank you for your submission! We’ll review it shortly.";
} catch (Exception $e) {
    echo "❌ Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
