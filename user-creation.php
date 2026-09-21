<?php include 'database.php'; 

if (isset($_POST['user'])) {
        $user = $_POST['user'];
        $hash = password_hash($_POST['pass'], PASSWORD_DEFAULT);
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];

        $set_check = "User: $user, Hash: $hash, First name: $first_name, Last name: $last_name";

        $sql = "INSERT INTO users (user, pass, first_name, last_name)
        VALUES ('$user', '$hash', '$first_name', '$last_name')";

        try {
                mysqli_query($conn, $sql);
                echo "<script>window.location.href='index.php'</script>";
        }
        catch(mysqli_sql_exception $e) {
                echo " Could not register user. Error message: " . $e->getMessage();
        }
}
?>

<?php include 'header.php'; ?>
                <h1>Create New User</h1>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>" method="POST">
                        Username: <input type="text" name="user" required><br>
                        Password: <input type="text" name="pass" required><br>
                        First Name: <input type="text" name="first_name" required><br>
                        Last Name: <input type="text" name="last_name" required><br>
                        <input type="submit" onclick="window.location.href='index.php'">
                </form>
        </body>
</html>
<?php mysqli_close($conn); ?>