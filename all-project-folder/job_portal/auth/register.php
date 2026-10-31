<?php

session_start();

require_once "../config/database.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role'];

    if (empty($name) || empty($email) || empty($password)) {

        $message = "All fields are required.";

    } else {

        $check = $conn->prepare(
            "SELECT id FROM users WHERE email = ?"
        );

        $check->bind_param("s", $email);
        $check->execute();

        $result = $check->get_result();

        if ($result->num_rows > 0) {

            $message = "Email already registered.";

        } else {

            $hashedPassword = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            $stmt = $conn->prepare(
                "INSERT INTO users
                (name,email,password,role)
                VALUES (?,?,?,?)"
            );

            $stmt->bind_param(
                "ssss",
                $name,
                $email,
                $hashedPassword,
                $role
            );

            if ($stmt->execute()) {

                $message = "Registration successful. Please login.";

            } else {

                $message = "Registration failed.";
            }
        }
    }
}

require_once "../includes/header.php";
require_once "../includes/navbar.php";
?>

<div class="container mt-5">

   <div class="register-page">

    <div class="register-wrapper">

        <div class="register-card">

            <!-- Registration Header -->
            <div class="register-header">

                <div class="register-logo">
                    JobVala
                </div>

                <p>Find the Right Talent. Build the Future.</p>

            </div>

            <!-- Registration Form -->
            <div class="register-body">

                <h2 class="register-title">
                    Create Your Account
                </h2>

                <p class="register-subtitle">
                    Join JobVala and take the next step in your career.
                </p>

                <?php if ($message): ?>

                    <div class="alert alert-info register-message">
                        <?php echo htmlspecialchars($message); ?>

                        <?php if ($message === "Registration successful. Please login."): ?>
                            <br><br>
                            <a href="login.php"
                               style="color: #202124; font-weight: bold;">
                                Login to Your Account
                            </a>
                        <?php endif; ?>
                    </div>

                <?php endif; ?>

                <form method="POST">

                    <!-- Name -->
                    <div class="register-field">

                        <label for="name" class="register-label">
                            Full Name
                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            class="register-input"
                            placeholder="Enter your full name"
                            autocomplete="name"
                            required
                        >

                    </div>

                    <!-- Email -->
                    <div class="register-field">

                        <label for="email" class="register-label">
                            Email Address
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="register-input"
                            placeholder="Enter your email address"
                            autocomplete="email"
                            required
                        >

                    </div>

                    <!-- Password -->
                    <div class="register-field">

                        <label for="password" class="register-label">
                            Password
                        </label>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="register-input"
                            placeholder="Create a password"
                            autocomplete="new-password"
                            required
                        >

                    </div>

                    <!-- Role -->
                    <div class="register-field">

                        <label for="role" class="register-label">
                            Register As
                        </label>

                        <select
                            name="role"
                            id="role"
                            class="register-input"
                            required
                        >

                            <option value="candidate">
                                Candidate — Looking for a job
                            </option>

                            <option value="recruiter">
                                Recruiter — Hiring talent
                            </option>

                        </select>

                    </div>

                    <!-- Submit -->
                    <button type="submit" class="register-submit">
                        Create Account
                    </button>

                </form>

                <!-- Login Link -->
                <div class="register-footer">

                    Already have an account?

                    <a href="login.php">
                        Login Here
                    </a>

                </div>

                <p class="register-note">
                    By registering, you agree to use JobVala responsibly.
                </p>

            </div>

        </div>

    </div>

</div>

</div>

<?php require_once "../includes/footer.php"; ?>