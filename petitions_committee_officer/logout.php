<!-- PETITIONS COMMITTEE OFFICER LOGOUT SCRIPT -->

<?php 

// Start session
session_start();

// Destroy sessions 
$_SESSION = array();
session_destroy();

// Redirect admin to the login page
header("Location: index.php?page=petitions_committee_officer/login");
exit;