<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/auth.php';

$errors = [];
$username = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if ($username === '' || $email === '' || $password === '' || $confirm_password === '') {
        $errors[] = 'All fields are required.';
    } elseif ($password !== $confirm_password) {
        $errors[] = 'Passwords do not match.';
    } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $mysqli->prepare("INSERT INTO `user` (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param('sss', $username, $email, $hashed);

        if ($stmt->execute()) {
            header('Location: login.php');
            exit();
        } else {
            $errors[] = 'Username or email already exists.';
        }
        $stmt->close();
    }
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Register - ScriptHub</title>
    <link rel="stylesheet" href="blog.css/register.css">
</head>
<body class="register-page">

<div class="register-box">
    <h1>Register</h1>
    <nav>
        <a href="login.php">Login</a>
        <a href="index.php">Home</a>
    </nav>

    <div class="form-wrap">
        <?php if (!empty($errors)): ?>
            <div class="alert">
                <?php foreach ($errors as $e) echo htmlspecialchars($e) . '<br>'; ?>
            </div>
        <?php endif; ?>

        <form method="post">
            <label>Username</label>
            <input type="text" name="username" required value="<?= htmlspecialchars($username) ?>">

            <label>Email</label>
            <input type="email" name="email" required value="<?= htmlspecialchars($email) ?>">

            <label>Password</label>
            <input type="password" name="password" required>

            <label>Confirm Password</label>
            <input type="password" name="confirm_password" required>

            <button type="submit">Register</button>
        </form>
    </div>
</div>

</body>
</html>





  