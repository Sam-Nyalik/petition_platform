<!-- ALL BIOID CODES -->

<?php

// Start session
session_start();

// Error reporting
ini_set('display_errors', 1);

// Check if admin is loggedIn or not
if (!isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] !== true) {
    // Redirect to the login page
    header("Location: index.php?page=petitions_committee_officer/login");
    exit;
}

// Include our functions
include_once "functions/functions.php";
$database_connection = database_connect();

?>

<!-- Header Template -->
<?= header_template('PETITIONS COMMITTEE OFFICER | ALL BIOID CODES'); ?>

<!-- Admin Navbar -->
<?= admin_navbar_template(); ?>

<!-- Page Title -->
<div id="page_title">
    <div class="container">
        <div class="row">
            <h4>All BioID Codes</h4>
        </div>
    </div>
</div>

<!-- Data table -->
<div id="data_table">
    <div class="container">
        <div class="row">
            <table class="table table-bordered">
                <!-- Fetch all codes form the database -->
                 <?php 
                    $sql = $database_connection->prepare("SELECT * FROM bioID ORDER BY date_created DESC");
                    $sql->execute();
                    $database_all_codes = $sql->fetchAll(PDO::FETCH_ASSOC);
                    $count = 1;
                 ?>
                <thead>
                    <th>#</th>
                    <th>Codes</th>
                    <th>Date Added</th>
                    <th>Status</th>
                </thead>

                <?php foreach($database_all_codes as $all_codes): ?>
                <tbody>
                    <td><?= $count++; ?></td>
                    <td><?= $all_codes['unique_code'];?></td>
                    <td><?= $all_codes['date_created']; ?></td>
                    <td><?php 
                        if($all_codes['status'] == 0){
                            echo "<span class='text-success'>Not taken</span>";
                        } else {
                            "<span class='text-danger'>Already Taken</span>";
                        }
                    ?></td>
                </tbody>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>

<!-- Add link -->
<div id="add_link">
    <div class="container">
        <div class="row">
            <a href="index.php?page=petitions_committee_officer/add_BioID" class="w-50 mx-auto">Add Code</a>
        </div>
    </div>
</div>