<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/auth.php';

$id = $_GET['id'] ?? null;
if (!$id) { header('Location: index.php'); exit; }

$stmt = $mysqli->prepare("SELECT b.*, u.username FROM blogpost b JOIN `user` u ON b.user_id = u.id WHERE b.id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$post = $stmt->get_result()->fetch_assoc();
if (!$post) { header('Location: index.php'); exit; }
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title><?= htmlspecialchars($post['title']) ?> - ScriptHub</title>
  <link rel="stylesheet" href="view.css">
</head>
<body class="view-page">

  <header>
    <h1>ScriptHub</h1>

    <?php if (isLoggedIn()): ?>
        <div class="user-greeting">Hello, <?= htmlspecialchars($_SESSION['username']) ?></div>
        <nav>
            <a href="index.php">Home</a>
            <a href="logout.php">Logout</a>
        </nav>
    <?php else: ?>
        <nav>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        </nav>
    <?php endif; ?>
  </header>

  <div class="wrap">
    <h2><?= htmlspecialchars($post['title']) ?></h2>
    <small>By <?= htmlspecialchars($post['username']) ?> — <?= $post['created_at'] ?></small>
    <div class="content"><?= htmlspecialchars($post['content']) ?></div>

    <?php if (isLoggedIn() && $_SESSION['user_id'] == $post['user_id']): ?>
      <div>
        <a href="edit.php?id=<?= $post['id'] ?>" class="btn">Edit</a>
        <a href="delete.php?id=<?= $post['id'] ?>" class="btn" onclick="return confirm('Delete?')">Delete</a>
      </div>
    <?php endif; ?>
  </div>
</body>
</html>







       