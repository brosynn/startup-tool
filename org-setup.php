<?php
include_once 'config.php';


if (isset($_POST['org_name'])) 
    {
        $sql = "SELECT * FROM organizations WHERE name = ?"; 
        $stmt = $conn->prepare($sql); 

        // Added missing quotes around the POST key
        $id_param = $_POST['org_name']; 

        // Added missing quotes around the type definition string 'i'
        $stmt->bind_param('s', $id_param); 

        $stmt->execute(); 
        $result = $stmt->get_result(); 

        // Fetches all rows as an associative array
        $organization = $result->fetch_all(MYSQLI_ASSOC); 
    }

    if (isset($_POST['owner_id'])) 
    {
        $sql = "SELECT * FROM users WHERE name = ?"; 
        $stmt = $conn->prepare($sql); 

        // Added missing quotes around the POST key
        $id_param = $_POST['org_name']; 

        // Added missing quotes around the type definition string 'i'
        $stmt->bind_param('s', $id_param); 

        $stmt->execute(); 
        $result = $stmt->get_result(); 

        // Fetches all rows as an associative array
        $user = $result->fetch_all(MYSQLI_ASSOC); 
    }

?>


<h1>Welcome to Organization Setup!</h1>
<p>When you create an organization, it is created without a defined owner. Owner accounts are needed to manage your organization, as its the only account that can make changes to the organization.</p>

<h3>Target Organization Name</h3>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>" method="POST">
        <label for="org_name">Enter Organization Name: </label>
        <input type="text" id="org_name" name="org_name" required><br>
        <input type="submit" onclick="window.location.href='index.php'">
    </form>

<?php if (isset($organization)) 
    { ?>
        <h2>Selected Organization: </h2>
        <img src="<?= $organization[0]['logo_file_path'] . $organization[0]['logo_file_name']?>" alt="org_logo" width="350" height="350">
        <h3><?= $organization[0]['org_name'] ?></h3>
        <p><?= $organization[0]['org_desc'] ?></p>
        <h3>Target Owner Account Name</h3>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>" method="POST">
            <label for="owner_id">Enter Desired Owner Account Name: </label>
            <input type="text" id="owner_id" name="owner_id" required><br>
            <input type="submit" onclick="window.location.href='index.php'">
        </form>
    <?php }; ?>
