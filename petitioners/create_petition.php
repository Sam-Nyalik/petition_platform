<!-- PETITIONERS | CREATE PETITION -->

<?php

// Start sessions
session_start();

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include our functions
include_once "functions/functions.php";
$database_connection = database_connect();

// Check if petitioner is logged in or not
if (!isset($_SESSION["petitioner_loggedIn"]) && $_SESSION["petitioner_loggedIn"] !== true) {
    // Redirect user to the login page
    header("Location: index.php?page=petitioner/login");
    exit;
} else {
    // Fetch petitioner's email from the database
    $user_name = "SELECT * FROM petitioners WHERE id = :userId";
    if ($stmt = $database_connection->prepare($user_name)) {
        // Bind variables to the prepared statement
        $stmt->bindParam(":userId", $param_user_id, PDO::PARAM_INT);
        // Set parameters
        $param_user_id = $_SESSION["petitioner_id"];
        // Attempt to execute
        if ($stmt->execute()) {
            if ($row = $stmt->fetch()) {
                $fullName = $row['emailAddress'];
                $petitionerId = $row['id'];
            }
        }
    }
}

// Define variables and assign them empty values
$petition_title = $petition_content = $biometric_id = "";
$petition_title_error = $petition_content_error = $biometric_id_error = "";

// Process input data when the form s submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate petition title
    if (empty(trim($_POST["petition_title"]))) {
        $petition_title_error = "Field is required!";
    } else {
        $petition_title = trim($_POST["petition_title"]);
    }

    // Validate petition content
    if (empty(trim($_POST["petition_content"]))) {
        $petition_content_error = "Field is required!";
    } else {
        $petition_content = trim($_POST["petition_content"]);
    }

    // Validate biometric id
    if (empty(trim($_POST['biometric_id']))) {
        $biometric_id_error = "Field is required!";
    } else {
        // Ensure the user inputs his/her designated bioID
        $sql = "SELECT biometric_id FROM petitioners WHERE id = :petitioner_id";
        if ($stmt = $database_connection->prepare($sql)) {
            // Bind variables to the prepared statement
            $stmt->bindParam(":petitioner_id", $param_petitioner_id, PDO::PARAM_INT);
            $param_petitioner_id = $_SESSION["petitioner_id"];
            // Attempt to execute
            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    if ($row = $stmt->fetch()) {
                        $code_in_database = $row['biometric_id'];

                        // Compare the input code with the one in the database
                        if (trim($_POST["biometric_id"]) == $code_in_database) {
                            $biometric_id = trim($_POST["biometric_id"]);
                        } else {
                            $biometric_id_error = "Wrong biometric id!";
                        }
                    }
                }
            }

            unset($stmt);
        }
    }

    // Check for errors before dealing with the database
    if (empty($petition_title_error) && empty($petition_content_error) && empty($biometric_id_error)) {
        // Prepare an INSERT statement
        $sql = "INSERT INTO all_petitions(title, content, author, status, petitioner_id) VALUE(:title, :content, :author, :status, :petitioner_id)";
        if ($stmt = $database_connection->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":title", $param_title, PDO::PARAM_STR);
            $stmt->bindParam(":content", $param_content, PDO::PARAM_STR);
            $stmt->bindParam(":author", $param_author, PDO::PARAM_STR);
            $stmt->bindParam(":status", $param_status, PDO::PARAM_INT);
            $stmt->bindParam(":petitioner_id", $param_petitionerId, PDO::PARAM_INT);
            // Set parameters
            $param_title = $petition_title;
            $param_content = $petition_content;
            $param_author = $fullName;
            $param_status = 1;
            $param_petitionerId = 0;

            // Attempt to execute
            if ($stmt->execute()) {
                // redirect to the all_petitions page
                header("Location: index.php?page=petitioners/all_petitions");
                exit;
            }
        }
    }
}

?>

<!-- Header Template -->
<?= header_template('PETTIONER | CREATE PETITION'); ?>

<!-- Petitioner Navbar -->
<?= petitioner_navbar_template(); ?>

<!-- Page Title -->
<div id="page_title">
    <div class="container">
        <div class="row">
            <h4>Create a petition</h4>
        </div>
    </div>
</div>

<!-- Add Form -->
<div id="login_page">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <h2>Create a petition</h2>
                <hr>

                <form action="#" method="POST" class="login_form">
                    <!-- Title -->
                    <div class="form-group my-2">
                        <label for="Petition Title">Petition Title</label>
                        <input type="text" name="petition_title" class="form-control <?php echo (!empty($petition_title_error)) ? 'is-invalid' : ''; ?>">
                        <span class="errors text-danger"><?php echo $petition_title_error; ?></span>
                    </div>

                    <!-- Content -->
                    <div class="form-group my-2">
                        <label for="Petition Content">Content</label>
                        <textarea name="petition_content" class="form-control <?php echo (!empty($petition_content_error)) ? 'is-invalid' : ''; ?>"></textarea>
                        <span class="errors text-danger"><?php echo $petition_content_error; ?></span>
                    </div>

                    <!-- Biometric ID confirmation -->
                    <div class="form-group my-2">
                        <label for="Biometric ID">Unique Code</label>
                        <input type="text" name="biometric_id" class="form-control <?php echo (!empty($biometric_id_error)) ? 'is-invalid' : ''; ?>">
                        <span class="errors text-danger"><?php echo $biometric_id_error; ?></span>
                    </div>

                    <!-- Submit btn -->
                    <div class="form-group my-3">
                        <input type="submit" value="Create Petition" class="btn w-100">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>