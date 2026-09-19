<?php
$host = 'localhost';
$db   = 'startup_tool_database';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {
    // Create the connection
    $pdo = new PDO($dsn, $user, $pass);
    echo "Database connected successfully";
} catch (PDOException $e) {
    // If something goes wrong, show the error
    echo "❌ Connection failed: " . $e->getMessage();
}
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Startup Tool</title>
    </head>
    <body>
        <p>Hello World!</p>
    </body>
</html>