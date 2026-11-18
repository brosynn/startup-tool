<?php
require_once 'config.php';
require_once 'login-check.php';
require_once 'sql-functions.php';

if (isset($_POST['title'])) {
    createPost($_POST['title'], $_POST['text'], $_FILES['file'], $_SESSION['user_id'], $_POST['posted_to_org'], $_POST['posted_to_role']);
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
            <input type="file" name="file" id="file"><br><br>
            <h2>For whom shall this post be designated?!</h2>
            <label for="org">Organization(s): </label>
            <?php 
                $orgs = getUserOrgs($_SESSION['user_id']);
                foreach($orgs['ids'] as $index => $org) { ?>
                <input type="radio" name="posted_to_org[]" value="<?php echo $orgs['ids'][$index]; ?>" required <?php
                if ($index == 0) {
                    echo "checked";
                }
                ?>><?php echo $orgs['names'][$index];?></input>
            <?php } ?><br>
            <label for="role">Roles: </label>
            <?php 
                $roles = getUserRoles($_SESSION['user_id']);
                foreach($roles['ids'] as $index => $role) { ?>
                <input type="checkbox" name="posted_to_role[]" value="<?php echo $roles['ids'][$index] ?>"><?php echo $roles['names'][$index] ?></input>
            <?php } ?>
        </form>
    </body>
</html>