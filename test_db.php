<?php
// C:\xampp\htdocs\blog_app\test_db.php
require_once __DIR__ . '/db.php';

if (isset($mysqli) && $mysqli instanceof mysqli) {
    echo "<h2 style='color:green;text-align:center;'>✅ Database connected successfully!</h2>";
} else {
    echo "<h2 style='color:red;text-align:center;'>❌ Database connection failed or \$mysqli not set.</h2>";
}


