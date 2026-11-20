<?php
require_once 'config.php';

$organization = null;
$questions = [];

// 1. Search for the organization
if (isset($_POST['org_name'])) {
    $sql = "SELECT * FROM organizations WHERE org_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $_POST['org_name']);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // fetch_assoc() gets a single row directly instead of a nested array
    $organization = $result->fetch_assoc();

    if ($organization) {
        $_SESSION['organization'] = $organization;

        // Prepare the second statement properly
        $sql_q = "SELECT * FROM questions WHERE org_id = ?";
        $stmt_q = $conn->prepare($sql_q);
        $stmt_q->bind_param("i", $organization['id']);
        $stmt_q->execute();
        $questions = $stmt_q->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}

// 2. Join the organization
if (isset($_POST['join']) && isset($_SESSION['organization'], $_SESSION['user_id'])) {
    $sql = "INSERT INTO orgmembers (user_id, org_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $user_param = (int) $_SESSION['user_id'];
    $org_param = (int) $_SESSION['organization']['id'];
    $stmt->bind_param("ii", $user_param, $org_param);
    $stmt->execute();

    unset($_SESSION['organization']);
    
    // Redirect safely in PHP after DB insertion succeeds
    header("Location: index.php");
    exit;
}
?>

<h1>Welcome to joining organizations!</h1>
<p>That silly little account of yours is nothing until it joins an organization. Do dat ere m8, gg no re.</p>

<h3>Target Organization Name</h3>
<form action="<?= htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>" method="POST">
    <label for="org_name">Enter Organization Name: </label>
    <input type="text" id="org_name" name="org_name" required autocomplete="on"><br>
    <button type="submit">Submit</button>
</form>

<?php if ($organization): ?>
    <h2>Selected Organization:</h2>
    <img src="<?= htmlspecialchars($organization['logo_file_path'] . $organization['logo_file_name']) ?>" alt="org_logo" width="350" height="350">
    <h3><?= htmlspecialchars($organization['org_name']) ?></h3>
    <p><?= htmlspecialchars($organization['org_desc']) ?></p>

    <form method="POST">
        <label>Interview Questions</label><br><br>
        <?php foreach ($questions as $q): ?>
            <label for="q_<?= $q['id'] ?>"><?= htmlspecialchars($q['title']) ?></label><br>
            <input type="text" id="q_<?= $q['id'] ?>" name="answers[<?= $q['id'] ?>]" maxlength="<?= (int)$q['max_len'] ?>"><br>
        <?php endforeach; ?>
        
        <input type="hidden" name="join" value="joe zilch">
        <button type="submit">Join Organization</button>
    </form>
<?php elseif (isset($_POST['org_name'])): ?>
    <p>No organization found with that name.</p>
<?php endif; ?>