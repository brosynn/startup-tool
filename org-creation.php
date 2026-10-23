<?php include 'database.php'; 

if (isset($_POST['org'])) {
        $org = $_POST['org'];
        $name = $_POST['name'];
        $desc = $_POST['desc'];
        $logo = $_POST['logo'];

        $target_dir = "bucket/"; 
        $file_name = basename($_FILES['logo']['name']); 
        $target_file = $target_dir . $file_name;

        if (move_uploaded_file($_FILES['logo']['tmp_name'], $target_file)) {
        
        $set_check = "name: $name, Description: $desc, Logo file name: $file_name, logo file path: $target_dir"; 
        
        $sql = $conn->prepare("INSERT INTO organizations (`name`, `desc`, logo_file_name, logo_file_path) VALUES (?, ?, ?, ?)");
        
        $sql->execute([$name, $desc, $file_name, $target_dir]);
        
        echo "Organization added successfully!";
        } else {
        echo "Error uploading file.";
        }

        
}

require_once 'header.php'; ?>
                <h1>Create New Organization</h1>
                <p><?php echo $set_check?></p>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>" method="POST" enctype="multipart/form-data">
                        <label for="org">Name: </label>
                        <input type="text" id="org" name="name" required><br>
                        Description (max of 256 chars): <input type="text" name="desc" required><br>
                        Logo Picture: <input type="file" name="logo" required><br>
                        <input type="submit" onclick="window.location.href='index.php'">
                </form>
        </body>
</html>
<?php mysqli_close($conn); ?>