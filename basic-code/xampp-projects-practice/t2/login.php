
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - TaskFlow</title>

    <link rel="stylesheet" href="p1.css">
</head>

<body class="auth-body">

<div class="auth-container">

    <div class="auth-card">

        <div class="auth-logo">
            <div class="logo-icon">✓</div>

            <div>
                <h1>TaskFlow</h1>
                <p>Task Manager</p>
            </div>
        </div>


        <div class="auth-header">
            <h2>Welcome Back</h2>
            <p>Login to manage your tasks.</p>
        </div>


        <?php if ($error): ?>

            <div class="alert error">
                <?= htmlspecialchars($error) ?>
            </div>

        <?php endif; ?>


        <form
            method="POST"
            action="loginb.php"
            class="auth-form"
        >

            <div class="form-group">
                <label for="email">Email</label>

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
                <label for="password">Password</label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Enter your password"
                    required
                    autocomplete="current-password"
                >
            </div>


            <button type="submit" class="primary-btn full-width">
                Login
            </button>

        </form>


        <p class="auth-footer">
            Don't have an account?
            <a href="register.php">Create Account</a>
        </p>

    </div>

</div>

</body>
</html>
