<!-- ADD BIOID SCRIPT -->

<?php

// Start session
session_start();

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if admin is loggedIn
if (!isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] !== true) {
    // Redirect admin to the login page
    header("Location: index.php?page=petitions_committee_officer/login");
    exit;
}

// Include our functions
include_once "functions/functions.php";
$database_connection = database_connect();

// Define variables and assign them empty values
$code = "";
$code_error = "";

// Process forminput data when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate code input
    if (empty(trim($_POST["code"]))) {
        $code_error = "field is required!";
    } else {
        // check if the code already exists in the database
        $sql = "SELECT * FROM bioID WHERE unique_code = :bioID";
        if ($stmt = $database_connection->prepare($sql)) {
            // Bind variables to the prepared statement
            $stmt->bindParam(":bioID", $param_bioID, PDO::PARAM_STR);
            $param_bioID = trim($_POST["code"]);
            if ($stmt->execute()) {
                if ($stmt->rowCount() > 0) {
                    // Code exists, therefore generate an error
                    $code_error = "Code already exists!";
                } else {
                    $code = trim($_POST["code"]);
                }
            }

            unset($stmt);
        }
    }

    // Check for errors before dealing with the database
    if (empty($code_error)) {
        // Prepare an INSERT statement
        $sql = "INSERT INTO bioID(unique_code) VALUES(:bio_id)";
        if ($stmt = $database_connection->prepare($sql)) {
            // Bind variables to the prepared statement 
            $stmt->bindParam(":bio_id", $param_bio_id, PDO::PARAM_STR);
            $param_bio_id = $code;
            if ($stmt->execute()) {
                // Redirect admin to the allBIOD page
                header("Location: index.php?page=petitions_committee_officer/all_BioID");
                exit;
            }
        }
    }
}

?>

<!-- Header Template -->
<?= header_template('PETITIONS COMMITTEE OFFICER | ADD BIOID'); ?>

<!-- Admin Navbar -->
<?= admin_navbar_template(); ?>

<!-- Page Title -->
<div id="page_title">
    <div class="container">
        <div class="row">
            <h4>Add BioID Code</h4>
        </div>
    </div>
</div>

<!-- Add Form -->
<div id="login_page">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <h2>Add BioID Code</h2>
                <hr>

                <form action="#" method="POST" class="login_form">
                    <!-- Code -->
                    <div class="form-group my-2">
                        <label for="Enter Code">Enter Code</label>
                        <input type="text" name="code" class="form-control <?php echo (!empty($code_error)) ? 'is-invalid' : ''; ?>">
                        <span class="errors text-danger"><?php echo $code_error; ?></span>
                    </div>

                    <!-- Submit btn -->
                    <div class="form-group my-3">
                        <input type="submit" value="Add Code" class="btn w-100">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>