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
    echo "Database connected successfully";
} catch (mysqli_sql_exception $e) {
    // If something goes wrong, show the error
    echo "Could not connect!" . $e->getMessage();
}
?>