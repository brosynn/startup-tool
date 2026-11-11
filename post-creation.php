<?php
require_once 'config.php';
require_once 'login-check.php';

if (isset($_POST['title'])) {

    $post_title = $_POST['title'];
    $post_text = null;
    if (isset($_POST['text'])) {
        $post_text = $_POST['text'];
    }
    $file_name = null;
    $file_id = null;
    echo "Text: $post_text, File name: $file_name, File id: $file_id\n";

    if (isset($_FILES['file']['name'])) {
        $target_dir = "bucket/"; 
        $file_name = basename($_FILES['file']['name']); 
        $target_file = $target_dir . $file_name;

        if (is_file($target_file)) { // attributes an incrementing number to a file if it already exists
            $rep = 1;
            $temp_name = $file_name;
            $temp_file = $target_dir . $file_name;;
            while (is_file($temp_file)) {
                $temp_name = "($rep)$file_name";
                $rep++;
                $temp_file = $target_dir . $temp_name;
            }
            $file_name = $temp_name;
            $target_file = $temp_file;
        }
        if (move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) { // if the file can be moved into the target directory, insert its info into the files table
            $set_check = "File name: $file_name, File path: $target_dir"; 
            echo $set_check;

            $sql = "INSERT INTO files (path, name) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);

            // 'ss' means the parameters are strings
            $stmt->bind_param("ss", $target_dir, $file_name);

            $stmt->execute();

            // get the id of the file just inserted
            $sql = "SELECT id FROM files WHERE path = ? AND name = ?";
            $stmt = $conn->prepare($sql);

            $stmt->bind_param("ss", $target_dir, $file_name);

            $stmt->execute();
            $result = $stmt->get_result();
            $file_id = $result->fetch_all()[0][0];
        } 
        else {
            echo "Error uploading file.";
        }
    }

    $set_check = "\nTitle: $post_title, Text: $post_text, File id in db: $file_id"; 
    echo $set_check;

    $sql = "INSERT INTO posts (title, text, file, author) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param("ssii", $post_title, $post_text, $file_id, $_SESSION['user_id']);

    $stmt->execute();
    

    
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
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>" enctype="multipart/form-data" method="POST">
            <label for="title">Title: </label>
            <textarea type="text" id="title" name="title" required></textarea><br>
            <label for="text">Text: </label>
            <textarea type="text" id="text" name="text"></textarea><br>
            <input type="submit" onclick="window.location.href='index.php'">
            <label for="file">File: </label>
            <input type="file" name="file" id="file"><br>
        </form>
    </body>
</html>