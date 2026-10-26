<?php require_once 'config.php'; 

if (isset($_POST['org'])) {
        $org = $_POST['org'];
        $name = $_POST['name'];
        $desc = $_POST['desc'];
        $logo = $_POST['logo'];

        $set_check = "name: $name, Description: $desc, Logo: $logo";

        $sql = $conn->prepare("INSERT INTO organizations (name, desc, logo)
        VALUES (?, ?, ?)");
        $sql->execute([$user, $hash, $first_name, $last_name]);

        
}

include 'header.php'; ?>
                <h1>Create New Organization</h1>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>" method="POST">
                        <label for="org">Name: </label>
                        <input type="text" id="org" name="name" required><br>
                        Description (max of 256 chars): <input type="text" name="desc" required><br>
                        Logo Picture: <input type="file" name="logo" required><br>
                        <input type="submit" onclick="window.location.href='index.php'">
                </form>
        </body>
</html>
<?php mysqli_close($conn); ?>