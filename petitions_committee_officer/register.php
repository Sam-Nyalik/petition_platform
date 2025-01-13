<!-- PETITIONS COMMITTEE OFFICER LOGIN PAGE -->

<?php

// Start session
session_start();

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// include our functions
include_once "functions/functions.php";
$database_connection = database_connect();

// Define variables and assign them empty values
$fullName = $emailAddress = $password = $confirmPassword = "";
$fullName_error = $emailAddress_error = $password_error = $confirmPassword_error = "";

// Process form data when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    // Validate fullname
    if (empty(trim($_POST['fullName']))) {
        $fullName_error = "Field is required!";
    } else {
        $fullName = trim($_POST["fullName"]);
    }

    // Validate emailAddress
    if (empty(trim($_POST['emailAddress']))) {
        $emailAddress_error = "Field is required!";
    } else {
        // Check if the input email address already exists in the database
        $sql = "SELECT * FROM admin WHERE emailAddress = :email_address";
        if ($stmt = $database_connection->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":email_address", $param_emailAddress, PDO::PARAM_STR);
            // Set parameters
            $param_emailAddress = trim($_POST["emailAddress"]);
            // Attempt to execute
            if ($stmt->execute()) {
                if ($stmt->rowCount() > 0) {
                    // Email address already exists. Generate an error
                    $emailAddress_error = "This email address is already taken!";
                } else {
                    $emailAddress = trim($_POST['emailAddress']);
                }
            }
        }
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_error = "Field is required!";
    } else if (strlen(trim($_POST["password"])) < 6) {
        $password_error = "Passwords must contain more than 6 characters!";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confirmPassword
    if (empty(trim($_POST["confirmPassword"]))) {
        $confirmPassword_error = "Field is required!";
    } else {
        $confirmPassword = trim($_POST["confirmPassword"]);

        // Check if both the password and confirmPassword match
        if (empty($password_error) && $password !== $confirmPassword) {
            $confirmPassword_error = "Passwords do not match!";
        }
    }

    // Check for errors before dealing with the database
    if(empty($fullName_error) && empty($emailAddress_error) && empty($password_error) && empty($confirmPassword_error)){
        // Prepare an INSERT statement
        $sql = "INSERT INTO admin(fullName, emailAddress, password) VALUES(:fullName, :emailAddress, :password)";
        if($stmt = $database_connection->prepare($sql)){
            // Bind variables to the prepared statement
            $stmt->bindParam(":fullName", $param_fullName, PDO::PARAM_STR);
            $stmt->bindParam(":emailAddress", $param_emailAddress, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
            // Set parameters
            $param_fullName = $fullName;
            $param_emailAddress = $emailAddress;
            $param_password = password_hash($password, PASSWORD_DEFAULT);

            // Attempt to execute
            if($stmt->execute()){
                // Redirect user to the login page
                header("Location: index.php?page=petitions_committee_officer/login");
                exit;
            }
        }
    }
}

?>

<!-- Header Template -->
<?= header_template('PETITIONS COMMITTEE OFFICER | REGISTRATION'); ?>

<!-- Navbar -->
<?= homepage_navigation(); ?>

<!-- Back button -->
<div id="back_button">
    <div class="container">
        <div class="row">
            <span onclick="goBack()"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-circle" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z" />
                </svg> back</span>
        </div>
    </div>
</div>

<!-- Login Form -->
<div id="login_page">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <h2>Petitions Committee Officer Register</h2>
                <hr>

                <form action="#" method="POST" class="login_form">
                    <!-- FullName -->
                    <div class="form-group my-2">
                        <label for="FullName">Fullname</label>
                        <input type="text" name="fullName" class="form-control <?php echo (!empty($fullName_error)) ? 'is-invalid' : ''; ?>">
                        <span class="errors text-danger"><?php echo $fullName_error; ?></span>
                    </div>
                    <!-- Email Address -->
                    <div class="form-group my-2">
                        <label for="EmailAddress">Email Address</label>
                        <input type="email" name="emailAddress" class="form-control <?php echo (!empty($emailAddress_error)) ? 'is-invalid' : ''; ?>">
                        <span class="errors text-danger"><?php echo $emailAddress_error; ?></span>
                    </div>

                    <div class="row">
                        <!-- Password -->
                        <div class="col-6">
                            <div class="form-group my-2">
                                <label for="Password">Password</label>
                                <input type="password" name="password" class="form-control <?php echo (!empty($password_error)) ? 'is-invalid' : ''; ?>">
                                <span class="errors text-danger"><?php echo $password_error; ?></span>
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="col-6">
                            <div class="form-group my-2">
                                <label for="confirmPassword">Confirm Password</label>
                                <input type="password" name="confirmPassword" class="form-control <?php echo (!empty($confirmPassword_error)) ? 'is-invalid' : ''; ?>">
                                <span class="errors text-danger"><?php echo $confirmPassword_error; ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Submit button -->
                    <div class="form-group my-3">
                        <input type="submit" value="Register" class="btn w-100">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    function goBack() {
        window.history.back();
    }
</script>