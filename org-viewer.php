<?php 
require_once 'config.php';
$organization = null;

if (isset($_POST['id'])) 
    {
        $sql = "SELECT * FROM organizations WHERE id = ?"; 
        $stmt = $conn->prepare($sql); 

        // Added missing quotes around the POST key
        $id_param = $_POST['id']; 

        // Added missing quotes around the type definition string 'i'
        $stmt->bind_param('i', $id_param); 

        $stmt->execute(); 
        $result = $stmt->get_result(); 

        // Fetches all rows as an associative array
        $organization = $result->fetch_all(MYSQLI_ASSOC); 
    }

?>

<h1>welcome to Organization Viewer Brother.</h1>

<body>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>" method="POST">
        <label for="org">Enter ID: </label>
        <input type="text" id="id" name="id" required><br>
        <button type="submit" onclick="window.location.href='index.php'">Submit</button>
    </form>

    <?php if (isset($organization)) 
    { ?>
        <img src="<?= $organization[0]['logo_file_path'] . $organization[0]['logo_file_name']?>" alt="org_logo" width="350" height="350">
        <h3><?= $organization[0]['org_name'] ?></h3>
        <p><?= $organization[0]['org_desc'] ?></p>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>" method="POST">
            <label for=''>Hi</label>
        </form>
    <?php }; ?>
</body>