<!-- HOMEPAGE(DEFAULT PAGE) -->

<?php

// Start session
session_start();

// Include our functions
include_once "functions/functions.php";
$database_connection = database_connect();

?>

<!-- Header Template -->
<?= header_template('HOMEPAGE'); ?>

<!-- Homepage Navigation -->
<?= homepage_navigation(); ?>

<!-- Welcome message -->
<div id="welcome_message">
    <div class="container">
        <div class="row">
            <h2>Welcome to our online petition platform</h2>
        </div>
    </div>
</div>

<!-- Accounts -->
<div id="homepage_accounts">
    <div class="container">
        <div class="row">
            <!-- Petitioner Account -->
            <div class="col-md-6">
                <div class="title">
                    <h5>Petitioner Account</h5>
                </div>
                <span><a href="index.php?page=petitioners/login">Login</a></span>
            </div>

            <!-- Petitions Committee Officer -->
            <div class="col-md-6">
                <div class="title">
                    <h5>Petitions Committee Officer</h5>
                </div>
                <span><a href="index.php?page=petitions_committee_officer/login">Login</a></span>
            </div>
        </div>
    </div>
</div>