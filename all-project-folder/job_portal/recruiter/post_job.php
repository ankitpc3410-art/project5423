<?php
session_start();

require_once "../config/database.php";
require_once "../includes/auth_check.php";

requireRole('recruiter');

$user_id = $_SESSION['user_id'];

$message = "";

$stmt = $conn->prepare("
    SELECT id, company_name
    FROM companies
    WHERE recruiter_id=?
");

$stmt->bind_param("i", $user_id);
$stmt->execute();

$companies = $stmt->get_result();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $company_id = (int)$_POST['company_id'];
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $requirements = trim($_POST['requirements']);
    $location = trim($_POST['location']);
    $salary = trim($_POST['salary']);
    $job_type = trim($_POST['job_type']);
    $deadline = $_POST['deadline'];

    $stmt = $conn->prepare("
        INSERT INTO jobs
        (recruiter_id,company_id,title,description,
         requirements,location,salary,job_type,deadline)
        VALUES (?,?,?,?,?,?,?,?,?)
    ");

    $stmt->bind_param(
        "iisssssss",
        $user_id,
        $company_id,
        $title,
        $description,
        $requirements,
        $location,
        $salary,
        $job_type,
        $deadline
    );

    if ($stmt->execute()) {

        header("Location: manage_jobs.php?success=1");
        exit;

    } else {

        $message = "Unable to post job.";
    }
}

require_once "../includes/header.php";
require_once "../includes/navbar.php";
?>

<div class="container mt-5 bg-dark text-white shadow rounded" style="margin-bottom: 30px; padding: 40px;">

    <h2 >Post New Job</h2>

    <?php if ($message): ?>

        <div class="alert alert-danger">
            <?php echo $message; ?>
        </div>

    <?php endif; ?>

    <div class="card shadow mt-4 show rounded bg-secondary text-white">

        <div class="card-body">

            <form method="POST">

                <div class="mb-3">

                    <label>Company</label>

                    <select name="company_id"
                            class="form-control"
                            required>

                        <option value="">
                            Select Company
                        </option>

                        <?php while ($company = $companies->fetch_assoc()): ?>

                            <option value="<?php echo $company['id']; ?>">
                                <?php echo htmlspecialchars($company['company_name']); ?>
                            </option>

                        <?php endwhile; ?>

                    </select>

                </div>

                <div class="mb-3">
                    <label>Job Title</label>

                    <input type="text"
                           name="title"
                           class="form-control"
                           required>
                </div>

                <div class="mb-3">
                    <label>Description</label>

                    <textarea name="description"
                              class="form-control"
                              rows="5"
                              required></textarea>
                </div>

                <div class="mb-3">
                    <label>Requirements</label>

                    <textarea name="requirements"
                              class="form-control"
                              rows="4"></textarea>
                </div>

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label>Location</label>

                        <input type="text"
                               name="location"
                               class="form-control">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Salary</label>

                        <input type="text"
                               name="salary"
                               class="form-control">

                    </div>

                </div>

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label>Job Type</label>

                        <select name="job_type"
                                class="form-control">

                            <option>Full Time</option>
                            <option>Part Time</option>
                            <option>Internship</option>
                            <option>Remote</option>
                            <option>Contract</option>

                        </select>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Application Deadline</label>

                        <input type="date"
                               name="deadline"
                               class="form-control">

                    </div>

                </div>

                <button class="btn btn-dark text-white">
                    Post Job
                </button>

            </form>

        </div>

    </div>

</div>

<?php require_once "../includes/footer.php"; ?>