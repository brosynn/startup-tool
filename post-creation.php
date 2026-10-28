<?php
require_once 'config.php';
require_once 'login-check.php';

if (isset($_POST['text'])) {
    
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
        <h1>So you wanna create a post, huh? Huh?!</h1>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>" method="POST">
            <label for="text">Text: </label>
            <textarea type="text" id="text" name="text"></textarea><br>
            <input type="submit" onclick="window.location.href='index.php'">
        </form>
    </body>
</html>