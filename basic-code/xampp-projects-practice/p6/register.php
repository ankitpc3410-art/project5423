
<?php
session_start();

if (isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit;
}

$error = $_GET["error"] ?? "";
?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Register - TaskFlow</title>

    <link rel="stylesheet" href="p1.css">

</head>

<body class="auth-body">

<div class="auth-container">

    <div class="auth-card">

        <div class="auth-logo">

            <div class="logo-icon">
                ✓
            </div>

            <div>
                <h1>TaskFlow</h1>
                <p>Task Manager</p>
            </div>

        </div>


        <div class="auth-header">

            <h2>Create Account</h2>

            <p>
                Create an account to start managing tasks.
            </p>

        </div>


        <?php if ($error): ?>

            <div class="alert error">
                <?= htmlspecialchars($error) ?>
            </div>

        <?php endif; ?>


        <form
            method="POST"
            action="backend/register.php"
            class="auth-form"
        >

            <div class="form-group">

                <label for="name">
                    Full Name
                </label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    placeholder="Enter your name"
                    required
                    autocomplete="name"
                >

            </div>


            <div class="form-group">

                <label for="email">
                    Email
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="Enter your email"
                    required
                    autocomplete="email"
                >

            </div>


            <div class="form-group">

                <label for="password">
                    Password
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Create a password"
                    required
                    minlength="6"
                    autocomplete="new-password"
                >

            </div>


            <div class="form-group">

                <label for="confirm_password">
                    Confirm Password
                </label>

                <input
                    type="password"
                    id="confirm_password"
                    name="confirm_password"
                    placeholder="Confirm your password"
                    required
                    minlength="6"
                    autocomplete="new-password"
                >

            </div>


            <button
                type="submit"
                class="primary-btn full-width"
            >
                Create Account
            </button>

        </form>


        <p class="auth-footer">

            Already have an account?

            <a href="login.php">
                Login
            </a>

        </p>

    </div>

</div>

</body>
</html>

