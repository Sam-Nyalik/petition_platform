<!-- PETITIONS COMMITTEE OFFICER SPECIFIC PETITIONS -->

<?php

// Start session
session_start();

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include our functions
include_once "functions/functions.php";
$database_connection = database_connect();

// Check if user is logged in or not
if (!isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] !== true) {
    // Redirect user to the login page
    header("Location: index.php?page=petitions_committee_officer/login");
    exit;
} 

// Define variables and assign them empty values
$response = "";
$response_error = "";

// Fetch petition data from the database based on the id in the URL
$petition_id = false;
if (isset($_GET['id'])) {
    $petition_id = $_GET['id'];
}

$sql = "SELECT * FROM all_petitions WHERE id = :petition_id";
if ($stmt = $database_connection->prepare($sql)) {
    $stmt->bindParam(":petition_id", $param_petition_id, PDO::PARAM_INT);
    $param_petition_id = $petition_id;
    if ($stmt->execute()) {
        if ($row = $stmt->fetch()) {
            $petition_title = $row['title'];
            $petition_author = $row['author'];
            $petition_content = $row['content'];
            $petition_signatures = $row['signatures'];
            $petition_response = $row['petitions_committee_response'];
        }
    }
}

// Process input data when the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate the biometric id
    if (empty(trim($_POST["response"]))) {
        $response_error = "Field is required!";
    } else {
        $response = trim($_POST['response']);
    }

    // Check for errors before dealing with the database
    if (empty($response_error)) {
        // Prepare an UPDATE statement
        $sql_data = "UPDATE all_petitions SET status = 0, petitions_committee_response = :response WHERE id = :petition_id";
        if ($stmt = $database_connection->prepare($sql_data)) {
            $stmt->bindParam(":response", $param_response, PDO::PARAM_STR);
            $stmt->bindParam(":petition_id", $param_petitionId, PDO::PARAM_INT);
            $param_response = $response;
            $param_petitionId = $petition_id;
            // Attempt to execute
            if ($stmt->execute()) {
                // Redirect user to the all petitions page
                header("Location: index.php?page=petitions_committee_officer/all_petitions");
                exit;
            }
        }
    }
}

?>

<!-- Header Template -->
<?= header_template('PETITIONS COMMITTEE OFFICER | SPECIFIC PETITIONS'); ?>

<!-- Navbar template -->
<?= admin_navbar_template(); ?>

<!-- Page title -->
<div id="page_title">
    <div class="container">
        <div class="row">
            <h4>Petition Details</h4>
        </div>
    </div>
</div>

<!-- Petition's data -->
<div id="login_page">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <h2>"<?php echo $petition_title; ?>" petition</h2>
                <hr>

                <form action="#" method="POST" class="login_form">
                    <!-- Title -->
                    <div class="form-group my-2">
                        <label for="Petition Title">Petition Title</label>
                        <input type="text" name="title" readonly class="form-control" value="<?php echo $petition_title; ?>">
                    </div>

                    <!-- Author -->
                    <div class="form-group my-2">
                        <label for="Author">Petition Author</label>
                        <input type="text" name="author" readonly class="form-control" value="<?php echo $petition_author; ?>">
                    </div>

                    <!-- Content -->
                    <div class="form-group my-2">
                        <label for="Content">Petition Content</label>
                        <textarea name="content" readonly class="form-control"><?php echo $petition_content; ?></textarea>
                    </div>

                    <!-- Signatures -->
                    <div class="form-group my-2">
                        <label for="Signatures">Total Signatures</label>
                        <input type="text" name="signatures" readonly class="form-control" value="<?php
                                                                                                    if ($petition_signatures == NULL) {
                                                                                                        echo "0";
                                                                                                    } else {
                                                                                                        echo $petition_signatures;
                                                                                                    }
                                                                                                    ?>">
                    </div>

                    <!-- Response code -->
                    <div class="form-group my-2">
                        <label for="Respond">Respond</label>
                       <textarea name="response" class="form-control <?php echo (!empty($response_error)) ? 'is-invalid' : ''; ?>"></textarea>
                        <span class="errors text-danger"><?php echo $response_error; ?></span>
                    </div>

                    <!-- Submit btn -->
                    <div class="form-group my-3">
                        <input type="submit" value="Add a response" class="btn w-100">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>