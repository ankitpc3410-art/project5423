<?php
session_start();

require_once "../config/database.php";
require_once "../includes/auth_check.php";

requireRole('candidate');

$user_id = $_SESSION['user_id'];

$message = "";

$stmt = $conn->prepare("
    SELECT *
    FROM candidate_profiles
    WHERE user_id = ?
");

$stmt->bind_param("i", $user_id);
$stmt->execute();

$profile = $stmt->get_result()->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $phone = trim($_POST['phone']);
    $skills = trim($_POST['skills']);
    $education = trim($_POST['education']);
    $experience = trim($_POST['experience']);

    $resume = $profile['resume'] ?? '';

    if (isset($_FILES['resume']) &&
        $_FILES['resume']['error'] === 0) {

        $extension = strtolower(
            pathinfo($_FILES['resume']['name'], PATHINFO_EXTENSION)
        );

        $allowed = ['pdf', 'doc', 'docx'];

        if (in_array($extension, $allowed)) {

            $resume = time() . "_" .
                preg_replace(
                    "/[^a-zA-Z0-9._-]/",
                    "",
                    $_FILES['resume']['name']
                );

            move_uploaded_file(
                $_FILES['resume']['tmp_name'],
                "../uploads/resumes/" . $resume
            );
        }
    }

    if ($profile) {

        $stmt = $conn->prepare("
            UPDATE candidate_profiles
            SET phone=?, skills=?, education=?, experience=?, resume=?
            WHERE user_id=?
        ");

        $stmt->bind_param(
            "sssssi",
            $phone,
            $skills,
            $education,
            $experience,
            $resume,
            $user_id
        );

    } else {

        $stmt = $conn->prepare("
            INSERT INTO candidate_profiles
            (user_id,phone,skills,education,experience,resume)
            VALUES (?,?,?,?,?,?)
        ");

        $stmt->bind_param(
            "isssss",
            $user_id,
            $phone,
            $skills,
            $education,
            $experience,
            $resume
        );
    }

    $stmt->execute();

    $message = "Profile updated successfully.";

    header("Location: profile.php?success=1");
    exit;
}

require_once "../includes/header.php";
require_once "../includes/navbar.php";
?>

<div class="container mt-5">

    <h2>My Profile</h2>

    <?php if (isset($_GET['success'])): ?>

        <div class="alert alert-success">
            Profile updated successfully.
        </div>

    <?php endif; ?>

    <div class="card shadow mt-4">

        <div class="card-body">

            <form method="POST" enctype="multipart/form-data">

                <div class="mb-3">
                    <label>Phone</label>
                    <input type="text"
                           name="phone"
                           class="form-control"
                           value="<?php echo htmlspecialchars($profile['phone'] ?? ''); ?>">
                </div>

                <div class="mb-3">
                    <label>Skills</label>
                    <textarea name="skills"
                              class="form-control"><?php
                        echo htmlspecialchars($profile['skills'] ?? '');
                    ?></textarea>
                </div>

                <div class="mb-3">
                    <label>Education</label>
                    <textarea name="education"
                              class="form-control"><?php
                        echo htmlspecialchars($profile['education'] ?? '');
                    ?></textarea>
                </div>

                <div class="mb-3">
                    <label>Experience</label>
                    <textarea name="experience"
                              class="form-control"><?php
                        echo htmlspecialchars($profile['experience'] ?? '');
                    ?></textarea>
                </div>

                <div class="mb-3">
                    <label>Resume</label>
                    <input type="file"
                           name="resume"
                           class="form-control"
                           accept=".pdf,.doc,.docx">
                </div>

                <button class="btn btn-primary">
                    Save Profile
                </button>

            </form>

        </div>

    </div>

</div>

<?php require_once "../includes/footer.php"; ?>