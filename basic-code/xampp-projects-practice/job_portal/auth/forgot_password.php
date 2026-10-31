<?php

session_start();

require_once "../config/database.php";

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email']);

    $stmt = $conn->prepare("
        SELECT id
        FROM users
        WHERE email=?
    ");

    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 1) {

        $newPassword = substr(
            str_shuffle(
                "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"
            ),
            0,
            10
        );

        $hashedPassword = password_hash(
            $newPassword,
            PASSWORD_DEFAULT
        );

        $stmt = $conn->prepare("
            UPDATE users
            SET password=?
            WHERE email=?
        ");

        $stmt->bind_param(
            "ss",
            $hashedPassword,
            $email
        );

        $stmt->execute();

        $message =
            "Password reset successfully. New password: "
            . $newPassword;

    } else {

        $message = "Email address not found.";
    }
}

require_once "../includes/header.php";
require_once "../includes/navbar.php";
?>

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-5">

            <div class="card shadow">

                <div class="card-body">

                    <h3 class="text-center">
                        Forgot Password
                    </h3>

                    <?php if ($message): ?>

                        <div class="alert alert-info mt-3">
                            <?php echo htmlspecialchars($message); ?>
                        </div>

                    <?php endif; ?>

                    <form method="POST" class="mt-4">

                        <div class="mb-3">

                            <label>Email Address</label>

                            <input type="email"
                                   name="email"
                                   class="form-control"
                                   required>

                        </div>

                        <button class="btn btn-primary w-100">
                            Reset Password
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

<?php require_once "../includes/footer.php"; ?>