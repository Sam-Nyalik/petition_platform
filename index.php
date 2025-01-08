<!-- URL PAGE ROUTING -->

<?php 

// Start a session
session_start();

// Include functions
include_once "functions/functions.php";

// Make home.php the default homepage instead of index.php
$home = isset($_GET['page']) && file_exists($_GET['page'] . '.php') ? $_GET['page'] : 'home';

// Include and display the requested page
include_once $home . '.php';

?>
