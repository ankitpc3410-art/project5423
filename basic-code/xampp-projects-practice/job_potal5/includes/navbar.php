<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<nav class="navbar navbar-expand-lg navbar-light site-navbar sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="/job_portal/index.php" aria-label="Jobvala home">
            <img src="/job_portal/image_data_of_site/logo2.png" alt="Jobvala" class="brand-logo">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                <li class="nav-item"><a class="nav-link" href="/job_portal/index.php">Home</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php if (($_SESSION['role'] ?? '') === 'candidate'): ?>
                        <li class="nav-item"><a class="nav-link" href="/job_portal/candidate/dashboard.php">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="/job_portal/candidate/jobs.php">Browse Jobs</a></li>
                    <?php elseif (($_SESSION['role'] ?? '') === 'recruiter'): ?>
                        <li class="nav-item"><a class="nav-link" href="/job_portal/recruiter/dashboard.php">Dashboard</a></li>
                    <?php elseif (($_SESSION['role'] ?? '') === 'admin'): ?>
                        <li class="nav-item"><a class="nav-link" href="/job_portal/admin/dashboard.php">Admin</a></li>
                    <?php endif; ?>
                    <li class="nav-item"><a class="btn btn-nav-outline ms-lg-2" href="/job_portal/auth/logout.php">Logout</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="/job_portal/auth/login.php">Login</a></li>
                    <li class="nav-item"><a class="btn btn-nav-primary ms-lg-2" href="/job_portal/auth/register.php">Get Started <i class="bi bi-arrow-up-right ms-1"></i></a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
