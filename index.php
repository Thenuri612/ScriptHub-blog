<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/auth.php';

$sql = "SELECT b.id, b.title, b.created_at, b.user_id, u.username
        FROM blogpost b 
        JOIN `user` u ON b.user_id = u.id
        ORDER BY b.created_at DESC";
$res = $mysqli->query($sql);
$posts = $res->fetch_all(MYSQLI_ASSOC);
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>ScriptHub</title>
    
    <link rel="stylesheet" href="home.css">
</head>

<body class="home-page">

<header>
    <h1>ScriptHub</h1>
    <nav>
        <?php if (isLoggedIn()): ?>
            <span class="user-greeting">Hello, <?= htmlspecialchars($_SESSION['username']) ?></span>
            <div class="actions">
                <a href="create.php">New Post</a>
                <a href="logout.php">Logout</a>
            </div>
        <?php else: ?>
            <div class="actions">
                <a href="login.php">Login</a>
                <a href="register.php">Register</a>
            </div>
        <?php endif; ?>
    </nav>
</header>

<div class="container">
    <?php if (count($posts) === 0): ?>
        <p>No posts yet.</p>
    <?php else: ?>
        <div class="posts">
            <?php foreach ($posts as $index => $p): ?>
                <div class="card card-<?= $index ?>">
                    <h2><a href="view.php?id=<?= $p['id'] ?>"><?= htmlspecialchars($p['title']) ?></a></h2>
                    <small>By <?= htmlspecialchars($p['username']) ?> — <?= $p['created_at'] ?></small>
                    <?php if (isLoggedIn() && $_SESSION['user_id'] == $p['user_id']): ?>
                        <div>
                            <a href="edit.php?id=<?= $p['id'] ?>" class="btn">Edit</a>
                            <a href="delete.php?id=<?= $p['id'] ?>" class="btn" onclick="return confirm('Delete?')">Delete</a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

</body>
</html>









          