<?php
$host = getenv("DB_HOST");
$user = getenv("DB_USER");
$pass = getenv("DB_PASS");
$dbname = getenv("DB_NAME");
$conn = new mysqli($host, $user, $pass, $dbname);

$result = $conn->query("SELECT * FROM submissions WHERE status='approved' ORDER BY id DESC");
?>

<div class="center-side">
  <?php while ($row = $result->fetch_assoc()): ?>
    <div class="post-card">
      <img src="<?= $row['photo'] ?>" alt="Author Photo" />
      <h3><?= htmlspecialchars($row['title']) ?></h3>
      <p><strong><?= htmlspecialchars($row['fullName']) ?></strong> (<?= $row['age'] ?> yrs)</p>
      <p><?= nl2br($row['message']) ?></p>
      <?php if ($row['userFile']): ?>
        <a href="<?= $row['userFile'] ?>" download>📂 Download File</a>
      <?php endif; ?>
    </div>
  <?php endwhile; ?>
</div>
