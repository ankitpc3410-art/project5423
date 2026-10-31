<?php
session_start();

require_once "../config/database.php";
require_once "../includes/auth_check.php";

requireRole('candidate');

$user_id = $_SESSION['user_id'];

if (isset($_GET['save'])) {

    $job_id = (int)$_GET['save'];

    $stmt = $conn->prepare("
        INSERT IGNORE INTO saved_jobs
        (job_id,candidate_id)
        VALUES (?,?)
    ");

    $stmt->bind_param("ii", $job_id, $user_id);
    $stmt->execute();

    header("Location: jobs.php");
    exit;
}

if (isset($_GET['apply'])) {

    $job_id = (int)$_GET['apply'];

    $check = $conn->prepare("
        SELECT id
        FROM applications
        WHERE job_id=? AND candidate_id=?
    ");

    $check->bind_param("ii", $job_id, $user_id);
    $check->execute();

    if ($check->get_result()->num_rows === 0) {

        $profileStmt = $conn->prepare("
            SELECT resume
            FROM candidate_profiles
            WHERE user_id=?
        ");

        $profileStmt->bind_param("i", $user_id);
        $profileStmt->execute();

        $profile = $profileStmt->get_result()->fetch_assoc();

        $resume = $profile['resume'] ?? '';

        $stmt = $conn->prepare("
            INSERT INTO applications
            (job_id,candidate_id,resume)
            VALUES (?,?,?)
        ");

        $stmt->bind_param(
            "iis",
            $job_id,
            $user_id,
            $resume
        );

        $stmt->execute();
    }

    header("Location: applications.php");
    exit;
}

$search = trim($_GET['search'] ?? '');

if ($search !== '') {

    $like = "%".$search."%";

    $stmt = $conn->prepare("
        SELECT jobs.*, companies.company_name
        FROM jobs
        LEFT JOIN companies
        ON jobs.company_id = companies.id
        WHERE jobs.title LIKE ?
        OR jobs.location LIKE ?
        OR companies.company_name LIKE ?
        ORDER BY jobs.created_at DESC
    ");

    $stmt->bind_param("sss", $like, $like, $like);
    $stmt->execute();

    $result = $stmt->get_result();

} else {

    $result = $conn->query("
        SELECT jobs.*, companies.company_name
        FROM jobs
        LEFT JOIN companies
        ON jobs.company_id = companies.id
        ORDER BY jobs.created_at DESC
    ");
}

require_once "../includes/header.php";
require_once "../includes/navbar.php";
?>

<div class="container mt-5">

    <h2>Find Your Next Opportunity</h2>
    <p class="page-intro">Search open positions by role, company, or location and discover work that fits your goals.</p>

    <form method="GET" class="row mt-4 mb-4">

        <div class="col-md-10">

            <input type="text"
                   name="search"
                   class="form-control"
                   placeholder="Search job title, company, or location"
                   value="<?php echo htmlspecialchars($search); ?>">

        </div>

        <div class="col-md-2">

            <button class="btn btn-primary w-100">
                Search
            </button>

        </div>

    </form>

    <div class="row">

    <?php while ($job = $result->fetch_assoc()): ?>

        <div class="col-md-6 mb-4">

            <div class="card shadow h-100">

                <div class="card-body">

                    <h4>
                        <?php echo htmlspecialchars($job['title']); ?>
                    </h4>

                    <p>
                        <strong>
                            <?php echo htmlspecialchars($job['company_name'] ?? 'Company'); ?>
                        </strong>
                    </p>

                    <p>
                        📍 <?php echo htmlspecialchars($job['location']); ?>
                    </p>

                    <p>
                        💰 <?php echo htmlspecialchars($job['salary']); ?>
                    </p>

                    <p>
                        💼 <?php echo htmlspecialchars($job['job_type']); ?>
                    </p>

                    <p>
                        <?php
                        echo nl2br(
                            htmlspecialchars(
                                substr($job['description'], 0, 250)
                            )
                        );
                        ?>
                    </p>

                    <a href="?apply=<?php echo $job['id']; ?>"
                       class="btn btn-primary">
                        Apply
                    </a>

                    <a href="?save=<?php echo $job['id']; ?>"
                       class="btn btn-warning">
                        Save
                    </a>

                </div>

            </div>

        </div>

    <?php endwhile; ?>

    </div>

</div>

<?php require_once "../includes/footer.php"; ?>