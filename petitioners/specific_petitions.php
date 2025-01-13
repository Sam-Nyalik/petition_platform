<!-- PETITIONERS SPECIFIC PETITIONS -->

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
if (!isset($_SESSION["petitioner_loggedIn"]) && $_SESSION["petitioner_loggedIn"] !== true) {
    // Redirect user to the login page
    header("Location: index.php?page=petitioners/login");
    exit;
} else {
    // Fetch user data from the database
    $user_id = "SELECT * FROM petitioners WHERE id = :userId";
    if($stmt = $database_connection->prepare($user_id)){
        $stmt->bindParam(":userId", $param_user_id, PDO::PARAM_INT);
        $param_user_id = $_SESSION['petitioner_id'];
        if($stmt->execute()){
            if($row = $stmt->fetch()){
                $petitioner_id = $row['id'];
                $petitioner_biometric_id = $row['biometric_id'];
            }
        }
    }
}

// Define variables and assign them empty values
$biometric_id = "";
$biometric_id_error = "";

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
            $petition_signature_threshhold = $row['signature_threshhold'];
            $petition_status = $row['status'];
            $petition_response = $row['petitions_committee_response'];
            $petition_petitioner_id = $row['petitioner_id'];
        }
    }
}

// Process input data when the form has been submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate the biometric id
    if (empty(trim($_POST["biometricId"]))){
        $biometric_id_error = "Field is required!"; 
    } else {
        // Check whether the user has input the correct biometric ID
        if(trim($_POST['biometricId']) !== $petitioner_biometric_id){
            // Don't match
            $biometric_id_error = "Wrong biometric ID";
        } else {
            $biometric_id = trim($_POST["biometricId"]);
        }
    }

    // Check for errors before dealing with the database
    if(empty($biometric_id_error)){
        if($petition_signatures < $petition_signature_threshhold && $petition_status != 0 && $petitioner_id != $petition_petitioner_id){
            // Prepare an UPDATE statement
            $sql_data = "UPDATE all_petitions SET signatures = signatures + 1, petitioner_id = :petitionerId WHERE id = :petition_id";
            if ($stmt = $database_connection->prepare($sql_data)) {
                $stmt->bindParam(":petition_id", $param_petitionId, PDO::PARAM_INT);
                $stmt->bindParam(":petitionerId", $param_petitioner_id, PDO::PARAM_INT);
                $param_petitionId = $petition_id;
                $param_petitioner_id = $petitioner_id;
                // Attempt to execute
                if ($stmt->execute()) {
                    // Redirect user to the all petitions page
                    header("Location: index.php?page=petitioners/all_petitions");
                    exit;
                }
            }
        } else {
            echo "<script>alert('Action could not be completed because of one of the following:The signature threshhold has been met; The petition has been closed; You are trying to vote twice; The administrator has not added the signature threshhold'); </script>";
        }
    }
}

?>

<!-- Header Template -->
<?= header_template('PETITIONERS | SPECIFIC PETITIONS'); ?>

<!-- Navbar template -->
<?= petitioner_navbar_template(); ?>

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
                            if($petition_signatures == NULL){
                                echo "0";
                            } else {
                                echo $petition_signatures;
                            }
                        ?>">
                       </div>

                        <!-- BioID code -->
                         <div class="form-group my-2">
                            <label for="Biometric ID">Biometric ID</label>
                            <input type="text" name="biometricId" class="form-control <?php echo (!empty($biometric_id_error)) ? 'is-invalid' : ''; ?>">
                            <span class="errors text-danger"><?php echo $biometric_id_error; ?></span>
                         </div>

                         <!-- Submit btn -->
                          <div class="form-group my-3">
                            <input type="submit" value="Sign Petition" class="btn w-100">
                          </div>
                </form>
            </div>
        </div>
    </div>
</div>