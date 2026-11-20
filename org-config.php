<?php
// Ensure session_start() is inside config.php, or uncomment the line below:
// session_start(); 

require_once 'config.php';
include 'sql-functions.php';

if (isset($_POST['selection']))
    {
        $sql = "SELECT * FROM organizations WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $_POST['selection']);
        $stmt->execute();

        $result = $stmt->get_result();
        $selected_org = $result->fetch_assoc();
        $_SESSION['selected_org'] = $selected_org;
    }

if (isset($_POST['selectFlag']))
    {
        unset($_SESSION['selected_org']);
    }

if (isset($_SESSION['selected_org']))
    {
        if (isset($_POST['updateMainFlag']))
            {    
                if ($_FILES['logo']['error'] === UPLOAD_ERR_OK)
                    {
                        $target_dir = "bucket/"; 
                        $file_name = basename($_FILES['logo']['name']); 
                        $target_file = $target_dir . $file_name;

                        if (move_uploaded_file($_FILES['logo']['tmp_name'], $target_file)) 
                            {
                                $sql = "UPDATE organizations SET org_name = ?, org_desc = ?, logo_file_path = ?, logo_file_name = ? WHERE id = ?";
                                $stmt = $conn->prepare($sql);
                                $stmt->bind_param('ssssi', $_POST['name'], $_POST['desc'], $target_dir, $file_name, $_SESSION['selected_org']['id']);
                                $stmt->execute();

                                $sql = "SELECT * FROM organizations WHERE id = ?";
                                $stmt = $conn->prepare($sql);
                                $stmt->bind_param("i", $_POST['selection']);
                                $stmt->execute();

                                $result = $stmt->get_result();
                                $selected_org = $result->fetch_assoc();
                                $_SESSION['selected_org'] = $selected_org;
                            }
                    }
                    else
                        {
                            $sql = "UPDATE organizations SET org_name = ?, org_desc = ? WHERE id = ?";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param('ssi', $_POST['name'], $_POST['desc'], $_SESSION['selected_org']['id']);
                            $stmt->execute();

                            $sql = "SELECT * FROM organizations WHERE id = ?";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("i", $_POST['selection']);
                            $stmt->execute();

                            $result = $stmt->get_result();
                            $selected_org = $result->fetch_assoc();
                            $_SESSION['selected_org'] = $selected_org;
                        }
            }

        $selected_org = $_SESSION['selected_org'];
    }

$id_param = $_SESSION['user_id'] ?? 0;

$sql = "SELECT * FROM organizations WHERE owner_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_param);
$stmt->execute();

$result = $stmt->get_result();
$orgs_owned = $result->fetch_all(MYSQLI_ASSOC);
$_SESSION['orgs_owned'] = $orgs_owned;


?>

<style>
  .resize-wrapper {
    display: inline-block;
    resize: horizontal;
    overflow: hidden;
    min-width: 100px;
    max-width: 2000px;
    padding-right: 12px; 
  }

  .resize-wrapper input[type="text"] {
    width: 100%;
    box-sizing: border-box;
  }
</style>



<h1>ORGANIZATION MANAGEMENT</h1>
<h4>You thought you could just... make an organization?! NO. You must MANAGE and UPKEEP it. IMPROVE, friend.</h4>

<?php if (!(isset($selected_org))): ?>
<form action="<?= htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>" method="POST">
    <p>Select an Owned Organization:</p>
    
    <?php foreach ($orgs_owned as $org): ?>
        <?php 
            $org_id = htmlspecialchars($org['id'], ENT_QUOTES, 'UTF-8');
            $org_name = htmlspecialchars($org['org_name'], ENT_QUOTES, 'UTF-8');
        ?>
        <div>
            <input type="radio" id="org_<?= $org_id ?>" name="selection" value="<?= $org_id ?>" required/>
            <label for="org_<?= $org_id ?>"><?= $org_name ?></label>
        </div>
    <?php endforeach; ?>
    
    <button type="submit">Manage Organization</button>
</form>
<?php else: ?>
    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>" method="POST">
        <input type="hidden" name="selectFlag" value="zilch2elecbooglosaowidjeo">
        <button type="submit">Back To Selection</button>
    </form>
<?php endif; ?>

<?php if (isset($selected_org))
{ ?>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>" method="POST" enctype="multipart/form-data">
            <label for="name">Name: </label>
            <input type="text" id="name" name="name" value="<?= $selected_org['org_name']; ?>"required><br>
            <div class="resize-wrapper">
                <label for="desc">Description (max of 256 chars): </label>
                <input type="text" name="desc" value="<?= $selected_org['org_desc']; ?>" required>
            </div><br>
            <img src="<?= $selected_org['logo_file_path'] . $selected_org['logo_file_name']?>" alt="org_logo" width="350" height="350"><br>
            <label for="logo">Update Logo Picture: </label>
            <input type="file" name="logo" id="logo"><br>
            <input type="hidden" name="updateMainFlag" value="arbi">
            <button type="submit" onclick="window.location.href='index.php'">Submit</button>
        </form>

        <iframe src="add-question.php" width="500" height="300" style="border:1px solid #ccc;"></iframe>


    
<?php } ?>