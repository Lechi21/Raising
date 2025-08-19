<?php
$host = "localhost";
$user = "qvecmzzj_authors";
$pass = "Rock2025";
$dbname = "qvecmzzj_authors_db";
$conn = new mysqli($host, $user, $pass, $dbname);

$id     = $_GET['id'];
$action = $_GET['action'];
$token  = $_GET['token'];

$secretKey = getenv("SECRET_KEY") ?: "mySecretKey123"; 
$token = md5($id . $secretKey);
if ($token !== md5($id . $secretKey)) {
    die("Invalid token!");
}

if ($action === "approve") {
    $conn->query("UPDATE submissions SET status='approved' WHERE id=$id");
    echo "✅ Submission approved!";
} elseif ($action === "decline") {
    $conn->query("UPDATE submissions SET status='declined' WHERE id=$id");
    echo "❌ Submission declined!";
} elseif ($action === "review") {
    // Show a read-only preview of submission
    $res = $conn->query("SELECT * FROM submissions WHERE id=$id")->fetch_assoc();
    echo "<h2>{$res['title']}</h2><p>{$res['message']}</p>";
}
?>
