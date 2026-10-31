<?php
session_start();
require_once "../config/database.php";
require_once "../includes/auth_check.php";

requireRole('admin');

$users = $conn->query("SELECT COUNT(*) AS total FROM users")->fetch_assoc()['total'];
$jobs = $conn->query("SELECT COUNT(*) AS total FROM jobs")->fetch_assoc()['total'];
$companies = $conn->query("SELECT COUNT(*) AS total FROM companies")->fetch_assoc()['total'];
$applications = $conn->query("SELECT COUNT(*) AS total FROM applications")->fetch_assoc()['total'];

require_once "../includes/header.php";
require_once "../includes/navbar.php";
?>

<div class="container mt-5 bg-dark text-white shadow rounded" style="margin-bottom: 30px; padding: 40px;" >

    <h2 style="color: #d8b90a;">Admin Dashboard</h2>
     <div class="mt-4">
        <a href="users.php" class="btn btn-dark text-white">Manage Users</a>
        <a href="companies.php" class="btn btn-dark text-white">Manage Companies</a>
        <a href="jobs.php" class="btn btn-dark text-white">Manage Jobs</a>
        <a href="applications.php" class="btn btn-dark text-white">Applications</a>
    </div>

    <div class="row mt-4">

        <div class="col-md-3 mb-3">
            <div class="card shadow p-4 text-center">
                <h3><?php echo $users; ?></h3>
                <p>Total Users</p>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow p-4 text-center">
                <h3><?php echo $companies; ?></h3>
                <p>Companies</p>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow p-4 text-center">
                <h3><?php echo $jobs; ?></h3>
                <p>Jobs</p>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow p-4 text-center">
                <h3><?php echo $applications; ?></h3>
                <p>Applications</p>
            </div>
        </div>

    </div>

   

</div>

<?php require_once "../includes/footer.php"; ?>