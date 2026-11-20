<?php 
require_once 'config.php';

if (isset($_SESSION['selected_org'])) 
    {
        $selected_org = $_SESSION['selected_org'];
    }


?>

<h2>Create an interview question!</h2>
<p>When someone wants to join your organization, im sure you have some questions you'd like to ask. Add questions to appear when people send a join request here!</p>

<?php 
if (isset($selected_org)) 
    { ?>
        <img src="<?= $selected_org['logo_file_path'] . $selected_org['logo_file_name']?>" alt="org_logo" width="350" height="350">
        <h3><?= $selected_org['org_name'] ?></h3>
        <p><?= $selected_org['org_desc'] ?></p>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>" method="POST">
            <label for="title">Question Title:</label>
            <input type="text" name="title"><br>
            <label for="limit">Response Character Limit:</label>
            <input type="range" min="3" max="500" name="limit" step="1" oninput="this.nextElementSibling.value = this.value">
            <output>250</output><br>
            <button type="submit">Submit</button>
        </form>
    
    
    <?php } ?>