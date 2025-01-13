<!-- PETITIONERS - ALL PETITIONS -->

<?php

// Start session
session_start();

// Error reporting
ini_set('display_errors', 1);

// Check if petitioner is loggedIn or not
if (!isset($_SESSION["petitioner_loggedIn"]) && $_SESSION["petitioner_loggedIn"] !== true) {
    // Redirect to the login page
    header("Location: index.php?page=petitioners/login");
    exit;
}

// Include our functions
include_once "functions/functions.php";
$database_connection = database_connect();

?>

<!-- Header Template -->
<?= header_template('PETITIONERS | ALL PETITIONS'); ?>

<!-- Admin Navbar -->
<?= petitioner_navbar_template(); ?>

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
                    <th>Petition Title</th>
                    <th>Petitioner Email</th>
                    <th>Date Added</th>
                    <th>Status</th>
                    <th>No. of signatures</th>
                    <th>Signature threshhold</th>
                    <th>Action</th>
                </thead>

                <?php foreach ($database_all_petitions as $all_petitions): ?>
                    <tbody>
                        <td><?= $count++; ?></td>
                        <td><?= $all_petitions['title']; ?></td>
                        <td><?= $all_petitions['author']; ?></td>
                        <td><?= $all_petitions['date_created']; ?></td>
                        <td><?php
                            if ($all_petitions['status'] == 0) {
                                echo "<span class='text-danger'>Closed</span>";
                            } else {
                                echo "<span class='text-success'>Open</span>";
                            }
                            ?></td>
                        <td><?= $all_petitions['signatures']; ?></td>
                        <td><?= $all_petitions['signature_threshhold']; ?></td>
                        <td>
                            <?php
                            if ($all_petitions['signatures'] <= $all_petitions['signature_threshhold']) {
                            ?>
                                <a href="index.php?page=petitioners/specific_petitions&id=<?= $all_petitions['id']; ?>">View More</a>
                            <?php } else {
                                echo "<span class='text-danger'>Signature threshhold has been met</span>";
                            }
                            ?>
                        </td>
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
            <a href="index.php?page=petitioners/create_petition" class="w-50 mx-auto">Create Petition</a>
        </div>
    </div>
</div>