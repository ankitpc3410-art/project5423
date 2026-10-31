<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">

        <a class="navbar-brand" href="#">
      <img src="image_data_of_site/logo3.png" alt="logo" width="30" height="24">
    </a>

        <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav ms-auto">

                <li class="nav-item">
                    <a class="nav-link"
                       href="/job_portal/index.php">
                        Home
                    </a>
                </li>

                <?php if (isset($_SESSION['user_id'])): ?>

                    <?php if ($_SESSION['role'] === 'candidate'): ?>

                        <li class="nav-item">
                            <a class="nav-link"
                               href="/job_portal/candidate/dashboard.php">
                                Dashboard
                            </a>
                        </li>

                    <?php elseif ($_SESSION['role'] === 'recruiter'): ?>

                        <li class="nav-item">
                            <a class="nav-link"
                               href="/job_portal/recruiter/dashboard.php">
                                Dashboard
                            </a>
                        </li>

                    <?php elseif ($_SESSION['role'] === 'admin'): ?>

                        <li class="nav-item">
                            <a class="nav-link"
                               href="/job_portal/admin/dashboard.php">
                                Admin
                            </a>
                        </li>

                    <?php endif; ?>

                    <li class="nav-item">
                        <a class="nav-link"
                           href="/job_portal/auth/logout.php">
                            Logout
                        </a>
                    </li>

                <?php else: ?>

                    <li class="nav-item">
                        <a class="nav-link"
                           href="/job_portal/auth/login.php">
                            Login
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link"
                           href="/job_portal/auth/register.php">
                            Register
                        </a>
                    </li>

                <?php endif; ?>

            </ul>

        </div>
    </div>
</nav>