<?php

session_start();

require_once "../config/database.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare(
        "SELECT * FROM users WHERE email = ?"
    );

    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 1) {

        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] === 'admin') {

                header("Location: ../admin/dashboard.php");

            } elseif ($user['role'] === 'recruiter') {

                header("Location: ../recruiter/dashboard.php");

            } else {

                header("Location: ../candidate/dashboard.php");
            }

            exit;

        } else {

            $error = "Invalid email or password.";
        }

    } else {

        $error = "Invalid email or password.";
    }
}

require_once "../includes/header.php";
require_once "../includes/navbar.php";
?>

<div class="login-page">

    <div class="login-wrapper">

        <div class="login-card">

            <!-- Login Header -->
            <div class="login-header">

                <div class="login-logo">
                    JobVala
                </div>

                <p>Find the Right Talent. Build the Future.</p>

            </div>

            <!-- Login Form -->
            <div class="login-body">

                <h2 class="login-title">Welcome Back!</h2>

                <p class="login-subtitle">
                    Login to continue to your JobVala account.
                </p>

                <?php if ($error): ?>

                    <div class="alert alert-danger login-alert">
                        <?php echo htmlspecialchars($error); ?>
                    </div>

                <?php endif; ?>

                <form method="POST">

                    <!-- Email -->
                    <div class="login-field">

                        <label for="email" class="login-label">
                            Email Address
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="login-input"
                            placeholder="Enter your email address"
                            autocomplete="email"
                            required
                        >

                    </div>

                    <!-- Password -->
                    <div class="login-field">

                        <label for="password" class="login-label">
                            Password
                        </label>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="login-input"
                            placeholder="Enter your password"
                            autocomplete="current-password"
                            required
                        >

                    </div>

                    <!-- Login Button -->
                    <button type="submit" class="login-submit">
                        Login to JobVala
                    </button>

                </form>

                <!-- Registration Link -->
                <div class="login-footer">

                    Don't have an account?

                    <a href="../register.php">
                        Create an Account
                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

<?php require_once "../includes/footer.php"; ?>