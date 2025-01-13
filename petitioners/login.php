<!-- PETITIONER'S LOGIN PAGE -->

<?php

// Start session
session_start();

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// include our functions
include_once "functions/functions.php";
$database_connection = database_connect();

// Define variables and assign empty values
$emailAddress = $password = "";
$emailAddress_error = $password_error = "";

// Process input data when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate emailAddress
    if (empty(trim($_POST["emailAddress"]))) {
        $emailAddress_error = "Field is required!";
    } else {
        $emailAddress = trim($_POST["emailAddress"]);
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_error = "Field is required!";
    } else {
        $password = trim($_POST["password"]);
    }

    // Check for errors before dealing with the database
    if (empty($emailAddress_error) && empty($password_error)) {
        // Prepare a SELECT statement
        $sql = "SELECT id, emailAddress, password FROM petitioners WHERE emailAddress = :email";

        if ($stmt = $database_connection->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":email", $param_emailAddress, PDO::PARAM_STR);
            // Set parameters
            $param_emailAddress = $emailAddress;
            // Attempt to execute
            if ($stmt->execute()) {
                // Check if the user exists
                if ($stmt->rowCount() == 1) {
                    // User exists
                    if ($row = $stmt->fetch()) {
                        $id = $row['id'];
                        $fullName = $row['fullName'];
                        $emailAddress = $row['emailAddress'];
                        $hashed_password = $row['password'];

                        // Verify the input password with the one in the database
                        if (password_verify($password, $hashed_password)) {
                            // Both passwords match
                            session_start();

                            // Store data in session variables
                            $_SESSION["petitioner_id"] = $id;
                            $_SESSION["petitioner_loggedIn"] = true;
                            $_SESSION["emailAddress"] = $emailAddress;
                            $_SESSION["fullName"] = $fullName;

                            // Redirect admin to the dashboard
                            header("Location: index.php?page=petitioners/dashboard");
                            exit;
                        } else {
                            $password_error = "Wrong password";
                        }
                    }
                } else {
                    $emailAddress_error = "User does not exist in our database";
                }
            } else {
                echo "There was an error, please try again!";
            }
        }

        // Unset the prepared statement
        unset($stmt);
    }
}

?>

<!-- Header Template -->
<?= header_template('PETITIONER | LOGIN'); ?>

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
                <h2>Petitioner's Login</h2>
                <hr>

                <form action="#" method="POST" class="login_form">
                    <!-- Email Address -->
                    <div class="form-group my-2">
                        <label for="EmailAddress">Email Address</label>
                        <input type="email" name="emailAddress" class="form-control <?php echo (!empty($emailAddress_error)) ? 'is-invalid' : ''; ?>" value="<?php echo $emailAddress; ?>">
                        <span class="errors text-danger"><?php echo $emailAddress_error; ?></span>
                    </div>

                    <!-- Password -->
                    <div class="form-group my-2">
                        <label for="Password">Password</label>
                        <input type="password" name="password" class="form-control <?php echo (!empty($password_error)) ? 'is-invalid' : ''; ?>">
                        <span class="errors text-danger"><?php echo $password_error; ?></span>
                    </div>

                    <!-- Registration page link -->
                    <div class="form-group my-2">
                        <p>Don't have an account? <a href="index.php?page=petitioners/register">Register</a> </p>
                    </div>

                    <!-- Submit button -->
                    <div class="form-group my-3">
                        <input type="submit" value="Login" class="btn w-100">
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