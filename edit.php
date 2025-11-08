<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/auth.php';
requireLogin(); // Ensure user is logged in

// Get post ID from URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$id) {
    header('Location: index.php');
    exit;
}

// Fetch the post and ensure it belongs to the logged-in user
$stmt = $mysqli->prepare("SELECT * FROM blogPost WHERE id=? AND user_id=?");
$stmt->bind_param('ii', $id, $_SESSION['user_id']);
$stmt->execute();
$post = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$post) {
    header('Location: index.php');
    exit;
}

// Handle form submission
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');

    if ($title === '' || $content === '') {
        $errors[] = 'Title and content are required.';
    } else {
        $stmt = $mysqli->prepare("UPDATE blogPost SET title=?, content=?, updated_at=NOW() WHERE id=?");
        $stmt->bind_param('ssi', $title, $content, $id);
        if ($stmt->execute()) {
            $stmt->close();
            header('Location: view.php?id=' . $id);
            exit();
        } else {
            $errors[] = 'Database error.';
            $stmt->close();
        }
    }
}
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Edit Post - ScriptHub</title>
    <link rel="stylesheet" href="blog.css/edit.css">
</head>
<body class="blog-page">
    <header>
        <h1>ScriptHub</h1>
        <nav>
            <!-- Greeting on its own line -->
            <div class="user-greeting">
                Hello, <?= htmlspecialchars($_SESSION['username'] ?? '') ?>
            </div>
            <!-- Links below -->
            <div class="nav-links">
                <a href="index.php">Home</a> |
                <a href="logout.php">Logout</a>
            </div>
        </nav>
    </header>

    <div class="form-wrap">
        <h2>Edit Post</h2>

        <?php if (!empty($errors)): ?>
            <div class="alert">
                <?php foreach ($errors as $e) echo htmlspecialchars($e) . '<br>'; ?>
            </div>
        <?php endif; ?>

        <form method="post">
            <label>Title</label>
            <input type="text" name="title" value="<?= htmlspecialchars($post['title']) ?>" required>

            <label>Content</label>
            <textarea name="content" required><?= htmlspecialchars($post['content']) ?></textarea>

            <button type="submit">Update</button>
        </form>
    </div>
</body>
</html>



   