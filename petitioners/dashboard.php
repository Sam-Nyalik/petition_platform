<!-- PETITIONER'S DASHBOARD -->

<?php

// Start session
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if admin is loggedIn or not
if (!isset($_SESSION["petitioner_loggedIn"]) && $_SESSION["petitioner_loggedIn"] !== true) {
    // Redirect to the login page
    header("Location: index.php?page=petitioners/login");
    exit;
}

// Include functions
include_once "functions/functions.php";
$database_connection = database_connect();

$petitioner_name = "";

?>

<!-- Header Template -->
<?= header_template('PETITIONERS | DASHBOARD'); ?>

<!-- Admin Navbar -->
<?= petitioner_navbar_template(); ?>

<!-- Dashboard welcome message -->
<div id="dashboard_message">
    <div class="container">
        <div class="row">
            <h5>Welcome, <?php
                            $sql = "SELECT * FROM petitioners WHERE emailAddress = :email";
                            if ($stmt = $database_connection->prepare($sql)) {
                                $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
                                $param_email = $_SESSION["emailAddress"];
                                if ($stmt->execute()) {
                                    if ($stmt->rowCount() == 1) {
                                        if ($row = $stmt->fetch()) {
                                            $petitioner_name = $row['fullName'];
                                        } else {
                                            echo "There is an error!";
                                        }
                                    } else {
                                        echo "There is an error";
                                    }
                                }
                            }
                            ?><span><?php echo $petitioner_name; ?></span></h5>
        </div>
    </div>
</div>

<!-- Dashboard Cards -->
<div id="dashboard_cards">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h5>Petitions</h5>
                <a href="index.php?page=petitioners/all_petitions">View</a>
            </div>

            <div class="col-md-4">
                <h5>Responses</h5>
                <a href="index.php?page=petitioners/all_responses">View</a>
            </div>

            <div class="col-md-4">
                <h5>Petition Results</h5>
                <a href="index.php?page=petitioners/all_results">View</a>
            </div>
        </div>
    </div>
</div>