<?php 
require_once 'config.php';

if (isset($_POST['function'])) {
    eval($_POST['function']);
}

function getUserRoles(int $user) { // will return two associative arrays with the user's role 'ids' and the role 'names' respectively.
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

function getUserOrgs(int $user) { // will return two associative arrays with the user's organization 'ids' and the organization 'names' respectively.
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

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Startup Tool</title>
    </head>
    <body>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>" method="POST">
            <label for="function">Function: </label>
            <textarea type="text" id="function" name="function" required></textarea><br>
            <input type="submit" onclick="window.location.href='sql-functions.php'">
        </form>
    </body>
</html>