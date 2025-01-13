<!-- PETITION COMMITTEE OFFICER'S DASHBOARD -->

<?php

// Start session
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if admin is loggedIn or not
if (!isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] !== true) {
    // Redirect to the login page
    header("Location: index.php?page=petitions_committee_officer/login");
    exit;
}

// Include functions
include_once "functions/functions.php";
$database_connection = database_connect();

$admin_name = "";

?>

<!-- Header Template -->
<?= header_template('PETITIONS COMMITTEE OFFICER | DASHBOARD'); ?>

<!-- Admin Navbar -->
<?= admin_navbar_template(); ?>

<!-- Dashboard welcome message -->
<div id="dashboard_message">
    <div class="container">
        <div class="row">
            <h5>Welcome, <?php
                            $sql = "SELECT * FROM admin WHERE emailAddress = :email";
                            if ($stmt = $database_connection->prepare($sql)) {
                                $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
                                $param_email = $_SESSION["emailAddress"];
                                if ($stmt->execute()) {
                                    if ($stmt->rowCount() == 1) {
                                        if ($row = $stmt->fetch()) {
                                            $admin_name = $row['fullName'];
                                        } else {
                                            echo "There is an error!";
                                        }
                                    } else {
                                        echo "There is an error";
                                    }
                                }
                            }
                            ?><span><?php echo $admin_name; ?></span></h5>
        </div>
    </div>
</div>

<!-- Dashboard Cards -->
<div id="dashboard_cards">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h5>BioID Codes</h5>
                <a href="index.php?page=petitions_committee_officer/all_BioID">View</a>
            </div>

            <div class="col-md-4">
                <h5>Petitions</h5>
                <a href="index.php?page=petitions_committee_officer/all_petitions">View</a>
            </div>

            <div class="col-md-4">
                <h5>Petitioners</h5>
                <a href="index.php?page=petitions_committee_officer/all_petitioners">View</a>
            </div>

            <div class="col-md-4">
                <h5>Responses</h5>
                <a href="index.php?page=petitions_committee_officer/all_responses">View</a>
            </div>

            <div class="col-md-4">
                <h5>Petition Results</h5>
                <a href="index.php?page=petitions_committee_officer/petition_results">View More</a>
            </div>
        </div>
    </div>
</div>