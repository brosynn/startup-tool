<?php require_once 'config.php'; 
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
    header("Location: dashboard.php");
}
 ?>

<?php include 'header.php'; ?>
    <h1>Welcome to the Startup Tool! (name pending)</h1>
    <br>
    <button onclick="window.location.href='user-creation.php'">New User</button>
    <button onclick="window.location.href='login.php'">Log In</button>
<?php include 'footer.php'; ?>