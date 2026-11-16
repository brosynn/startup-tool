<?php
require_once 'config.php';
// Make sure session is started at the very top of your script
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Handle Organization Selection (Stage 1)
if (isset($_POST['org_name'])) {
    $sql = "SELECT * FROM organizations WHERE org_name = ?";
    $stmt = $conn->prepare($sql);
    $id_param = $_POST['org_name'];
    $stmt->bind_param('s', $id_param);
    $stmt->execute();
    $result = $stmt->get_result();
    $organization = $result->fetch_all(MYSQLI_ASSOC);
    
    $_SESSION['organization'] = $organization;
} else {
    $organization = $_SESSION['organization'] ?? null;
}

// 2. Handle User Selection (Stage 2)
if (isset($_POST['owner_name'])) {
    $sql = "SELECT * FROM users WHERE user = ?";
    $stmt = $conn->prepare($sql);
    $id_param = $_POST['owner_name'];
    $stmt->bind_param('s', $id_param);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_all(MYSQLI_ASSOC); // Assuming you fetch user similarly
    
    $_SESSION['selectedUser'] = $user;
} else {
    $user = $_SESSION['selectedUser'] ?? null;
}

// 3. Handle Final Action: Set Owner (Stage 3 - Triggered by a submit button e.g., $_POST['set_owner'])
if (isset($_POST['set_owner']) && !empty($_SESSION['organization']) && !empty($_SESSION['selectedUser'])) {
    $owner_id = $_SESSION['selectedUser'][0]['id'];
    $org_name = $_SESSION['organization'][0]['org_name'];

    $sql = "UPDATE organizations SET owner_id = ? WHERE org_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('is', $owner_id, $org_name);
    $stmt->execute();

    // Clear staged session data after completion
    unset($_SESSION['organization']);
    unset($_SESSION['selectedUser']);

    // Refresh the page
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

if (isset($_POST['reset_process'])) {
    unset($_SESSION['organization']);
    unset($_SESSION['selectedUser']);
    header("Location: " . $_SERVER['PHP_SELF']);
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

<?php if (isset($user)) { ?>
        <h2>Selected User: <?= htmlspecialchars($user[0]['first_name'] . " " . $user[0]['last_name'], ENT_QUOTES, 'UTF-8') ?></h2>

        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8') ?>" method="POST">
            <label for="reset_process">ru rdy bro</label>
            
            <!-- 1. Add a 'name' attribute and echo your PHP variable into 'value' -->
            <input type="hidden" name="reset_process" value="<?= htmlspecialchars(true, ENT_QUOTES, 'UTF-8') ?>">
            <input type="hidden" name="set_owner" value="<?= htmlspecialchars(true, ENT_QUOTES, 'UTF-8') ?>">
            
            <!-- 2. Remove the onclick redirect so the POST request actually submits -->
            <input type="submit" id="reset_process" value="Submit">
        </form>
        <?php }; ?>
    <?php }; ?>
