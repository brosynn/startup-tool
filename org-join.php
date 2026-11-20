<?php
// this page is for joining already "set up" organizations, this is done on org-setup.php  
require_once 'config.php';

if (isset($_POST['org_name'])) 
{
    $sql = "SELECT * FROM organizations WHERE org_name = ?"; 
    $stmt = $conn->prepare($sql); 

    $id_param = $_POST['org_name']; 

    $stmt->bind_param('s', $id_param); 

    $stmt->execute(); 
    $result = $stmt->get_result(); 

    // Fetches all rows as an associative array
    $organization = $result->fetch_all(MYSQLI_ASSOC); 
    $_SESSION['organization'] = $organization;
}

if (isset($_POST['join'])) 
{
    $sql = "INSERT INTO orgmembers (user_id, org_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    
    $user_param = (int) $_SESSION['user_id'];
    $org_param = (int) $_SESSION['organization'][0]['id'];

    $stmt->bind_param('ii', $user_param, $org_param);
    $stmt->execute();
    
    unset($_SESSION['organization']);

    //header("Location: " . $_SERVER['PHP_SELF']);
    //exit;
}

?>

<h1>Welcome to joining organizations!</h1>
<p>That silly little account of yours is nothing until it joins an organization. Do dat ere m8, gg no re.</p>

<h3>Target Organization Name</h3>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>" method="POST">
        <label for="org_name">Enter Organization Name: </label>
        <input type="text" id="org_name" name="org_name" required autocomplete="on"><br>
        <button type="submit" onclick="window.location.href='index.php'">Submit</button>
    </form>

    <?php if (isset($organization)) 
    { ?>
        <h2>Selected Organization: </h2>
        <img src="<?= $organization[0]['logo_file_path'] . $organization[0]['logo_file_name']?>" alt="org_logo" width="350" height="350">
        <h3><?= $organization[0]['org_name'] ?></h3>
        <p><?= $organization[0]['org_desc'] ?></p>

        <form method="POST">
            <label>didy forem</label>
            <input type="hidden" name="join" value="joe zilch">
            <button type="submit" onclick="window.location.href='index.php'">Submit</button>
        </form>
    
    <?php }; ?>