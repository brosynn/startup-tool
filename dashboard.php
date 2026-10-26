<?php
require_once 'config.php';

// checks to see if user is already logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: index.php');
    exit();
}
include 'header.php';
?>

<html lang="en">
    <body>
        <h1>Welcome to your Dashboard!</h1>
        <p>I hate you</p>
        <button onclick="window.location.href='logout.php'">Log Out</button>
    </body>
</html>