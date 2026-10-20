<?php include 'database.php';

include 'header.php'; ?>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>" method="POST">
    <label for="user">Username: </label>
    <input type="text" id="user" name="user" required><br>
    <label for="pass">Password: </label>
    <input type="text" id="pass" name="pass" required><br>
    <input type="submit" onclick="window.location.href='index.php'">
</form>