<?php 
require_once 'session_setup.php';
include 'database.php';

if (isset($_POST['user'])) { //checks if the username entered exists and if the password is right
    $sql = "SELECT id, user, pass FROM users
    WHERE user = ?";
    $result = $conn->execute_query($sql, [$_POST['user']]);
    $account = $result->fetch_all();
    if (isset($account[0])) {
        if (password_verify($_POST['pass'], $account[0][2])) {
            // prevents session fixation
            session_regenerate_id(true);

            $_SESSION['user_id'] = $account[0][0];
            $_SESSION['logged_in'] = true;

            header('Location: dashboard.php');
            exit();
        }
        else {
            echo "Username or password is incorrect";
        }
    }
    else {
        echo "Username or password is incorrect.";
    }
}

include 'header.php'; ?>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>" method="POST">
    <label for="user">Username: </label>
    <input type="text" id="user" name="user" required><br>
    <label for="pass">Password: </label>
    <input type="text" id="pass" name="pass" required><br>
    <input type="submit" onclick="window.location.href='index.php'">
</form>