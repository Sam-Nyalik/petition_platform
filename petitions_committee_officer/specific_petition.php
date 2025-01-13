<!-- SPECIFIC PETITION -->

<?php

// Start session
session_start();

// Error reporting
error_reporting(E_ALL);
ini_set('dsiplay_errors', 1);

// check if the admin is loggedIn or not
if (!isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] !== true) {
    // Redirect admin to the login page
    header("Location: index.php?page=petitions_committee_officer/login");
    exit;
}

// Include our functions
include_once "functions/functions.php";
$database_connection = database_connect();

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

// Define variables and assign them empty values
$signature_threshhold ="";
$signature_threshhold_error = "";

// Process input data when the form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate signature threshhold
    if(empty(trim($_POST["signature_threshhold"]))){
        $signature_threshhold_error = "Field is required!";
    } else {
        $signature_threshhold = trim($_POST['signature_threshhold']);
    }

    // Check for errors before dealing with the database
    if(empty($signature_threshhold_error)){
        // Prepare an UPDATE statement
        $sql = "UPDATE all_petitions SET signature_threshhold = :signature_threshhold WHERE id = :petitionId";
        if($stmt = $database_connection->prepare($sql)){
            $stmt->bindParam(":petitionId", $param_petitionId, PDO::PARAM_INT);
            $stmt->bindParam(":signature_threshhold", $param_signature_threshhold, PDO::PARAM_INT);
            $param_petitionId = $petition_id;
            $param_signature_threshhold = $signature_threshhold;
            // Attempt to execute
            if($stmt->execute()){
                // redirect to the all_petitions page
                header("Location: index.php?page=petitions_committee_officer/all_responses");
                exit;
            }
        }
    }
}


?>

<!-- Header Template -->
<?= header_template('PETITIONS COMMITEE OFFICER | SPECIFIC PETITION'); ?>

<!-- Admin navbar -->
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

                    <!-- Signature threshold -->
                     <div class="form-group my-2">
                        <label for="Signature threshhold">Set signature threshhold</label>
                        <input type="text" name="signature_threshhold" class="form-control <?php echo (!empty($signature_threshhold_error)) ? 'is-invalid' : ''; ?>">
                        <span class="errors text-danger"><?php echo $signature_threshhold_error; ?></span>
                     </div>

                    <!-- Submit btn -->
                    <div class="form-group my-3">
                        <input type="submit" value="Add Signature Threshhold" class="btn w-100">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>