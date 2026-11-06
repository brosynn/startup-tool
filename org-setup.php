<?php
include_once 'config.php';
$_SESSION['mergeFlag'] = false;

if (!(session_status() === PHP_SESSION_ACTIVE))
    {
        session_start();
        $_SESSION['mergeFlag'] = false;
    };

if (isset($_SESSION['organization'])) 
    {
        $organization = $_SESSION['organization']; 
    }


if (isset($_SESSION['user'])) 
    {
        $user = $_SESSION['user']; 
    }

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

    if (isset($_POST['owner_name'])) 
    {
        $sql = "SELECT * FROM users WHERE user = ?"; 
        $stmt = $conn->prepare($sql); 


        $id_param = $_POST['owner_name']; 

        $stmt->bind_param('s', $id_param); 

        $stmt->execute(); 
        $result = $stmt->get_result(); 

        // Fetches all rows as an associative array
        $user = $result->fetch_all(MYSQLI_ASSOC); 
        $_SESSION['user'] = $user;
    }

    if (isset($_SESSION['mergeFlag']) && $_SESSION['mergeFlag']) 
    {
       $sql = "UPDATE organizations SET owner_id = ? WHERE org_name = ?";
       $stmt = $conn->prepare($sql);

        $id_param = $user[0]['id']; 
        $org_param = $organization[0]['org_name'];

        $stmt->bind_param('is', $id_param, $org_param); 

        $stmt->execute();
        echo "it has been done idk if it worked go check home skillet";
        $_SESSION = array();
        header("Refresh:0");
        exit;
    }

?>


<h1>Welcome to Organization Setup!</h1>
<p>When you create an organization, it is created without a defined owner. Owner accounts are needed to manage your organization, as its the only account that can make changes to the organization.</p>

<h3>Target Organization Name</h3>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>" method="POST">
        <label for="org_name">Enter Organization Name: </label>
        <input type="text" id="org_name" name="org_name" required autocomplete="on"><br>
        <input type="submit" onclick="window.location.href='index.php'">
    </form>

<?php if (isset($organization) || isset($user)) 
    { ?>
        <h2>Selected Organization: </h2>
        <img src="<?= $organization[0]['logo_file_path'] . $organization[0]['logo_file_name']?>" alt="org_logo" width="350" height="350">
        <h3><?= $organization[0]['org_name'] ?></h3>
        <p><?= $organization[0]['org_desc'] ?></p>
        <h3>Target Owner Account Name</h3>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>" method="POST">
            <label for="owner_name">Enter Desired Owner Account Name: </label>
            <input type="text" id="owner_name" name="owner_name" required><br>
            <input type="submit" onclick="window.location.href='index.php'">
        </form>

        <?php if (isset($user)) 
        { ?>
            <h2>Selected User: <?= $user[0]['first_name'] . " " . $user[0]['last_name']?></h2>
            <button type="merge" onclick="<?php $_SESSION['mergeFlag'] = true;?> location.reload();">Set Owner</button>
        <?php }; ?>
    <?php }; ?>
