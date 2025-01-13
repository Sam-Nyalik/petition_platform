<!-- PETITIONERS - ALL RESPONSES -->

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
            <h4>All Responses</h4>
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
                    <th>Petition Author</th>
                    <th>Petition Content</th>
                    <th>Date Added</th>
                    <th>Status</th>
                    <th>Petition Committee Response</th>
                </thead>

                <?php foreach ($database_all_petitions as $all_petitions): ?>
                    <tbody>
                        <td><?= $count++; ?></td>
                        <td><?= $all_petitions['title']; ?></td>
                        <td><?= $all_petitions['author']; ?></td>
                        <td><?= $all_petitions['content']; ?></td>
                        <td><?= $all_petitions['date_created']; ?></td>
                        <td><?php
                            if ($all_petitions['status'] == 0) {
                                echo "<span class='text-danger'>Closed</span>";
                            } else {
                                echo "<span class='text-success'>Open</span>";
                            }
                            ?></td>
                            <td><?= $all_petitions['petitions_committee_response']; ?></td>
                    </tbody>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>
