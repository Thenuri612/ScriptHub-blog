<?php

if (!defined('AUTH_SECRET')) {
    define('AUTH_SECRET', 'change_this_to_a_strong_random_string');
}

require_once __DIR__ . '/db.php'; 
if (!isset($_SESSION)) {
    session_start();
}

function restore_session_from_cookie_if_needed() {
    if (isset($_SESSION['user_id'])) {
        return;
    }

    if (empty($_COOKIE['remember'])) {
        return;
    }

    $cookie = $_COOKIE['remember'];
    $parts = explode('|', $cookie, 2);
    if (count($parts) !== 2) {
        return;
    }

    $user_id = (int)$parts[0];
    $hmac = $parts[1];

    if ($user_id <= 0 || empty($hmac)) {
        return;
    }

    global $mysqli;
    $stmt = $mysqli->prepare("SELECT username FROM `user` WHERE id = ? LIMIT 1");
    if (! $stmt) return;
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (! $row) {

        clear_remember_cookie();
        return;
    }

    $username = $row['username'];
    $expected_hmac = hash_hmac('sha256', $user_id . '|' . $username, AUTH_SECRET);

    if (hash_equals($expected_hmac, $hmac)) {
        
        $_SESSION['user_id'] = $user_id;
        $_SESSION['username'] = $username;
    } else {
    
        clear_remember_cookie();
    }
}

restore_session_from_cookie_if_needed();

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function loginUser($id, $username) {
    $_SESSION['user_id'] = $id;
    $_SESSION['username'] = $username;
}

function set_remember_cookie($id, $username, $days = 30) {
    $expiry = time() + ($days * 24 * 60 * 60);
    $hmac = hash_hmac('sha256', $id . '|' . $username, AUTH_SECRET);
    $value = $id . '|' . $hmac;

    setcookie('remember', $value, [
        'expires' => $expiry,
        'path' => '/',
        'httponly' => true,
        'samesite' => 'Lax',
        // 'secure' => true, // enable in production over HTTPS
    ]);
}

function clear_remember_cookie() {
    setcookie('remember', '', [
        'expires' => time() - 3600,
        'path' => '/',
        'httponly' => true,
        'samesite' => 'Lax',
        // 'secure' => true,
    ]);
}
function logoutUser() {
    clear_remember_cookie();
    session_unset();
    session_destroy();
}
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit();
    }
}

 