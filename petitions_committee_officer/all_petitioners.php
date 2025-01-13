<!-- VIEW ALL PETITIONERS -->

<?php

// Start session
session_start();

// Error reporting
ini_set('display_errors', 1);

// Check if admin is logged in or not
if (!isset($_SESSION['loggedIn']) && $_SESSION["loggedIn"] !== true) {
    // redirect admin to the login page
    header("Location: index.php?page=petitions_committee_officer/login");
    exit;
}

// Include our functions
include_once "functions/functions.php";
$database_connection = database_connect();

?>

<!-- Header template -->
<?= header_template('PETITIONS COMMITTEE OFFICER | ALL PETITIONERS'); ?>

<!-- Admin Navbar -->
<?= admin_navbar_template(); ?>

<!-- Page Title -->
<div id="page_title">
    <div class="container">
        <div class="row">
            <h4>All Petitioners</h4>
        </div>
    </div>
</div>

<!-- Data table -->
<div id="data_table">
    <div class="container">
        <div class="row">
            <table class="table table-bordered">
                <!-- Fetch all petitioners form the database -->
                <?php
                $sql = $database_connection->prepare("SELECT * FROM petitioners ORDER BY date_created DESC");
                $sql->execute();
                $database_all_petitioners = $sql->fetchAll(PDO::FETCH_ASSOC);
                $count = 1;
                ?>
                <thead>
                    <th>#</th>
                    <th>FullName</th>
                    <th>Email Address</th>
                    <th>Date Added</th>
                </thead>

                <?php foreach ($database_all_petitioners as $all_petitioners): ?>
                    <tbody>
                        <td><?= $count++; ?></td>
                        <td><?= $all_petitioners['fullName']; ?></td>
                        <td><?= $all_petitioners['emailAddress']; ?></td>
                        <td><?= $all_petitioners['date_created']; ?></td>
                    </tbody>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>