<?php
require_once "config/database.php";
require_once "includes/header.php";
require_once "includes/navbar.php";

$search = trim($_GET['search'] ?? '');
$logoColumnExists = false;
$columnCheck = $conn->query("SHOW COLUMNS FROM companies LIKE 'company_logo'");
if ($columnCheck && $columnCheck->num_rows > 0) {
    $logoColumnExists = true;
}
$logoSelect = $logoColumnExists ? 'companies.company_logo' : 'NULL AS company_logo';

$sql = "SELECT jobs.*, companies.company_name, $logoSelect
        FROM jobs
        LEFT JOIN companies ON jobs.company_id = companies.id";
if ($search !== '') {
    $sql .= " WHERE jobs.title LIKE ? OR jobs.location LIKE ? OR companies.company_name LIKE ?";
    $sql .= " ORDER BY jobs.created_at DESC LIMIT 12";
    $stmt = $conn->prepare($sql);
    $like = '%' . $search . '%';
    $stmt->bind_param('sss', $like, $like, $like);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql .= " ORDER BY jobs.created_at DESC LIMIT 6";
    $result = $conn->query($sql);
}
?>

<main>
    <section class="hero-section">
        <div class="hero-pattern" aria-hidden="true"></div>
        <div class="container hero-content">
            <div class="row align-items-center gy-5">
                <div class="col-lg-7">
                    <div class="eyebrow"><span class="eyebrow-dot"></span> YOUR NEXT CHAPTER STARTS HERE</div>
                    <h1>Find work that<br><span>moves you forward.</span></h1>
                    <p class="hero-copy">Discover opportunities that match your skills, ambitions, and the life you want to build.</p>
                    <form class="hero-search" method="GET" action="/job_portal/index.php" role="search">
                        <i class="bi bi-search search-icon" aria-hidden="true"></i>
                        <input type="search" name="search" value="<?php echo htmlspecialchars($search, ENT_QUOTES, 'UTF-8'); ?>" placeholder="Job title, company, or location" aria-label="Search jobs">
                        <button type="submit" class="btn search-submit">Search jobs <i class="bi bi-arrow-right ms-1"></i></button>
                    </form>
                    <div class="hero-trust"><i class="bi bi-check-circle-fill"></i> Explore opportunities and take the next step in your career.</div>
                </div>
                <div class="col-lg-5">
                    <div class="hero-visual" aria-label="Career opportunities illustration">
                        <div class="visual-orbit orbit-one"></div><div class="visual-orbit orbit-two"></div>
                        <div class="floating-card float-top"><span class="float-icon purple"><i class="bi bi-briefcase-fill"></i></span><span><strong>New opportunities</strong><small>Your next role is out there</small></span></div>
                        <div class="career-illustration"><div class="sun-shape"></div><div class="person-head"></div><div class="person-body"></div><div class="laptop"><div class="laptop-screen"><i class="bi bi-graph-up-arrow"></i><span></span><span></span></div><div class="laptop-base"></div></div></div>
                        <div class="floating-card float-bottom"><span class="float-icon green"><i class="bi bi-stars"></i></span><span><strong>Make your move</strong><small>Find a role that fits you</small></span></div>
                        <div class="visual-spark spark-one">✦</div><div class="visual-spark spark-two">✧</div>
                    </div>
                </div>
            </div>
            <div class="hero-bottom-line"><span>Find your fit</span><span class="line"></span><span>Build your future</span></div>
        </div>
    </section>

    <section class="quick-stats container" aria-label="Job portal highlights">
        <div class="stat-item"><span class="stat-icon"><i class="bi bi-compass"></i></span><div><strong>Explore</strong><small>Roles across industries</small></div></div>
        <div class="stat-item"><span class="stat-icon"><i class="bi bi-building"></i></span><div><strong>Connect</strong><small>Find your next team</small></div></div>
        <div class="stat-item"><span class="stat-icon"><i class="bi bi-rocket-takeoff"></i></span><div><strong>Grow</strong><small>Move your career forward</small></div></div>
    </section>

    <section class="jobs-section">
        <div class="container py-5">
            <div class="section-heading d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3">
                <div><span class="section-kicker">CAREER OPPORTUNITIES</span><h2><?php echo $search !== '' ? 'Search results' : 'Latest job openings'; ?></h2><p><?php echo $search !== '' ? 'Opportunities matching “' . htmlspecialchars($search, ENT_QUOTES, 'UTF-8') . '”.' : 'A fresh selection of opportunities to help you take the next step.'; ?></p></div>
                <a class="browse-link" href="/job_portal/candidate/jobs.php">Browse all jobs <i class="bi bi-arrow-up-right"></i></a>
            </div>

            <div class="row g-4 mt-1">
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($job = $result->fetch_assoc()): ?>
                        <?php
                        $companyName = $job['company_name'] ?? 'Company';
                        $logoPath = trim((string)($job['company_logo'] ?? ''));
                        $initial = function_exists('mb_substr') ? mb_substr($companyName, 0, 1, 'UTF-8') : substr($companyName, 0, 1);
                        ?>
                        <div class="col-md-6 col-xl-4">
                            <article class="job-card h-100">
                                <div class="job-card-top"><div class="company-logo-wrap">
                                    <?php if ($logoPath !== ''): ?>
                                        <img src="<?php echo htmlspecialchars($logoPath, ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($companyName, ENT_QUOTES, 'UTF-8'); ?> logo" class="company-logo" loading="lazy">
                                    <?php else: ?>
                                        <span class="company-logo-fallback"><?php echo htmlspecialchars(strtoupper($initial), ENT_QUOTES, 'UTF-8'); ?></span>
                                    <?php endif; ?>
                                </div><span class="job-type-label"><i class="bi bi-lightning-charge"></i> Opportunity</span></div>
                                <h3><?php echo htmlspecialchars($job['title'] ?? 'Untitled position', ENT_QUOTES, 'UTF-8'); ?></h3>
                                <p class="company-name"><?php echo htmlspecialchars($companyName, ENT_QUOTES, 'UTF-8'); ?></p>
                                <div class="job-meta"><span><i class="bi bi-geo-alt"></i><?php echo htmlspecialchars($job['location'] ?? 'Location not specified', ENT_QUOTES, 'UTF-8'); ?></span><span><i class="bi bi-cash-coin"></i><?php echo htmlspecialchars((string)($job['salary'] ?? 'Salary not specified'), ENT_QUOTES, 'UTF-8'); ?></span></div>
                                <div class="job-card-footer"><span class="job-footer-note"><i class="bi bi-people"></i> Take the next step</span><a href="/job_portal/candidate/jobs.php?id=<?php echo (int)$job['id']; ?>" class="job-view-btn" aria-label="View <?php echo htmlspecialchars($job['title'] ?? 'job', ENT_QUOTES, 'UTF-8'); ?>">View job <i class="bi bi-arrow-up-right"></i></a></div>
                            </article>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="col-12"><div class="empty-jobs"><span><i class="bi bi-search"></i></span><h3>No jobs found</h3><p><?php echo $search !== '' ? 'Try another title, company, or location.' : 'New opportunities will appear here when they are posted.'; ?></p><?php if ($search !== ''): ?><a href="/job_portal/index.php" class="btn btn-primary rounded-pill px-4">Clear search</a><?php endif; ?></div></div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <section class="bottom-cta"><div class="container"><div class="cta-panel"><div><span class="section-kicker">READY FOR WHAT'S NEXT?</span><h2>Your next opportunity could change everything.</h2><p>Start exploring and find a role that fits your goals.</p></div><a href="/job_portal/auth/register.php" class="btn cta-button">Create your account <i class="bi bi-arrow-right ms-2"></i></a></div></div></section>
</main>
<?php require_once "includes/footer.php"; ?>
