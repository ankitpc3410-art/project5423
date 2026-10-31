
<?php
session_start();

require_once "../config/database.php";
require_once "../includes/auth_check.php";

requireRole('recruiter');

$user_id = $_SESSION['user_id'];

// Allowed application statuses
$allowed_statuses = [
    'Applied',
    'Shortlisted',
    'Rejected',
    'Selected'
];

/*
|--------------------------------------------------------------------------
| Update Application Status
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $status = $_POST['status'] ?? '';
    $application_id = isset($_POST['application_id'])
        ? (int) $_POST['application_id']
        : 0;

    if (
        $application_id > 0 &&
        in_array($status, $allowed_statuses, true)
    ) {

        // Only allow recruiters to update applications
        // belonging to their own jobs.
        $stmt = $conn->prepare("
            UPDATE applications a
            JOIN jobs j ON a.job_id = j.id
            SET a.status = ?
            WHERE a.id = ?
              AND j.recruiter_id = ?
        ");

        $stmt->bind_param(
            "sii",
            $status,
            $application_id,
            $user_id
        );

        $stmt->execute();
        $stmt->close();
    }

    // Preserve the job filter after updating status
    $redirect_url = "applicants.php";

    if (isset($_POST['job_id']) && (int) $_POST['job_id'] > 0) {
        $redirect_url .= "?job_id=" . (int) $_POST['job_id'];
    }

    header("Location: " . $redirect_url);
    exit;
}

/*
|--------------------------------------------------------------------------
| Job Filter
|--------------------------------------------------------------------------
*/

$job_id = isset($_GET['job_id'])
    ? (int) $_GET['job_id']
    : 0;

/*
|--------------------------------------------------------------------------
| Fetch Applicants
|--------------------------------------------------------------------------
*/

if ($job_id > 0) {

    // Applicants for a specific job belonging to this recruiter
    $stmt = $conn->prepare("
        SELECT
            a.*,
            u.name,
            u.email,
            j.title,
            cp.profile_image
        FROM applications a
        INNER JOIN users u
            ON a.candidate_id = u.id
        INNER JOIN jobs j
            ON a.job_id = j.id
        LEFT JOIN candidate_profiles cp
            ON cp.user_id = a.candidate_id
        WHERE j.id = ?
          AND j.recruiter_id = ?
        ORDER BY a.applied_at DESC
    ");

    $stmt->bind_param("ii", $job_id, $user_id);

} else {

    // All applicants for jobs belonging to this recruiter
    $stmt = $conn->prepare("
        SELECT
            a.*,
            u.name,
            u.email,
            j.title,
            cp.profile_image
        FROM applications a
        INNER JOIN users u
            ON a.candidate_id = u.id
        INNER JOIN jobs j
            ON a.job_id = j.id
        LEFT JOIN candidate_profiles cp
            ON cp.user_id = a.candidate_id
        WHERE j.recruiter_id = ?
        ORDER BY a.applied_at DESC
    ");

    $stmt->bind_param("i", $user_id);
}

$stmt->execute();

$result = $stmt->get_result();

require_once "../includes/header.php";
require_once "../includes/navbar.php";

// Upload directories
$profile_image_dir = "../uploads/profile_images/";
$resume_dir = "../uploads/resumes/";
?>

<div class="container mt-5 mb-5">

    <div class="bg-dark text-white shadow rounded p-4">

        <h2 class="mb-2">Applicants</h2>

        <p class="text-light">
            View candidate profiles, resumes, and application statuses.
        </p>

        <?php if ($job_id > 0): ?>

            <a href="applicants.php" class="btn btn-outline-light btn-sm mb-3">
                View All Applicants
            </a>

        <?php endif; ?>

        <div class="table-responsive mt-4">

            <table class="table table-bordered table-hover align-middle bg-white">

                <thead class="table-dark">

                    <tr>
                        <th class="text-center">Photo</th>
                        <th>Candidate</th>
                        <th>Email</th>
                        <th>Job</th>
                        <th>Resume</th>
                        <th>Status</th>
                        <th style="min-width: 160px;">Update Status</th>
                    </tr>

                </thead>

                <tbody>

                <?php if ($result->num_rows > 0): ?>

                    <?php while ($app = $result->fetch_assoc()): ?>

                        <?php
                        // Safely obtain the candidate's profile image filename
                        $photo = $app['profile_image'] ?? '';

                        $photo_filename = basename($photo);

                        $photo_file = $profile_image_dir . $photo_filename;

                        $has_photo = (
                            $photo !== '' &&
                            is_file($photo_file)
                        );

                        // Safely obtain the resume filename
                        $resume = $app['resume'] ?? '';

                        $resume_filename = basename($resume);

                        $resume_file = $resume_dir . $resume_filename;

                        $has_resume = (
                            $resume !== '' &&
                            is_file($resume_file)
                        );

                        // Determine status badge appearance
                        $status_class = 'bg-secondary';

                        switch ($app['status']) {

                            case 'Applied':
                                $status_class = 'bg-primary';
                                break;

                            case 'Shortlisted':
                                $status_class = 'bg-info text-dark';
                                break;

                            case 'Rejected':
                                $status_class = 'bg-danger';
                                break;

                            case 'Selected':
                                $status_class = 'bg-success';
                                break;
                        }
                        ?>

                        <tr>

                            <!-- Candidate Profile Photo -->
                            <td class="text-center">

                                <?php if ($has_photo): ?>

                                    <img
                                        src="<?php
                                            echo htmlspecialchars(
                                                $photo_file,
                                                ENT_QUOTES,
                                                'UTF-8'
                                            );
                                        ?>"
                                        alt="Candidate Profile"
                                        class="rounded-circle border shadow-sm"
                                        width="60"
                                        height="60"
                                        style="object-fit: cover;"
                                        loading="lazy"
                                    >

                                <?php else: ?>

                                    <div
                                        class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center mx-auto border"
                                        style="width:60px; height:60px;"
                                        title="No profile photo uploaded"
                                    >
                                        <span style="font-size: 11px;">
                                            No Photo
                                        </span>
                                    </div>

                                <?php endif; ?>

                            </td>

                            <!-- Candidate Name -->
                            <td>
                                <strong>
                                    <?php
                                    echo htmlspecialchars(
                                        $app['name'] ?? '',
                                        ENT_QUOTES,
                                        'UTF-8'
                                    );
                                    ?>
                                </strong>
                            </td>

                            <!-- Candidate Email -->
                            <td>
                                <?php
                                echo htmlspecialchars(
                                    $app['email'] ?? '',
                                    ENT_QUOTES,
                                    'UTF-8'
                                );
                                ?>
                            </td>

                            <!-- Job Title -->
                            <td>
                                <?php
                                echo htmlspecialchars(
                                    $app['title'] ?? '',
                                    ENT_QUOTES,
                                    'UTF-8'
                                );
                                ?>
                            </td>

                            <!-- Resume -->
                            <td>

                                <?php if ($has_resume): ?>

                                    <a
                                        href="<?php
                                            echo htmlspecialchars(
                                                $resume_file,
                                                ENT_QUOTES,
                                                'UTF-8'
                                            );
                                        ?>"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="btn btn-dark text-white btn-sm"
                                    >
                                        View Resume
                                    </a>

                                <?php else: ?>

                                    <span class="text-muted">
                                        No Resume
                                    </span>

                                <?php endif; ?>

                            </td>

                            <!-- Current Application Status -->
                            <td>

                                <span class="badge <?php
                                    echo $status_class;
                                ?>">
                                    <?php
                                    echo htmlspecialchars(
                                        $app['status'] ?? 'Applied',
                                        ENT_QUOTES,
                                        'UTF-8'
                                    );
                                    ?>
                                </span>

                            </td>

                            <!-- Update Application Status -->
                            <td>

                                <form method="POST" action="applicants.php">

                                    <input
                                        type="hidden"
                                        name="application_id"
                                        value="<?php
                                            echo (int) $app['id'];
                                        ?>"
                                    >

                                    <input
                                        type="hidden"
                                        name="job_id"
                                        value="<?php echo $job_id; ?>"
                                    >

                                    <select
                                        name="status"
                                        class="form-select form-select-sm mb-2"
                                        required
                                    >

                                        <?php foreach (
                                            $allowed_statuses as $status_option
                                        ): ?>

                                            <option
                                                value="<?php
                                                    echo htmlspecialchars(
                                                        $status_option,
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    );
                                                ?>"
                                                <?php
                                                echo (
                                                    ($app['status'] ?? 'Applied')
                                                    === $status_option
                                                ) ? 'selected' : '';
                                                ?>
                                            >
                                                <?php
                                                echo htmlspecialchars(
                                                    $status_option,
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                );
                                                ?>
                                            </option>

                                        <?php endforeach; ?>

                                    </select>

                                    <button
                                        type="submit"
                                        class="btn btn-dark text-white btn-sm w-100"
                                    >
                                        Update
                                    </button>

                                </form>

                            </td>

                        </tr>

                    <?php endwhile; ?>

                <?php else: ?>

                    <tr>
                        <td colspan="7" class="text-center py-4">

                            <h5>No Applicants Found</h5>

                            <p class="mb-0">
                                No candidates have applied to your jobs yet.
                            </p>

                        </td>
                    </tr>

                <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?php
$stmt->close();

require_once "../includes/footer.php";
?>
