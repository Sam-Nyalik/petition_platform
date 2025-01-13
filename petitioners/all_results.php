<!-- PETITIONERS | ALL RESULTS -->

<?php

// Start session
session_start();

// Check if the admin is loggedin or not
if (!isset($_SESSION["petitioner_loggedIn"]) && $_SESSION["petitioner_loggedIn"] !== true) {
    // Redirect to the login page
    header("Location: index.php?page=petitioners/login");
    exit;
}

// Include functions
include_once "functions/functions.php";
$database_connection = database_connect();

// Fetch petition details from the database
$sql = $database_connection->prepare("SELECT * FROM all_petitions WHERE status = 0");
$sql->execute();
$database_all_petitions = $sql->fetchAll(PDO::FETCH_ASSOC);

?>

<!-- Header template -->
<?= header_template('PETITIONER | ALL RESULTS'); ?>

<!-- Admin navbar -->
<?= petitioner_navbar_template(); ?>

<!-- Page Title -->
<div id="page_title">
    <div class="container">
        <div class="row">
            <h4>Petition Results</h4>
        </div>
    </div>
</div>

<!-- Chart Js -->
<div class="container text-center">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <canvas id="petitionChart" width="600" height="400" style="margin-bottom:45px;"></canvas>
        </div>
    </div>
</div>

<script>
    var csx = document.getElementById("petitionChart").getContext('2d');

    var data = <?php echo json_encode($database_all_petitions); ?>;

    var labels = data.map(function(item) {
        return item.title;
    });

    var values = data.map(function(item) {
        return item.signatures;
    });

    var colors = [
        'rgba(255, 99, 132, 0.7)',
        'rgba(54, 162, 235, 0.7)',
        'rgba(255, 206, 86, 0.7)',
        'rgba(75, 192, 192, 0.7)',
        'rgba(255, 99, 132, 0.7)',
        'rgba(54, 162, 235, 0.7)',
        'rgba(255, 206, 86, 0.7)',
        'rgba(75, 192, 192, 0.7)',
        'rgba(255, 99, 132, 0.7)',
        'rgba(54, 162, 235, 0.7)',
        'rgba(255, 206, 86, 0.7)',
        'rgba(75, 192, 192, 0.7)',
    ]

    var charData = {
        labels: labels,
        datasets: [{
            label: 'Number of signatures',
            data: values,
            backgroundColor: colors,
            borderColor: '#094d4d',
            borderWidth: 1
        }]
    };

    var options = {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    };

    var myChart = new Chart(csx, {
        type: 'bar',
        data: charData,
        options: options
    });
</script>