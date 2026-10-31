
<?php
session_start();

require_once "../config/database.php";
require_once "../includes/auth_check.php";

requireRole('candidate');

$user_id = $_SESSION['user_id'];
$message = "";

// Fetch candidate profile
$stmt = $conn->prepare("
    SELECT *
    FROM candidate_profiles
    WHERE user_id = ?
");

$stmt->bind_param("i", $user_id);
$stmt->execute();

$profile = $stmt->get_result()->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $phone = trim($_POST['phone'] ?? '');
    $skills = trim($_POST['skills'] ?? '');
    $education = trim($_POST['education'] ?? '');
    $experience = trim($_POST['experience'] ?? '');

    // Preserve existing files if no new file is uploaded
    $resume = $profile['resume'] ?? '';
    $profile_image = $profile['profile_image'] ?? '';

    $upload_errors = [];

    // Upload directories
    $resume_dir = "../uploads/resumes/";
    $image_dir = "../uploads/profile_images/";

    // Create directories if they do not exist
    if (!is_dir($resume_dir)) {
        mkdir($resume_dir, 0755, true);
    }

    if (!is_dir($image_dir)) {
        mkdir($image_dir, 0755, true);
    }

    /*
    |--------------------------------------------------------------------------
    | Resume Upload
    |--------------------------------------------------------------------------
    */

    if (
        isset($_FILES['resume']) &&
        $_FILES['resume']['error'] !== UPLOAD_ERR_NO_FILE
    ) {

        if ($_FILES['resume']['error'] !== UPLOAD_ERR_OK) {

            $upload_errors[] = "Resume upload failed.";

        } else {

            $resume_extension = strtolower(
                pathinfo(
                    $_FILES['resume']['name'],
                    PATHINFO_EXTENSION
                )
            );

            $allowed_resumes = ['pdf', 'doc', 'docx'];

            if (!in_array($resume_extension, $allowed_resumes, true)) {

                $upload_errors[] =
                    "Resume must be a PDF, DOC, or DOCX file.";

            } elseif ($_FILES['resume']['size'] > 5 * 1024 * 1024) {

                $upload_errors[] =
                    "Resume size must not exceed 5 MB.";

            } else {

                $resume_name = bin2hex(random_bytes(16))
                    . "."
                    . $resume_extension;

                if (
                    move_uploaded_file(
                        $_FILES['resume']['tmp_name'],
                        $resume_dir . $resume_name
                    )
                ) {
                    $resume = $resume_name;
                } else {
                    $upload_errors[] =
                        "Unable to save the uploaded resume.";
                }
            }
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Profile Image Upload
    |--------------------------------------------------------------------------
    */

    if (
        isset($_FILES['profile_image']) &&
        $_FILES['profile_image']['error'] !== UPLOAD_ERR_NO_FILE
    ) {

        if ($_FILES['profile_image']['error'] !== UPLOAD_ERR_OK) {

            $upload_errors[] = "Profile image upload failed.";

        } else {

            // Verify actual image type using MIME detection
            $image_info = @getimagesize(
                $_FILES['profile_image']['tmp_name']
            );

            $allowed_images = [
                'image/jpeg' => 'jpg',
                'image/png'  => 'png',
                'image/webp' => 'webp'
            ];

            $image_mime = $image_info['mime'] ?? '';

            if (
                !$image_info ||
                !isset($allowed_images[$image_mime])
            ) {

                $upload_errors[] =
                    "Profile image must be JPG, PNG, or WEBP.";

            } elseif (
                $_FILES['profile_image']['size'] > 2 * 1024 * 1024
            ) {

                $upload_errors[] =
                    "Profile image size must not exceed 2 MB.";

            } else {

                $image_extension = $allowed_images[$image_mime];

                $image_name = bin2hex(random_bytes(16))
                    . "."
                    . $image_extension;

                if (
                    move_uploaded_file(
                        $_FILES['profile_image']['tmp_name'],
                        $image_dir . $image_name
                    )
                ) {

                    $profile_image = $image_name;

                } else {

                    $upload_errors[] =
                        "Unable to save the profile image.";
                }
            }
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Save Candidate Profile
    |--------------------------------------------------------------------------
    */

    if (empty($upload_errors)) {

        if ($profile) {

            // Update existing profile
            $stmt = $conn->prepare("
                UPDATE candidate_profiles
                SET
                    phone = ?,
                    skills = ?,
                    education = ?,
                    experience = ?,
                    resume = ?,
                    profile_image = ?
                WHERE user_id = ?
            ");

            $stmt->bind_param(
                "ssssssi",
                $phone,
                $skills,
                $education,
                $experience,
                $resume,
                $profile_image,
                $user_id
            );

        } else {

            // Create new profile
            $stmt = $conn->prepare("
                INSERT INTO candidate_profiles
                (
                    user_id,
                    phone,
                    skills,
                    education,
                    experience,
                    resume,
                    profile_image
                )
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");

            $stmt->bind_param(
                "issssss",
                $user_id,
                $phone,
                $skills,
                $education,
                $experience,
                $resume,
                $profile_image
            );
        }

        if ($stmt->execute()) {

            header("Location: profile.php?success=1");
            exit;

        } else {

            $message = "Unable to save your profile. Please try again.";
        }

    } else {

        $message = implode(" ", $upload_errors);
    }
}

require_once "../includes/header.php";
require_once "../includes/navbar.php";

// Profile image URL
$current_image = $profile['profile_image'] ?? '';

$image_path = "../uploads/profile_images/";

$has_profile_image = (
    $current_image !== '' &&
    is_file($image_path . basename($current_image))
);

$resume_name = $profile['resume'] ?? '';

?>

<div class="container mt-5 mb-5">

    <div class="card bg-dark text-white shadow rounded">

        <div class="card-body p-4 p-md-5">

            <h2 class="mb-4">My Profile</h2>

            <?php if (isset($_GET['success'])): ?>

                <div class="alert alert-success">
                    Profile updated successfully!
                </div>

            <?php endif; ?>

            <?php if ($message !== ''): ?>

                <div class="alert alert-danger">
                    <?php echo htmlspecialchars($message); ?>
                </div>

            <?php endif; ?>

            <div class="card bg-secondary text-white shadow rounded">

                <div class="card-body">

                    <form
                        method="POST"
                        enctype="multipart/form-data"
                    >

                        <!-- Profile Image Preview -->
                        <div class="text-center mb-4">

                            <?php if ($has_profile_image): ?>

                                <img
                                    src="<?php
                                        echo htmlspecialchars(
                                            $image_path .
                                            basename($current_image)
                                        );
                                    ?>"
                                    alt="Profile Image"
                                    id="profilePreview"
                                    class="rounded-circle border border-3 border-light shadow"
                                    width="150"
                                    height="150"
                                    style="object-fit: cover;"
                                >

                            <?php else: ?>

                                <div
                                    id="profilePlaceholder"
                                    class="rounded-circle bg-dark border border-3 border-light d-flex align-items-center justify-content-center mx-auto"
                                    style="width:150px;height:150px;"
                                >
                                    <span class="fs-1">👤</span>
                                </div>

                                <img
                                    src=""
                                    alt="Profile Preview"
                                    id="profilePreview"
                                    class="rounded-circle border border-3 border-light shadow d-none"
                                    width="150"
                                    height="150"
                                    style="object-fit: cover;"
                                >

                            <?php endif; ?>

                            <h5 class="mt-3">Profile Picture</h5>

                            <p class="small">
                                Upload a JPG, PNG, or WEBP image.
                                Maximum size: 2 MB.
                            </p>

                        </div>

                        <!-- Profile Image Upload -->
                        <div class="mb-4">

                            <label
                                for="profile_image"
                                class="form-label"
                            >
                                Choose Profile Image
                            </label>

                            <input
                                type="file"
                                name="profile_image"
                                id="profile_image"
                                class="form-control"
                                accept=".jpg,.jpeg,.png,.webp"
                            >

                        </div>

                        <!-- Phone -->
                        <div class="mb-3">

                            <label
                                for="phone"
                                class="form-label"
                            >
                                Phone
                            </label>

                            <input
                                type="text"
                                name="phone"
                                id="phone"
                                class="form-control"
                                value="<?php
                                    echo htmlspecialchars(
                                        $profile['phone'] ?? ''
                                    );
                                ?>"
                                maxlength="20"
                            >

                        </div>

                        <!-- Skills -->
                        <div class="mb-3">

                            <label
                                for="skills"
                                class="form-label"
                            >
                                Skills
                            </label>

                            <textarea
                                name="skills"
                                id="skills"
                                class="form-control"
                                rows="3"
                            ><?php
                                echo htmlspecialchars(
                                    $profile['skills'] ?? ''
                                );
                            ?></textarea>

                        </div>

                        <!-- Education -->
                        <div class="mb-3">

                            <label
                                for="education"
                                class="form-label"
                            >
                                Education
                            </label>

                            <textarea
                                name="education"
                                id="education"
                                class="form-control"
                                rows="3"
                            ><?php
                                echo htmlspecialchars(
                                    $profile['education'] ?? ''
                                );
                            ?></textarea>

                        </div>

                        <!-- Experience -->
                        <div class="mb-3">

                            <label
                                for="experience"
                                class="form-label"
                            >
                                Experience
                            </label>

                            <textarea
                                name="experience"
                                id="experience"
                                class="form-control"
                                rows="3"
                            ><?php
                                echo htmlspecialchars(
                                    $profile['experience'] ?? ''
                                );
                            ?></textarea>

                        </div>

                        <!-- Resume -->
                        <div class="mb-3">

                            <label
                                for="resume"
                                class="form-label"
                            >
                                Resume
                            </label>

                            <?php if ($resume_name !== ''): ?>

                                <p class="small">
                                    Current resume:
                                    <?php
                                        echo htmlspecialchars(
                                            basename($resume_name)
                                        );
                                    ?>
                                </p>

                            <?php endif; ?>

                            <input
                                type="file"
                                name="resume"
                                id="resume"
                                class="form-control"
                                accept=".pdf,.doc,.docx"
                            >

                            <small class="text-light">
                                Accepted formats: PDF, DOC, DOCX.
                                Maximum size: 5 MB.
                            </small>

                        </div>

                        <!-- Save Button -->
                        <button
                            type="submit"
                            class="btn btn-dark text-white mt-3"
                        >
                            Save Profile
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const imageInput = document.getElementById("profile_image");
    const imagePreview = document.getElementById("profilePreview");
    const placeholder = document.getElementById("profilePlaceholder");

    imageInput.addEventListener("change", function () {

        const file = this.files[0];

        if (!file) {
            return;
        }

        const allowedTypes = [
            "image/jpeg",
            "image/png",
            "image/webp"
        ];

        if (!allowedTypes.includes(file.type)) {
            alert("Please select a JPG, PNG, or WEBP image.");
            this.value = "";
            return;
        }

        if (file.size > 2 * 1024 * 1024) {
            alert("Profile image must not exceed 2 MB.");
            this.value = "";
            return;
        }

        const reader = new FileReader();

        reader.onload = function (event) {

            imagePreview.src = event.target.result;
            imagePreview.classList.remove("d-none");

            if (placeholder) {
                placeholder.classList.add("d-none");
            }
        };

        reader.readAsDataURL(file);
    });

});
</script>

<?php require_once "../includes/footer.php"; ?>

