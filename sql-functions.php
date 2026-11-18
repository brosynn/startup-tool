<?php 
require_once 'config.php';

function userInfo(int $user) {
    $cols = getUserCols($user);
    $orgs = getUserOrgs($user);
    $roles = getUserRoles($user);

    echo "Username: " . $cols[0] . "<br>First Name: " . $cols[1] . "<br>Last Name: " . $cols[2];
    echo "<br>Organization IDs: " . arrayToString($orgs['ids']) . "<br>Organization Names: " . arrayToString($orgs['names']);
    echo "<br>Role IDs: " . arrayToString($roles['ids']) . "<br>Role Names: " . arrayToString($roles['names']);
}

function getUserCols(int $user) { // will return an associative array containing the user's 'user', 'first_name', and 'last_name'
    global $conn;

    $sql = "SELECT user, first_name, last_name FROM users
    WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user);

    $stmt->execute();
    $result = $stmt->get_result()->fetch_all();
    return $result[0];
}

function arrayToString(mixed $arr) {
    return implode(", ", $arr);
}

function getUserRoles(int $user) { // will return two indexed arrays with the user's role 'ids' and the role 'names' respectively.
    global $conn;
    $id_list = [];
    $name_list = [];

    $sql = "SELECT roles.id AS id, roles.name AS name FROM roles JOIN rolemembers
    ON rolemembers.user = ? 
    AND rolemembers.org = roles.org";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user);

    $stmt->execute();
    $roles = $stmt->get_result();
    foreach ($roles as $role) { // each $role has 2 associative array values, id and name. 
        $id_list[] = $role['id'];
        $name_list[] = $role['name'];
    }
    return ['ids' => $id_list, 'names' => $name_list];
}

function getUserOrgs(int $user) { // will return two indexed arrays with the user's organization 'ids' and the organization 'names' respectively.
    global $conn;
    $id_list = [];
    $name_list = [];

    $sql = "SELECT organizations.id AS id, organizations.org_name AS name FROM organizations JOIN orgmembers
    ON orgmembers.user_id = ?
    AND organizations.id = orgmembers.org_id
    AND orgmembers.status = 1";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user);

    $stmt->execute();
    $orgs = $stmt->get_result();
    foreach ($orgs as $org) { // each $org has 2 associative array values, id and name. 
        $id_list[] = $org['id'];
        $name_list[] = $org['name'];
    }
    return ['ids' => $id_list, 'names' => $name_list];
}

function createPost(string $title, string $body_text, mixed $file, int $author, mixed $target_orgs, mixed $target_roles) {
    global $conn;
    $file_name = null;
    $file_id = null;

    if (isset($file['name'])) {
        $target_dir = "bucket/"; 
        $file_name = basename($file['name']); 
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
        if (move_uploaded_file($file['tmp_name'], $target_file)) { // if the file can be moved into the target directory, insert its info into the files table

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

    $set_check = "\nTitle: $title, Text: $body_text, File id in db: $file_id"; 
    echo $set_check;

    $sql = "INSERT INTO posts (title, text, file, author) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param("ssii", $title, $body_text, $file_id, $_SESSION['user_id']);

    $stmt->execute();
}

/*function getViewablePosts(int $user) { // returns an indexed array containing the ids of every post viewable by the entered user.
    // check the organization(s) and role(s) of the user to return which posts they're allowed to view
    global $conn;
    $post_list = [];

    $org_list = getUserOrgs($user)[0];
    $role_list = getUserRoles($user)[0];

    $org_placeholders = implode(',', array_fill(0, count($org_list), '?'));
    $role_placeholders = implode(',', array_fill(0, count($role_list), '?'));

    $sql = "SELECT posts.id FROM posts JOIN users as author JOIN orgmembers
    ON author.id = ";
}*/
?>