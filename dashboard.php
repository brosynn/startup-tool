<?php
require_once 'session_setup.php';

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
    </body>
</html>