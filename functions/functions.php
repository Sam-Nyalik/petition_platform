<!-- FUNCTIONS TO BE USED THROUGHOUT THE APPLICATION -->

<?php

// Database connection
function database_connect()
{

    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'root';
    $DATABASE_PASSWORD = '';
    $DATABASE_NAME = 'petition_platform';

    // Try connecting to the database
    try {
        return new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASSWORD);
    } catch (PDOException $message) {
        exit("Failed to connect to the database" . $message->getMessage());
    }
}

// Header Template
function header_template($title)
{
    $element = "
        <!DOCTYPE html>
        <html lang=\"en\">
        <head>
        <title>$title</title>
        <meta charset=\"utf-8\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
        <meta name=\"description\" content=\"This is a platform for citizens of Shangri-La to participate in shaping parliamentary discussions\">
        <meta name=\"keywords\" content=\"PHP, MySQL, JavaScript\">
        <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
        <link rel=\"stylesheet\" type=\"text/css\" href=\"css/bootstrap.min.css\">
        <link rel=\"stylesheet\" type=\"text/css\" href=\"css/styles.css\">
        <script src=\"https://cdn.jsdelivr.net/npm/chart.js\"></script>
        </head>
    ";
    echo $element;
}

// Navigation bar for the Homepage
function homepage_navigation()
{
    $element = "
         <nav class=\"navbar navbar-expand-lg bg-body-tertiary\">
            <div class=\"container-fluid\">
                <a href=\"index.php?page=home\" class=\"navbar-brand mx-auto\">SHANGRI-LA PETITION PLATFORM</a>
        </div>
    </nav>
    ";
    echo $element;
}

// Admin Dashboard Navbar Template
function admin_navbar_template()
{
    $element = "
        <nav class=\"navbar navbar-expand-lg\">
            <div class=\"container-fluid\">
                <a href=\"index.php?page=petitions_committee_officer/dashboard\" class=\"navbar-brand\">SHANGRI-LA PETITION PLATFORM</a>
                <button class=\"navbar-toggler\" type=\"button\" data-bs-toggle=\"collapse\" data-bs-target=\"#navbarSupportedContent\" aria-controls=\"navbarSupportedContent\" aria-expanded=\"false\" aria-label=\"Toggle navigation\">
                    <span class=\"navbar-toggler-icon\"></span>
                </button>
             <div class=\"collapse navbar-collapse justify-content-end\" id=\"navbarSupportedContent\">
                <ul class=\"navbar-nav\">
                    <li class=\"nav-item\">
                        <a class=\"nav-link active\" aria-current=\"page\" href=\"index.php?page=petitions_committee_officer/dashboard\">Dashboard</a>
                    </li>
                   <li class=\"nav-item\">
                        <a class=\"nav-link\" aria-current=\"page\" href=\"index.php?page=petitions_committee_officer/all_petitioners\">Petitioners</a>
                    </li>
                    <li class=\"nav-item\">
                        <a class=\"nav-link\" aria-current=\"page\" href=\"index.php?page=petitions_committee_officer/all_petitions\">Petitions</a>
                    </li>
                    <li class=\"nav-item\">
                        <a class=\"nav-link text-danger\" aria-current=\"page\" href=\"index.php?page=petitions_committee_officer/logout\">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    ";
    echo $element;
}

// Petitioner navbar template
function petitioner_navbar_template()
{
    $element = "
        <nav class=\"navbar navbar-expand-lg\">
            <div class=\"container-fluid\">
                <a href=\"index.php?page=petitioners/dashboard\" class=\"navbar-brand\">SHANGRI-LA PETITION PLATFORM</a>
                <button class=\"navbar-toggler\" type=\"button\" data-bs-toggle=\"collapse\" data-bs-target=\"#navbarSupportedContent\" aria-controls=\"navbarSupportedContent\" aria-expanded=\"false\" aria-label=\"Toggle navigation\">
                    <span class=\"navbar-toggler-icon\"></span>
                </button>
             <div class=\"collapse navbar-collapse justify-content-end\" id=\"navbarSupportedContent\">
                <ul class=\"navbar-nav\">
                    <li class=\"nav-item\">
                        <a class=\"nav-link active\" aria-current=\"page\" href=\"index.php?page=petitioners/dashboard\">Dashboard</a>
                    </li>
                    <li class=\"nav-item\">
                        <a class=\"nav-link\" aria-current=\"page\" href=\"index.php?page=petitioners/all_petitions\">Petitions</a>
                    </li>
                    <li class=\"nav-item\">
                        <a class=\"nav-link text-danger\" aria-current=\"page\" href=\"index.php?page=petitioners/logout\">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    ";
    echo $element;
}
