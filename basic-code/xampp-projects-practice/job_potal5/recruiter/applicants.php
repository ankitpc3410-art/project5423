<?php
session_start();

require_once "../config/database.php";
require_once "../includes/auth_check.php";

requireRole('recruiter');

$user_id = $_SESSION['user_id'];

if (isset($_POST['status'], $_POST['application_id'])) {

    $status = $_POST['status'];
    $application_id = (int)$_POST['application_id'];

    $allowed = [
        'Applied',
        'Shortlisted',
        'Rejected',
        'Selected'
    ];

    if (in_array($status, $allowed)) {

        $stmt = $conn->prepare("
            UPDATE applications a
            JOIN jobs j ON a.job_id=j.id
            SET a.status=?
            WHERE a.id=? AND j.recruiter_id=?
        ");

        $stmt->bind_param(
            "sii",
            $status,
            $application_id,
            $user_id
        );

        $stmt->execute();
    }

    header("Location: applicants.php");
    exit;
}

$job_id = isset($_GET['job_id'])
    ? (int)$_GET['job_id']
    : 0;

if ($job_id > 0) {

    $stmt = $conn->prepare("
        SELECT a.*,
               users.name,
               users.email,
               jobs.title
        FROM applications a
        JOIN users ON a.candidate_id=users.id
        JOIN jobs ON a.job_id=jobs.id
        WHERE jobs.id=? AND jobs.recruiter_id=?
        ORDER BY a.applied_at DESC
    ");

    $stmt->bind_param("ii", $job_id, $user_id);

} else {

    $stmt = $conn->prepare("
        SELECT a.*,
               users.name,
               users.email,
               jobs.title
        FROM applications a
        JOIN users ON a.candidate_id=users.id
        JOIN jobs ON a.job_id=jobs.id
        WHERE jobs.recruiter_id=?
        ORDER BY a.applied_at DESC
    ");

    $stmt->bind_param("i", $user_id);
}

$stmt->execute();

$result = $stmt->get_result();

require_once "../includes/header.php";
require_once "../includes/navbar.php";
?>

<div class="container mt-5">

    <h2>Applicants</h2>

    <div class="table-responsive mt-4">

        <table class="table table-bordered">

            <thead class="table-dark">

                <tr>
                    <th>Candidate</th>
                    <th>Email</th>
                    <th>Job</th>
                    <th>Resume</th>
                    <th>Status</th>
                    <th>Update</th>
                </tr>

            </thead>

            <tbody>

            <?php while ($app = $result->fetch_assoc()): ?>

                <tr>

                    <td>
                        <?php echo htmlspecialchars($app['name']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($app['email']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($app['title']); ?>
                    </td>

                    <td>

                        <?php if (!empty($app['resume'])): ?>

                            <a href="../uploads/resumes/<?php
                            echo htmlspecialchars($app['resume']);
                            ?>"
                               target="_blank"
                               class="btn btn-primary btn-sm">
                                View Resume
                            </a>

                        <?php else: ?>

                            No Resume

                        <?php endif; ?>

                    </td>

                    <td>
                        <?php echo htmlspecialchars($app['status']); ?>
                    </td>

                    <td>

                        <form method="POST">

                            <input type="hidden"
                                   name="application_id"
                                   value="<?php echo $app['id']; ?>">

                            <select name="status"
                                    class="form-select form-select-sm mb-2">

                                <option value="Applied"
                                    <?php if ($app['status'] === 'Applied') echo 'selected'; ?>>
                                    Applied
                                </option>

                                <option value="Shortlisted"
                                    <?php if ($app['status'] === 'Shortlisted') echo 'selected'; ?>>
                                    Shortlisted
                                </option>

                                <option value="Rejected"
                                    <?php if ($app['status'] === 'Rejected') echo 'selected'; ?>>
                                    Rejected
                                </option>

                                <option value="Selected"
                                    <?php if ($app['status'] === 'Selected') echo 'selected'; ?>>
                                    Selected
                                </option>

                            </select>

                            <button class="btn btn-success btn-sm">
                                Update
                            </button>

                        </form>

                    </td>

                </tr>

            <?php endwhile; ?>

            </tbody>

        </table>

    </div>

</div>

<?php require_once "../includes/footer.php"; ?>