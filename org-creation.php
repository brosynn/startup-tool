<?php include 'config.php'; 

$set_check = null;
if (isset($_POST['name'])) {
        $name = $_POST['name'];
        $desc = $_POST['desc'];
        

        $target_dir = "bucket/"; 
        $file_name = basename($_FILES['logo']['name']); 
        $target_file = $target_dir . $file_name;

        if (move_uploaded_file($_FILES['logo']['tmp_name'], $target_file)) {
        
                $set_check = "name: $name, Description: $desc, Logo file name: $file_name, logo file path: $target_dir"; 

                $sql = "INSERT INTO organizations (org_name, org_desc, logo_file_name, logo_file_path) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);

                // 'ssss' means all 4 parameters are strings
                $stmt->bind_param("ssss", $name, $desc, $file_name, $target_dir);

                $stmt->execute();
        
                echo "Organization added successfully!";
        } 
        else {
                echo "Error uploading file.";
        }

        
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
        <h1>Create New Organization</h1>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>" method="POST" enctype="multipart/form-data">
            <label for="name">Name: </label>
            <input type="text" id="name" name="name" required><br>
            <label for="desc">Description (max of 256 chars): </label>
            <input type="text" name="desc" required><br>
            <label for="logo">Logo Picture: </label>
            <input type="file" name="logo" id="logo" required><br>
            <input type="submit" onclick="window.location.href='index.php'">
        </form>
    </body>
</html>
<?php mysqli_close($conn); ?>