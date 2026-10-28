<?php
$db_server = 'localhost';
$db_name   = 'startup_tool_database';
$db_user = 'root';
$db_pass = '';
$db_charset = 'utf8mb4';
$conn = '';

try {
    // Create the connection
    $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
    echo "Database connected successfully\n";
} catch (mysqli_sql_exception $e) {
    // If something goes wrong, show the error
    echo "Could not connect!\n" . $e->getMessage();
}

// sets up session
// makes session IDs cookie-only
ini_set('session.use_only_cookies', 1);
ini_set('session.use_strict_mode', 1);

// sets up cookies
session_set_cookie_params([
    'lifetime'  => 0,
    'path' => '/',
    'domain' => '',
    'secure' => false,
    'httponly' => true,
    'samesite' => 'Lax'
]);

session_start();
?>