<?php
require_once "config/database.php";
require_once "includes/header.php";
require_once "includes/navbar.php";
?>

<div class="container mt-5">

    <section class="job-portal-hero text-center mb-5">
        <span class="hero-eyebrow">YOUR NEXT OPPORTUNITY STARTS HERE</span>
        <h1 class="display-4 fw-bold mt-3">Find Work That <span>Moves You Forward.</span></h1>
        <p class="lead mx-auto">Discover opportunities that match your skills, connect with forward-thinking employers, and take the next step in your career.</p>
        <div class="d-flex justify-content-center flex-wrap gap-3 mt-4">
            <a href="candidate/jobs.php" class="btn btn-success btn-lg">Explore Jobs</a>
            <a href="auth/register.php" class="btn btn-outline-light btn-lg hero-secondary-btn">Create Your Profile</a>
        </div>
        <div class="hero-trust-line mt-4">Opportunities for freshers, experienced professionals, and ambitious teams.</div>
    </section>

    <!-- <div class="text-center">


        <h1 class="display-4">
            Find Your Dream Job
        </h1>

        <p class="lead">
            Search jobs and connect with top companies.
        </p>

        <a href="auth/register.php"
           class="btn btn-primary">
            Get Started
        </a>

        <a href="auth/login.php"
           class="btn btn-outline-primary">
            Login
        </a>

    </div> -->
<!-- slidebar start-->
 <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="..." class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="..." class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="..." class="d-block w-100" alt="...">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
 <!-- slidebar end -->
    <hr class="my-5">

    <!-- <h2 class="text-center mb-4">
        Latest Jobs
    </h2> -->

    <div class="row">

        <?php

        $result = $conn->query(
            "SELECT jobs.*, companies.company_name
             FROM jobs
             LEFT JOIN companies
             ON jobs.company_id = companies.id
             ORDER BY jobs.created_at DESC
             LIMIT 6"
        );

        while ($job = $result->fetch_assoc()):

        ?>

        <div class="col-md-4 mb-4">

            <div class="card h-100 shadow-sm">

                <div class="card-body">

                    <h5>
                        <?php echo htmlspecialchars($job['title']); ?>
                    </h5>

                    <p>
                        <strong>
                            <?php
                            echo htmlspecialchars(
                                $job['company_name'] ?? 'Company'
                            );
                            ?>
                        </strong>
                    </p>

                    <p>
                        <?php echo htmlspecialchars($job['location']); ?>
                    </p>

                    <p>
                        <?php echo htmlspecialchars($job['salary']); ?>
                    </p>

                    <a href="candidate/jobs.php?id=<?php echo $job['id']; ?>"
                       class="btn btn-primary">
                        View Job
                    </a>

                </div>

            </div>

        </div>

        <?php endwhile; ?>

    </div>

    <section class="how-it-works my-5">
        <div class="section-intro text-center mb-4">
            <span class="section-kicker">A SIMPLE WAY FORWARD</span>
            <h2 class="fw-bold mt-2">Your next role is closer than you think</h2>
            <p class="text-muted">A straightforward path from searching to starting your next chapter.</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="info-card h-100">
                    <span class="info-number">01</span>
                    <h4>Create Your Profile</h4>
                    <p>Showcase your experience, skills, and career goals so employers can understand what you bring to the team.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-card h-100">
                    <span class="info-number">02</span>
                    <h4>Explore Opportunities</h4>
                    <p>Browse available roles, compare job details, and focus on opportunities that fit your ambitions.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-card h-100">
                    <span class="info-number">03</span>
                    <h4>Apply With Confidence</h4>
                    <p>Take the next step by applying for roles that match your strengths and professional interests.</p>
                </div>
            </div>
        </div>
    </section>

</div>

<?php require_once "includes/footer.php"; ?>