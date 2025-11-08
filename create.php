<?php
require_once 'db.php';
require_once 'auth.php';
requireLogin(); // Ensure user is logged in

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');

    if ($title === '' || $content === '') {
        $errors[] = 'Title and content are required.';
    } else {
        $stmt = $mysqli->prepare("INSERT INTO blogPost (user_id, title, content) VALUES (?, ?, ?)");
        $stmt->bind_param('iss', $_SESSION['user_id'], $title, $content);
        if ($stmt->execute()) {
            header('Location: index.php');
            exit();
        } else {
            $errors[] = 'Database error.';
        }
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Create New Post - ScriptHub</title>
  <link rel="stylesheet" href="blog.css/create.css">
</head>
<body class="create-page">

  <header>
    <h1>ScriptHub</h1>
    <nav>
      <a href="index.php">Home</a> |
      <a href="logout.php">Logout</a>
    </nav>
  </header>

  <div class="form-wrap">
    <h1>Create New Post</h1>

    <?php if (!empty($errors)): ?>
      <div class="alert">
        <?php foreach ($errors as $e) echo htmlspecialchars($e) . '<br>'; ?>
      </div>
    <?php endif; ?>

    <form method="post">
      <label>Title</label>
      <input type="text" name="title" required>

      <label>Content</label>
      <textarea name="content" required></textarea>

      <button type="submit">Publish</button>
    </form>
  </div>
</body>
</html>








   