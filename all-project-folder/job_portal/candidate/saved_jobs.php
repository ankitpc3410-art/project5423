<?php
session_start();

require_once "../config/database.php";
require_once "../includes/auth_check.php";

requireRole('candidate');

$user_id = $_SESSION['user_id'];

if (isset($_GET['remove'])) {

    $id = (int)$_GET['remove'];

    $stmt = $conn->prepare("
        DELETE FROM saved_jobs
        WHERE id=? AND candidate_id=?
    ");

    $stmt->bind_param("ii", $id, $user_id);
    $stmt->execute();

    header("Location: saved_jobs.php");
    exit;
}

$stmt = $conn->prepare("
    SELECT saved_jobs.id AS saved_id,
           jobs.*,
           companies.company_name
    FROM saved_jobs
    JOIN jobs ON saved_jobs.job_id = jobs.id
    LEFT JOIN companies
        ON jobs.company_id = companies.id
    WHERE saved_jobs.candidate_id = ?
    ORDER BY saved_jobs.created_at DESC
");

$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();

require_once "../includes/header.php";
require_once "../includes/navbar.php";
?>

<div class="container mt-5 bg-dark text-white shadow rounded" style="margin-bottom: 30px; padding: 40px;">

    <h2>Saved Jobs</h2>

    <div class="row mt-4">

    <?php while ($job = $result->fetch_assoc()): ?>

        <div class="col-md-6 mb-4">

            <div class="card shadow">

                <div class="card-body ">

                    <h4>
                        <?php echo htmlspecialchars($job['title']); ?>
                    </h4>

                    <p>
                        <?php echo htmlspecialchars($job['company_name'] ?? ''); ?>
                    </p>

                    <p>
                        <?php echo htmlspecialchars($job['location']); ?>
                    </p>

                    <a href="jobs.php?apply=<?php echo $job['id']; ?>"
                       class="btn btn-success">
                        Apply
                    </a>

                    <a href="?remove=<?php echo $job['saved_id']; ?>"
                       class="btn btn-secondary">
                        Remove
                    </a>

                </div>

            </div>

        </div>

    <?php endwhile; ?>

    </div>

</div>

<?php require_once "../includes/footer.php"; ?>