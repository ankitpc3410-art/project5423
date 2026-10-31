<?php
session_start();

require_once "../config/database.php";
require_once "../includes/auth_check.php";

requireRole('candidate');

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("
    SELECT COUNT(*) AS total
    FROM applications
    WHERE candidate_id = ?
");

$stmt->bind_param("i", $user_id);
$stmt->execute();

$applications = $stmt->get_result()->fetch_assoc()['total'];

$stmt = $conn->prepare("
    SELECT COUNT(*) AS total
    FROM saved_jobs
    WHERE candidate_id = ?
");

$stmt->bind_param("i", $user_id);
$stmt->execute();

$saved = $stmt->get_result()->fetch_assoc()['total'];

$jobs = $conn->query("SELECT COUNT(*) AS total FROM jobs")->fetch_assoc()['total'];

require_once "../includes/header.php";
require_once "../includes/navbar.php";
?>

<div class="container mt-5">

    <h2>
        Welcome back, <?php echo htmlspecialchars($_SESSION['name']); ?>
    </h2>
    <p class="page-intro">Keep your job search moving. Review your activity, explore new roles, and manage your career profile.</p>

    <div class="row mt-4">

        <div class="col-md-4">
            <div class="card shadow p-4 text-center">
                <h3><?php echo $jobs; ?></h3>
                <p>Available Jobs</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow p-4 text-center">
                <h3><?php echo $applications; ?></h3>
                <p>Applications</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow p-4 text-center">
                <h3><?php echo $saved; ?></h3>
                <p>Saved Jobs</p>
            </div>
        </div>

    </div>

    <div class="mt-4">

        <a href="jobs.php" class="btn btn-primary">
            Browse Jobs
        </a>

        <a href="profile.php" class="btn btn-success">
            My Profile
        </a>

        <a href="applications.php" class="btn btn-info">
            My Applications
        </a>

        <a href="saved_jobs.php" class="btn btn-warning">
            Saved Jobs
        </a>

    </div>

</div>

<?php require_once "../includes/footer.php"; ?>