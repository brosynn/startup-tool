<?php
require_once 'config.php';
include 'login-check.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Startup Tool</title>
    </head>
    <body>
        <h1>Welcome to your Dashboard!</h1>
        <p>I hate you</p>
        <button onclick="window.location.href='post-creation.php'">Create Post</button>
        <button onclick="window.location.href='logout.php'">Log Out</button>
    </body>
</html>