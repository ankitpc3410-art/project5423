<?php
session_start();

require_once "../config/database.php";
require_once "../includes/auth_check.php";

requireRole('recruiter');

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("
    SELECT COUNT(*) AS total
    FROM jobs
    WHERE recruiter_id = ?
");

$stmt->bind_param("i", $user_id);
$stmt->execute();

$totalJobs = $stmt->get_result()->fetch_assoc()['total'];

$stmt = $conn->prepare("
    SELECT COUNT(*) AS total
    FROM applications a
    JOIN jobs j ON a.job_id = j.id
    WHERE j.recruiter_id = ?
");

$stmt->bind_param("i", $user_id);
$stmt->execute();

$totalApplications = $stmt->get_result()->fetch_assoc()['total'];

require_once "../includes/header.php";
require_once "../includes/navbar.php";
?>

<div class="container mt-5">

    <h2>
        Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>
    </h2>

    <div class="row mt-4">

        <div class="col-md-6">

            <div class="card shadow p-4 text-center">

                <h2><?php echo $totalJobs; ?></h2>

                <p>My Jobs</p>

            </div>

        </div>

        <div class="col-md-6">

            <div class="card shadow p-4 text-center">

                <h2><?php echo $totalApplications; ?></h2>

                <p>Applications</p>

            </div>

        </div>

    </div>

    <div class="mt-4">

        <a href="post_job.php"
           class="btn btn-primary">
            Post New Job
        </a>

        <a href="manage_jobs.php"
           class="btn btn-success">
            Manage Jobs
        </a>

        <a href="applicants.php"
           class="btn btn-info">
            Applicants
        </a>

        <a href="profile.php"
           class="btn btn-warning">
            Company Profile
        </a>

    </div>

</div>

<?php require_once "../includes/footer.php"; ?>