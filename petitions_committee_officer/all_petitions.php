<!-- ALL PETETIONS -->

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
<?= header_template('PETITIONS COMMITTEE OFFICER | ALL PETITIONS'); ?>

<!-- Admin Navbar -->
<?= admin_navbar_template(); ?>

<!-- Page Title -->
<div id="page_title">
    <div class="container">
        <div class="row">
            <h4>All Petitions</h4>
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
                $sql = $database_connection->prepare("SELECT * FROM all_petitions ORDER BY date_created DESC");
                $sql->execute();
                $database_all_petitions = $sql->fetchAll(PDO::FETCH_ASSOC);
                $count = 1;
                ?>
                <thead>
                    <th>#</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Number of signatures</th>
                    <th>Signature threshhold</th>
                    <th>Date Published</th>
                    <th>Status</th>
                    <th>Petitions officer response</th>
                    <th>Action</th>
                </thead>

                <?php foreach ($database_all_petitions as $all_petitions): ?>
                    <tbody>
                        <td><?= $count++; ?></td>
                        <td><?= $all_petitions['title']; ?></td>
                        <td><?= $all_petitions['author']; ?></td>
                        <td><?php
                            if ($all_petitions['signatures'] == NULL) {
                                echo "0";
                            } else {
                                echo $all_petitions['signatures'];
                            }
                            ?></td>
                            <td><?= $all_petitions['signature_threshhold']; ?></td>
                        <td><?= $all_petitions['date_created']; ?></td>
                        <td><?php
                            if($all_petitions['status'] == 0){
                                echo "<span class='text-danger'>Closed</span>";
                            } else {
                                echo "<span class='text-success'>Open</span>";
                            }
                        ?></td>
                        <td><?php 
                            if($all_petitions['petitions_committee_response'] == NULL ){
                                echo "<span class='text-warning'>No response given</span>";
                            } else {
                                echo $all_petitions['petitions_committee_response']; 
                            }
                        ?></td>
                        <td><a href="index.php?page=petitions_committee_officer/specific_petition&id=<?= $all_petitions['id']; ?>">Set signature threshhold</a></td>
                    </tbody>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>