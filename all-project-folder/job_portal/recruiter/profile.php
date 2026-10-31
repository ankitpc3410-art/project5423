<?php
session_start();

require_once "../config/database.php";
require_once "../includes/auth_check.php";

requireRole('recruiter');

$user_id = (int) ($_SESSION['user_id'] ?? 0);
$message = '';

// Fetch recruiter profile.
$stmt = $conn->prepare("SELECT * FROM recruiter_profiles WHERE user_id = ? LIMIT 1");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$profile = $stmt->get_result()->fetch_assoc() ?: [];
$stmt->close();

// Fetch company details.
$stmt = $conn->prepare("SELECT * FROM companies WHERE recruiter_id = ? LIMIT 1");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$company = $stmt->get_result()->fetch_assoc() ?: [];
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phone = trim($_POST['phone'] ?? '');
    $designation = trim($_POST['designation'] ?? '');
    $company_name = trim($_POST['company_name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $website = trim($_POST['website'] ?? '');
    $location = trim($_POST['location'] ?? '');

    // Keep current logo unless a valid replacement is uploaded.
    $logoName = !empty($company['logo']) ? basename($company['logo']) : null;
    $newLogoPath = null;
    $oldLogoName = $logoName;
    $uploadDir = __DIR__ . '/../uploads/company_logos/';

    if ($company_name === '') {
        $message = 'Company name is required.';
    } elseif ($website !== '' && !filter_var($website, FILTER_VALIDATE_URL)) {
        $message = 'Please enter a valid website URL, including https://.';
    } elseif (isset($_FILES['logo']) && $_FILES['logo']['error'] !== UPLOAD_ERR_NO_FILE) {
        $uploadError = $_FILES['logo']['error'];

        if ($uploadError !== UPLOAD_ERR_OK) {
            $message = 'Logo upload failed. Please try again.';
        } elseif (!is_uploaded_file($_FILES['logo']['tmp_name'])) {
            $message = 'Invalid logo upload.';
        } elseif ($_FILES['logo']['size'] > 2 * 1024 * 1024) {
            $message = 'Logo size must not exceed 2 MB.';
        } else {
            $tmpName = $_FILES['logo']['tmp_name'];
            $imageInfo = @getimagesize($tmpName);
            $mimeType = $imageInfo['mime'] ?? '';
            $allowedTypes = [
                'image/jpeg' => 'jpg',
                'image/png'  => 'png',
                'image/webp' => 'webp'
            ];

            if (!isset($allowedTypes[$mimeType])) {
                $message = 'Only JPG, PNG, and WEBP image files are allowed.';
            } elseif (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true) && !is_dir($uploadDir)) {
                $message = 'Could not create the company logo upload folder.';
            } elseif (!is_writable($uploadDir)) {
                $message = 'The company logo upload folder is not writable.';
            } else {
                $logoName = bin2hex(random_bytes(16)) . '.' . $allowedTypes[$mimeType];
                $newLogoPath = $uploadDir . $logoName;
                if (!move_uploaded_file($tmpName, $newLogoPath)) {
                    $message = 'Could not save the uploaded logo.';
                    $newLogoPath = null;
                    $logoName = $oldLogoName;
                }
            }
        }
    }

    if ($message === '') {
        $transactionStarted = false;
        try {
            $conn->begin_transaction();
            $transactionStarted = true;

            // Insert/update recruiter profile.
            if (!empty($profile)) {
                $stmt = $conn->prepare("UPDATE recruiter_profiles SET phone = ?, designation = ?, company_name = ? WHERE user_id = ?");
                $stmt->bind_param("sssi", $phone, $designation, $company_name, $user_id);
            } else {
                $stmt = $conn->prepare("INSERT INTO recruiter_profiles (user_id, phone, designation, company_name) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("isss", $user_id, $phone, $designation, $company_name);
            }
            $stmt->execute();
            $stmt->close();

            // Insert/update company row, including its logo filename.
            if (!empty($company)) {
                $company_id = (int) $company['id'];
                $stmt = $conn->prepare("UPDATE companies SET company_name = ?, description = ?, website = ?, location = ?, logo = ? WHERE id = ? AND recruiter_id = ?");
                $stmt->bind_param("sssssii", $company_name, $description, $website, $location, $logoName, $company_id, $user_id);
            } else {
                $stmt = $conn->prepare("INSERT INTO companies (recruiter_id, company_name, description, website, location, logo) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("isssss", $user_id, $company_name, $description, $website, $location, $logoName);
            }
            $stmt->execute();
            $stmt->close();

            $conn->commit();
            $transactionStarted = false;

            // Delete previous logo only after successful database commit.
            if ($newLogoPath !== null && $oldLogoName && $oldLogoName !== $logoName) {
                $oldPath = $uploadDir . basename($oldLogoName);
                if (is_file($oldPath)) {
                    @unlink($oldPath);
                }
            }

            header('Location: profile.php?success=1');
            exit;
        } catch (Throwable $e) {
            if ($transactionStarted) {
                $conn->rollback();
            }
            if ($newLogoPath !== null && is_file($newLogoPath)) {
                @unlink($newLogoPath);
            }
            error_log('Recruiter profile update failed: ' . $e->getMessage());
            $message = 'Unable to save your profile. Check the database table structure and try again.';
        }
    }

    // Preserve submitted values if validation/saving fails.
    $profile['phone'] = $phone;
    $profile['designation'] = $designation;
    $profile['company_name'] = $company_name;
    $company['company_name'] = $company_name;
    $company['description'] = $description;
    $company['website'] = $website;
    $company['location'] = $location;
    $company['logo'] = $logoName;
}

require_once "../includes/header.php";
require_once "../includes/navbar.php";
?>

<div class="container mt-5 mb-5 bg-dark text-white shadow rounded" style="margin-bottom: 30px; padding: 40px;">
    <h2 class="mb-4" >Recruiter Profile</h2>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">Profile updated successfully.</div>
    <?php endif; ?>

    <?php if ($message !== ''): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></div>
    <?php endif; ?>

    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Personal &amp; Company Information</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="profile.php" enctype="multipart/form-data">
                <div class="mb-4">
                    <label for="logo" class="form-label">Company Logo</label>
                    <?php if (!empty($company['logo'])): ?>
                        <div class="mb-3">
                            <img
                                src="../uploads/company_logos/<?php echo rawurlencode(basename($company['logo'])); ?>"
                                alt="Company Logo"
                                class="img-thumbnail"
                                style="width:120px;height:120px;object-fit:contain;"
                            >
                        </div>
                    <?php endif; ?>
                    <input type="file" name="logo" id="logo" class="form-control" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">
                    <small class="text-muted">JPG, PNG, or WEBP. Maximum size: 2 MB. Leave empty to keep the current logo.</small>
                </div>

                <div class="mb-3">
                    <label for="company_name" class="form-label">Company Name <span class="text-danger">*</span></label>
                    <input type="text" id="company_name" name="company_name" class="form-control" maxlength="255" required value="<?php echo htmlspecialchars($company['company_name'] ?? $profile['company_name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="tel" id="phone" name="phone" class="form-control" value="<?php echo htmlspecialchars($profile['phone'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                </div>

                <div class="mb-3">
                    <label for="designation" class="form-label">Designation</label>
                    <input type="text" id="designation" name="designation" class="form-control" value="<?php echo htmlspecialchars($profile['designation'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Company Description</label>
                    <textarea id="description" name="description" class="form-control" rows="4"><?php echo htmlspecialchars($company['description'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="website" class="form-label">Company Website</label>
                    <input type="url" id="website" name="website" class="form-control" placeholder="https://example.com" value="<?php echo htmlspecialchars($company['website'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                </div>

                <div class="mb-3">
                    <label for="location" class="form-label">Company Location</label>
                    <input type="text" id="location" name="location" class="form-control" placeholder="Enter company location" value="<?php echo htmlspecialchars($company['location'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                </div>

                <button type="submit" class="btn btn-primary">Save Profile</button>
                <a href="profile.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>

<?php require_once "../includes/footer.php"; ?>
