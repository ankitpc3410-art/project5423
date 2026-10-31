<?php
session_start();
require_once "../config/database.php";
require_once "../includes/auth_check.php";

requireRole('admin');

if (isset($_GET['delete'])) {

    $id = (int)$_GET['delete'];

    $stmt = $conn->prepare("DELETE FROM applications WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: applications.php");
    exit;
}

$result = $conn->query("
    SELECT applications.*,
           users.name AS candidate_name,
           users.email,
           jobs.title AS job_title
    FROM applications
    JOIN users ON applications.candidate_id = users.id
    JOIN jobs ON applications.job_id = jobs.id
    ORDER BY applications.applied_at DESC
");

require_once "../includes/header.php";
require_once "../includes/navbar.php";
?>

<div class="container mt-5">

    <h2>Job Applications</h2>

    <div class="table-responsive mt-4">

        <table class="table table-bordered">

            <thead class="table-dark">

                <tr>
                    <th>ID</th>
                    <th>Candidate</th>
                    <th>Email</th>
                    <th>Job</th>
                    <th>Status</th>
                    <th>Resume</th>
                    <th>Applied</th>
                    <th>Action</th>
                </tr>

            </thead>

            <tbody>

            <?php while ($app = $result->fetch_assoc()): ?>

                <tr>

                    <td><?php echo $app['id']; ?></td>

                    <td><?php echo htmlspecialchars($app['candidate_name']); ?></td>

                    <td><?php echo htmlspecialchars($app['email']); ?></td>

                    <td><?php echo htmlspecialchars($app['job_title']); ?></td>

                    <td><?php echo htmlspecialchars($app['status']); ?></td>

                    <td>

                        <?php if (!empty($app['resume'])): ?>

                            <a href="../uploads/resumes/<?php echo htmlspecialchars($app['resume']); ?>"
                               target="_blank"
                               class="btn btn-sm btn-primary">
                                View
                            </a>

                        <?php else: ?>

                            No Resume

                        <?php endif; ?>

                    </td>

                    <td><?php echo $app['applied_at']; ?></td>

                    <td>

                        <a href="?delete=<?php echo $app['id']; ?>"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Delete application?')">
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