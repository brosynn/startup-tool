<?php
// Ensure session_start() is inside config.php, or uncomment the line below:
// session_start(); 

require_once 'config.php';

$id_param = $_SESSION['user_id'] ?? 0;

$sql = "SELECT * FROM organizations WHERE owner_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_param);
$stmt->execute();

$result = $stmt->get_result();
$orgs_owned = $result->fetch_all(MYSQLI_ASSOC);
$_SESSION['orgs_owned'] = $orgs_owned;



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
        $selected_org = $_SESSION['selected_org'];
    }
?>





<h1>ORGANIZATION MANAGEMENT</h1>
<h4>You thought you could just... make an organization?! NO. You must MANAGE and UPKEEP it. IMPROVE, friend.</h4>

<?php if (!(isset($selected_org))): ?>
<form action="<?= htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>" method="POST">
    <p>Select an Owned Organization:</p>
    
    <?php foreach ($orgs_owned as $org): ?>
        <?php 
            // Safely escape output and create a valid HTML ID
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
    <h1><?= $selected_org['org_name'] ?></h1>
<?php } ?>