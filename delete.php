<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/auth.php';
requireLogin();

$id = $_GET['id'] ?? null;

if ($id) {
    $stmt = $mysqli->prepare("DELETE FROM blogPost WHERE id=? AND user_id=?");
    $stmt->bind_param('ii', $id, $_SESSION['user_id']);
    $stmt->execute();
}

header('Location: index.php');
exit();


       