<?php
session_start();

require_once "../config/database.php";
require_once "../includes/auth_check.php";

requireRole('candidate');

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("
    SELECT applications.*,
           jobs.title,
           companies.company_name
    FROM applications
    JOIN jobs ON applications.job_id = jobs.id
    LEFT JOIN companies
        ON jobs.company_id = companies.id
    WHERE applications.candidate_id = ?
    ORDER BY applications.applied_at DESC
");

$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();

require_once "../includes/header.php";
require_once "../includes/navbar.php";
?>

<div class="container mt-5">

    <h2>My Applications</h2>

    <div class="table-responsive mt-4">

        <table class="table table-bordered">

            <thead class="table-dark">

                <tr>
                    <th>Job</th>
                    <th>Company</th>
                    <th>Status</th>
                    <th>Applied Date</th>
                </tr>

            </thead>

            <tbody>

            <?php while ($app = $result->fetch_assoc()): ?>

                <tr>

                    <td><?php echo htmlspecialchars($app['title']); ?></td>

                    <td>
                        <?php echo htmlspecialchars($app['company_name'] ?? ''); ?>
                    </td>

                    <td>
                        <span class="badge bg-primary">
                            <?php echo htmlspecialchars($app['status']); ?>
                        </span>
                    </td>

                    <td><?php echo $app['applied_at']; ?></td>

                </tr>

            <?php endwhile; ?>

            </tbody>

        </table>

    </div>

</div>

<?php require_once "../includes/footer.php"; ?>