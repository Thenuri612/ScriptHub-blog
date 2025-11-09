<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/auth.php';

$errors = [];
$posted_user = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = trim($_POST['email_or_username'] ?? '');
    $p = $_POST['password'] ?? '';
    $posted_user = htmlspecialchars($u, ENT_QUOTES | ENT_SUBSTITUTE);

    if ($u === '' || $p === '') {
        $errors[] = 'All fields are required.';
    } else {
        $stmt = $mysqli->prepare("SELECT id, username, password FROM `user` WHERE email=? OR username=? LIMIT 1");
        $stmt->bind_param('ss', $u, $u);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();

        if ($row && password_verify($p, $row['password'])) {
           
            loginUser($row['id'], $row['username']);

            if (!empty($_POST['remember_me'])) {
                set_remember_cookie($row['id'], $row['username'], 30); 
            }

            header('Location: index.php');
            exit();
        } else {
            $errors[] = 'Invalid credentials.';
        }
        $stmt->close();
    }
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login - ScriptHub</title>
    <link rel="stylesheet" href="login.css">
</head>
<body class="login-page">
    <div class="login-box">
        <h1>Login</h1>
        <nav>
            <a href="register.php">Register</a>
            <a href="index.php">Home</a>
        </nav>

        <div class="form-wrap">
            <?php if (!empty($errors)): ?>
                <div class="alert">
                    <?php foreach ($errors as $e) echo htmlspecialchars($e) . '<br>'; ?>
                </div>
            <?php endif; ?>

            <form method="post">
                <label>Email or Username</label>
                <input type="text" name="email_or_username" required value="<?= $posted_user ?>">

                <label>Password</label>
                <input type="password" name="password" required>

                <div class="remember-row">
                  <input type="checkbox" name="remember_me" value="1" id="remember_me">
                  <label for="remember_me">Remember Me</label>
                </div>


                <button type="submit" style="margin-top:12px;">Login</button>
            </form>
        </div>
    </div>
</body>
</html>





