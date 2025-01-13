<!-- PETITIONER'S LOGOUT SCRIPT -->

<?php

// Start session
session_start();

// Destroy sessions 
$_SESSION = array();
session_destroy();

// Redirect admin to the login page
header("Location: index.php?page=petitioners/login");
exit;
