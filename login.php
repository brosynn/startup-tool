<?php 
require_once 'config.php';

if (isset($_POST['user'])) { //checks if the username entered exists and if the password is right
    // 1. Prepare the statement using your database connection variable (e.g., $conn or $db)
    $stmt = $conn->prepare("SELECT id, user, pass FROM users WHERE user = ? AND pass = ?");

    // 2. Assign the POST data to variables
    $param_user = $_POST['user'][0];
    $param_pass = $_POST['user'][1];

    // 3. Bind the parameters to the STATEMENT object ($stmt), not the result
    $stmt->bind_param("ss", $param_user, $param_pass);

    // 4. Execute and get the result
    $stmt->execute();
    $result = $stmt->get_result();
    
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
    <input type="password" id="pass" name="pass" required><br>
    <input type="submit" onclick="window.location.href='index.php'">
</form>