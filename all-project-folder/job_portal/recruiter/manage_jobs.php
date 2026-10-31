<?php
session_start();

require_once "../config/database.php";
require_once "../includes/auth_check.php";

requireRole('recruiter');

$user_id = $_SESSION['user_id'];

if (isset($_GET['delete'])) {

    $id = (int)$_GET['delete'];

    $stmt = $conn->prepare("
        DELETE FROM jobs
        WHERE id=? AND recruiter_id=?
    ");

    $stmt->bind_param("ii", $id, $user_id);
    $stmt->execute();

    header("Location: manage_jobs.php");
    exit;
}

$stmt = $conn->prepare("
    SELECT jobs.*, companies.company_name
    FROM jobs
    LEFT JOIN companies
        ON jobs.company_id = companies.id
    WHERE jobs.recruiter_id=?
    ORDER BY jobs.created_at DESC
");

$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();

require_once "../includes/header.php";
require_once "../includes/navbar.php";
?>

<div class="container mt-5  bg-dark text-white shadow rounded" style="margin-bottom: 30px; padding: 40px;">

    <div class="d-flex justify-content-between">

        <h2 >Manage Jobs</h2>

        <a href="post_job.php"
           class="btn btn-dark text-white">
            + Post Job
        </a>

    </div>

    <?php if (isset($_GET['success'])): ?>

        <div class="alert alert-success mt-3">
            Job posted successfully.
        </div>

    <?php endif; ?>

    <div class="table-responsive mt-4">

        <table class="table table-bordered">

            <thead class="table-dark">

                <tr>
                    <th>Title</th>
                    <th>Company</th>
                    <th>Location</th>
                    <th>Type</th>
                    <th>Deadline</th>
                    <th>Action</th>
                </tr>

            </thead>

            <tbody>

            <?php while ($job = $result->fetch_assoc()): ?>

                <tr>

                    <td><?php echo htmlspecialchars($job['title']); ?></td>

                    <td>
                        <?php echo htmlspecialchars($job['company_name'] ?? ''); ?>
                    </td>

                    <td><?php echo htmlspecialchars($job['location']); ?></td>

                    <td><?php echo htmlspecialchars($job['job_type']); ?></td>

                    <td><?php echo htmlspecialchars($job['deadline']); ?></td>

                    <td>

                        <a href="applicants.php?job_id=<?php echo $job['id']; ?>"
                           class="btn btn-dark text-white btn-sm">
                            Applicants
                        </a>

                        <a href="?delete=<?php echo $job['id']; ?>"
                           class="btn btn-secondary text-white btn-sm"
                           onclick="return confirm('Delete this job?')">
                            Delete
                        </a>

                    </td>

                </tr>

            <?php endwhile; ?>

            </tbody>

        </table>

    </div>

</div>

<?php require_once "../includes/footer.php"; ?>