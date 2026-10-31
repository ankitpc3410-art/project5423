<?php
session_start();
require_once "../config/database.php";
require_once "../includes/auth_check.php";

requireRole('admin');

if (isset($_GET['delete'])) {

    $id = (int)$_GET['delete'];

    $stmt = $conn->prepare("DELETE FROM jobs WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: jobs.php");
    exit;
}

$result = $conn->query("
    SELECT jobs.*, companies.company_name
    FROM jobs
    LEFT JOIN companies ON jobs.company_id = companies.id
    ORDER BY jobs.id DESC
");

require_once "../includes/header.php";
require_once "../includes/navbar.php";
?>

<div class="container mt-5 bg-dark text-white shadow rounded" style="margin-bottom: 30px; padding: 40px;">

    <h2 style="color: #d8b90a;">Manage Jobs</h2>

    <div class="table-responsive mt-4">

        <table class="table table-bordered">

            <thead class="table-dark">

                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Company</th>
                    <th>Location</th>
                    <th>Salary</th>
                    <th>Job Type</th>
                    <th>Action</th>
                </tr>

            </thead>

            <tbody>

            <?php while ($job = $result->fetch_assoc()): ?>

                <tr>

                    <td><?php echo $job['id']; ?></td>

                    <td><?php echo htmlspecialchars($job['title']); ?></td>

                    <td>
                        <?php echo htmlspecialchars($job['company_name'] ?? ''); ?>
                    </td>

                    <td><?php echo htmlspecialchars($job['location']); ?></td>

                    <td><?php echo htmlspecialchars($job['salary']); ?></td>

                    <td><?php echo htmlspecialchars($job['job_type']); ?></td>

                    <td>

                        <a href="?delete=<?php echo $job['id']; ?>"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Delete job?')">
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