<?php
// post.php – SEO + styled single post page

error_reporting(E_ALL);
ini_set('display_errors', 1);

// --- DB connection ---
$host = "localhost";
$user = "qvecmzzj_authors";
$pass = "Rock2025";
$dbname = "qvecmzzj_authors_db";
$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    http_response_code(500);
    die("Database Connection Failed: " . $conn->connect_error);
}

// --- Get ID from pretty URL (/post/123/slug) ---
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0) {
    http_response_code(400);
    die("Invalid post ID.");
}

// --- Fetch post ---
$stmt = $conn->prepare("SELECT id, title, message, fullName, photo, created_at, likes 
                        FROM submissions WHERE id=? AND status='approved' LIMIT 1");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
$post = $res->fetch_assoc();
$stmt->close();
$conn->close();

if (!$post) {
    http_response_code(404);
    die("<p style='color:#b00020'>❌ Post not found.</p>");
}

// --- Helpers ---
function absolute_url($path) {
    if (!$path) return '';
    if (preg_match('~^https?://~i', $path)) return $path;
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host   = $_SERVER['HTTP_HOST'] ?? 'raisingyoungauthors.com';
    return rtrim($scheme . '://' . $host, '/') . '/' . ltrim($path, '/');
}
function render_message($text) {
    if ($text === null) return '';
    $allowed = '<p><br><b><strong><i><em><u><ul><ol><li><blockquote><pre><code><h1><h2><h3><h4>';
    $clean   = strip_tags($text, $allowed);
    if ($clean === strip_tags($clean)) {
        return nl2br(htmlspecialchars($clean, ENT_QUOTES, 'UTF-8'));
    }
    return $clean;
}

// --- SEO title + description ---
$title       = htmlspecialchars($post['title'] ?: "Untitled", ENT_QUOTES, 'UTF-8');
$description = substr(strip_tags($post['message']), 0, 160);
$photoUrl    = absolute_url($post['photo'] ?? '');
$cssMain     = absolute_url('styles.css');
$scriptMain  = absolute_url('script.js');
$logoUrl     = absolute_url('images/New Logo.png');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title ?> | Raising Young Authors</title>
  <meta name="description" content="<?= htmlspecialchars($description) ?>">
  <link rel="stylesheet" href="<?= $cssMain ?>">
  <link rel="icon" href="<?= $logoUrl ?>" type="image/png">
  <link href="https://fonts.googleapis.com/css2?family=Merriweather&family=Outfit:wght@300;400;600&display=swap" rel="stylesheet">
  <style>
    body { background:#f5f6f8; font-family:'Outfit', sans-serif; }
    .container { max-width: 980px; margin: 40px auto; padding: 0 16px; }
    .card { background:#fff; border-radius:14px; box-shadow:0 6px 22px rgba(0,0,0,0.08); overflow:hidden; }
    .hero { padding:20px; }
    .hero img { width:100%; height:400px; object-fit:cover; border-radius:12px; margin-bottom:20px; }
    .title { font-family:'Merriweather', serif; color:#204F3D; font-size:30px; margin:0 0 10px; }
    .meta { color:#6e6e6e; font-size:14px; margin-bottom:20px; }
    .content { padding:0 20px 24px; color:#333; line-height:1.7; font-size:16px; }
    .actions { padding:20px; display:flex; align-items:center; gap:20px; }
    .like-btn { background:#204F3D; color:#fff; border:none; border-radius:8px; padding:10px 16px; cursor:pointer; font-size:16px; }
    .like-btn.liked { background:#28a745; }
    .back { text-decoration:none; color:#204F3D; font-weight:600; }
  </style>
</head>
<body>
  <main class="container">
    <div class="card">
      <div class="hero">
        <?php if (!empty($photoUrl)): ?>
          <img src="<?= $photoUrl ?>" alt="Post image">
        <?php endif; ?>
        <h1 class="title"><?= $title ?></h1>
        <div class="meta">
          By <strong><?= htmlspecialchars($post['fullName'] ?: 'Anonymous', ENT_QUOTES, 'UTF-8') ?></strong>
          · <?= date("M d, Y", strtotime($post['created_at'])) ?>
        </div>
      </div>
      <div class="content">
        <?= render_message($post['message']) ?>
      </div>
      <div class="actions">
        <button class="like-btn" data-post="<?= $post['id'] ?>">
          👍 Like <span id="like-count-<?= $post['id'] ?>"><?= (int)$post['likes'] ?></span>
        </button>
        <a class="back" href="https://raisingyoungauthors.com/community-blog.php">⬅ Back to Blog
        </a>
      </div>
    </div>
  </main>
  <script src="<?= $scriptMain ?>"></script>
</body>
</html>
