<?php
session_start();

require_once "../config/database.php";
require_once "../includes/auth_check.php";

requireRole('recruiter');

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("
    SELECT *
    FROM recruiter_profiles
    WHERE user_id=?
");

$stmt->bind_param("i", $user_id);
$stmt->execute();

$profile = $stmt->get_result()->fetch_assoc();

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $phone = trim($_POST['phone']);
    $designation = trim($_POST['designation']);
    $company_name = trim($_POST['company_name']);

    if ($profile) {

        $stmt = $conn->prepare("
            UPDATE recruiter_profiles
            SET phone=?, designation=?, company_name=?
            WHERE user_id=?
        ");

        $stmt->bind_param(
            "sssi",
            $phone,
            $designation,
            $company_name,
            $user_id
        );

    } else {

        $stmt = $conn->prepare("
            INSERT INTO recruiter_profiles
            (user_id,phone,designation,company_name)
            VALUES (?,?,?,?)
        ");

        $stmt->bind_param(
            "isss",
            $user_id,
            $phone,
            $designation,
            $company_name
        );
    }

    $stmt->execute();

    $companyCheck = $conn->prepare("
        SELECT id FROM companies
        WHERE recruiter_id=?
    ");

    $companyCheck->bind_param("i", $user_id);
    $companyCheck->execute();

    $company = $companyCheck->get_result()->fetch_assoc();

    if ($company) {

        $stmt = $conn->prepare("
            UPDATE companies
            SET company_name=?
            WHERE recruiter_id=?
        ");

        $stmt->bind_param(
            "si",
            $company_name,
            $user_id
        );

    } else {

        $stmt = $conn->prepare("
            INSERT INTO companies
            (recruiter_id,company_name)
            VALUES (?,?)
        ");

        $stmt->bind_param(
            "is",
            $user_id,
            $company_name
        );
    }

    $stmt->execute();

    header("Location: profile.php?success=1");
    exit;
}

require_once "../includes/header.php";
require_once "../includes/navbar.php";
?>

<div class="container mt-5">

    <h2>Recruiter Profile</h2>

    <?php if (isset($_GET['success'])): ?>

        <div class="alert alert-success">
            Profile updated successfully.
        </div>

    <?php endif; ?>

    <div class="card shadow mt-4">

        <div class="card-body">

            <form method="POST">

                <div class="mb-3">

                    <label>Company Name</label>

                    <input type="text"
                           name="company_name"
                           class="form-control"
                           required
                           value="<?php
                           echo htmlspecialchars(
                               $profile['company_name'] ?? ''
                           );
                           ?>">

                </div>

                <div class="mb-3">

                    <label>Phone</label>

                    <input type="text"
                           name="phone"
                           class="form-control"
                           value="<?php
                           echo htmlspecialchars(
                               $profile['phone'] ?? ''
                           );
                           ?>">

                </div>

                <div class="mb-3">

                    <label>Designation</label>

                    <input type="text"
                           name="designation"
                           class="form-control"
                           value="<?php
                           echo htmlspecialchars(
                               $profile['designation'] ?? ''
                           );
                           ?>">

                </div>

                <button class="btn btn-primary">
                    Save Profile
                </button>

            </form>

        </div>

    </div>

</div>

<?php require_once "../includes/footer.php"; ?>