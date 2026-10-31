<?php
require_once "config/database.php";
require_once "includes/header.php";
require_once "includes/navbar.php";

?>


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
      <img src="assets/images/slide1.jpg" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="assets/images/slide2.jpg" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="assets/images/slide3.jpg" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="assets/images/slide4.jpg" class="d-block w-100" alt="...">
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

    <!-- <div class="row">

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

                <div class="card-body " style="background-color:lightgray; border-radius: 20px;">

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
                       class="btn btn-dark">
                        View Job
                    </a>

                </div>

            </div>

        </div>

        <?php endwhile; ?>

    </div> -->
<!-- neww styling -->
  <!-- Search Jobs Section -->
    <section class="jobvala-search" id="jobvala-search">
        <div class="jobvala-container">
            <h2>Find Your Perfect Job</h2>

            <form class="jobvala-search-form" action="jobs.php" method="GET">
                <input type="text" name="keyword"
                       placeholder="Job title or keyword">

                <input type="text" name="location"
                       placeholder="Preferred location">

                <select name="category">
                    <option value="">All Categories</option>
                    <option value="IT">IT & Software</option>
                    <option value="Marketing">Marketing & Sales</option>
                    <option value="Finance">Finance & Accounting</option>
                    <option value="HR">Human Resources</option>
                    <option value="Design">Design & Creative</option>
                </select>

                <button type="submit" class="jobvala-btn">
                    Search Jobs
                </button>
            </form>
        </div>
    </section>

    <!-- Popular Categories -->
    <section class="jobvala-section">
        <div class="jobvala-container">

            <div class="jobvala-heading">
                <h2 style="color: white;">Explore Job Categories</h2>
                <p>Discover opportunities that match your skills and interests.</p>
            </div>

            <div class="jobvala-category-grid">

                <div class="jobvala-category shadow rounded p-3 mb-3" style="background-color: #f8f9fa; border-radius: 10px;">
                    <div class="jobvala-icon">💻</div>
                    <h3>IT & Software</h3>
                    <p>Development, programming and technology careers.</p>
                </div>

                <div class="jobvala-category shadow rounded p-3 mb-3" style="background-color: #f8f9fa; border-radius: 10px;">
                    <div class="jobvala-icon">📊</div>
                    <h3>Marketing & Sales</h3>
                    <p>Build your future in marketing and sales.</p>
                </div>

                <div class="jobvala-category shadow rounded p-3 mb-3" style="background-color: #f8f9fa; border-radius: 10px;">
                    <div class="jobvala-icon">💼</div>
                    <h3>Finance & Accounting</h3>
                    <p>Explore finance, banking and accounting roles.</p>
                </div>

                <div class="jobvala-category shadow rounded p-3 mb-3" style="background-color: #f8f9fa; border-radius: 10px;">
                    <div class="jobvala-icon">👥</div>
                    <h3>Human Resources</h3>
                    <p>Discover recruitment and HR opportunities.</p>
                </div>

                <div class="jobvala-category shadow rounded p-3 mb-3" style="background-color: #f8f9fa; border-radius: 10px;">
                    <div class="jobvala-icon">🎓</div>
                    <h3>Education</h3>
                    <p>Find teaching and training opportunities.</p>
                </div>

                <div class="jobvala-category shadow rounded p-3 mb-3" style="background-color: #f8f9fa; border-radius: 10px;">
                    <div class="jobvala-icon">🏥</div>
                    <h3>Healthcare</h3>
                    <p>Make a difference in healthcare careers.</p>
                </div>

                <div class="jobvala-category shadow rounded p-3 mb-3" style="background-color: #f8f9fa; border-radius: 10px;">
                    <div class="jobvala-icon">🎨</div>
                    <h3>Design & Creative</h3>
                    <p>Turn your creativity into a profession.</p>
                </div>

                <div class="jobvala-category shadow rounded p-3 mb-3" style="background-color: #f8f9fa; border-radius: 10px;">
                    <div class="jobvala-icon">🎧</div>
                    <h3>Customer Support</h3>
                    <p>Explore customer service opportunities.</p>
                </div>

            </div>
        </div>
    </section>

    <!-- Latest Jobs -->
    <section class="jobvala-section jobvala-jobs" id="latest-jobs">
        <div class="jobvala-container">

            <div class="jobvala-heading">
                <h2>Latest Job Openings</h2>
                <p>Take the next step toward your professional future.</p>
            </div>

            <div class="jobvala-job-grid">

                <div class="jobvala-job-card shadow rounded p-3 mb-3" style="background-color: #f8f9fa; border-radius: 10px;">
                    <h3>Web Developer</h3>
                    <p class="jobvala-company">Technology Company</p>
                    <p class="jobvala-job-info">📍 Lucknow, Uttar Pradesh</p>
                    <p class="jobvala-job-info">💰 ₹3–6 LPA</p>
                    <p class="jobvala-job-info">Experience: 0–2 Years</p>
                    <span class="jobvala-tag">Full-Time</span>
                    <a href="login.php" class="jobvala-btn">Apply Now</a>
                </div>

                <div class="jobvala-job-card shadow rounded p-3 mb-3" style="background-color: #f8f9fa; border-radius: 10px;">
                    <h3>Digital Marketing Executive</h3>
                    <p class="jobvala-company">Marketing Company</p>
                    <p class="jobvala-job-info">📍 New Delhi, India</p>
                    <p class="jobvala-job-info">💰 ₹2.5–5 LPA</p>
                    <p class="jobvala-job-info">Experience: 0–3 Years</p>
                    <span class="jobvala-tag">Full-Time</span>
                    <a href="login.php" class="jobvala-btn">Apply Now</a>
                </div>

                <div class="jobvala-job-card shadow rounded p-3 mb-3" style="background-color: #f8f9fa; border-radius: 10px;">
                    <h3>UI/UX Designer</h3>
                    <p class="jobvala-company">Creative Company</p>
                    <p class="jobvala-job-info">📍 Remote</p>
                    <p class="jobvala-job-info">💰 ₹4–8 LPA</p>
                    <p class="jobvala-job-info">Experience: 1–3 Years</p>
                    <span class="jobvala-tag">Remote</span>
                    <a href="login.php" class="jobvala-btn">Apply Now</a>
                </div>

            </div>

            <div class="jobvala-center">
                <a href="jobs.php" class="jobvala-btn">View All Jobs</a>
            </div>

        </div>
    </section>

    <!-- Why Choose JobVala -->
    <section class="jobvala-section">
        <div class="jobvala-container">

            <div class="jobvala-heading">
                <h2 style="color: white;">Why Choose JobVala?</h2>
                <p>Your career journey deserves the right platform.</p>
            </div>

            <div class="jobvala-feature-grid">

                <div class="jobvala-feature">
                    <div class="jobvala-icon">🔎</div>
                    <h3 style="color: white;">Easy Job Search</h3>
                    <p>Find opportunities by job title, location and career category.</p>
                </div>

                <div class="jobvala-feature">
                    <div class="jobvala-icon">🤝</div>
                    <h3 style="color: white;">Connect with Employers</h3>
                    <p>Discover employers seeking professionals with your skills.</p>
                </div>

                <div class="jobvala-feature">
                    <div class="jobvala-icon">🚀</div>
                    <h3 style="color: white;">Grow Your Career</h3>
                    <p>Explore new opportunities and move toward your career goals.</p>
                </div>

            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="jobvala-section jobvala-steps">
        <div class="jobvala-container">

            <div class="jobvala-heading">
                <h2>Get Hired in Three Simple Steps</h2>
                <p>Your next career opportunity starts here.</p>
            </div>

            <div class="jobvala-step-grid">

                <div class="jobvala-step">
                    <div class="jobvala-step-number">1</div>
                    <h3>Create Your Account</h3>
                    <p>Register and create your professional profile.</p>
                </div>

                <div class="jobvala-step">
                    <div class="jobvala-step-number">2</div>
                    <h3>Find the Right Job</h3>
                    <p>Explore opportunities based on your skills and interests.</p>
                </div>

                <div class="jobvala-step">
                    <div class="jobvala-step-number">3</div>
                    <h3>Apply with Confidence</h3>
                    <p>Submit your application and take the next step in your career.</p>
                </div>

            </div>
        </div>
    </section>

    <!-- Employers Call to Action -->
    <section class="jobvala-section jobvala-employer">
        <div class="jobvala-container">
            <h2>Find the Right Talent for Your Business</h2>
            <p>
                Connect with skilled professionals, discover talented candidates
                and build a stronger team with JobVala.
            </p>
            <a href="register.php" class="jobvala-btn">Post a Job</a>
        </div>
    </section>

    <!-- Career Advice -->
    <section class="jobvala-section jobvala-tips">
        <div class="jobvala-container">

            <div class="jobvala-heading">
                <h2>Career Tips & Advice</h2>
                <p>Learn new skills and prepare for your next opportunity.</p>
            </div>

            <div class="jobvala-tip-grid">

                <div class="jobvala-tip">
                    <h3>Build a Professional Resume</h3>
                    <p>Learn how to highlight your skills, qualifications and achievements.</p>
                    <a href="career-tips.php">Read More &rarr;</a>
                </div>

                <div class="jobvala-tip">
                    <h3>Prepare for Job Interviews</h3>
                    <p>Develop confidence and learn how to make a positive impression.</p>
                    <a href="career-tips.php">Read More &rarr;</a>
                </div>

                <div class="jobvala-tip">
                    <h3>Develop In-Demand Skills</h3>
                    <p>Discover how improving your skills can open new career opportunities.</p>
                    <a href="career-tips.php">Read More &rarr;</a>
                </div>

            </div>
        </div>
    </section>

    <!-- Newsletter -->
    <section class="jobvala-section jobvala-newsletter">
        <div class="jobvala-container">
            <h2 style="color: white;">Never Miss Your Next Opportunity</h2>
            <p>Stay updated with job opportunities and career advice.</p>

            <form class="jobvala-newsletter-form"
                  action="login.php" method="POST">

                <input type="email" name="email"
                       placeholder="Enter your email address" required>

                <button type="submit" class="jobvala-btn">
                    <a href="login.php" style="color: white; text-decoration: none;" onclick="return confirm('Please frist login...........')">Subscribe</a>
                </button>
            </form>
        </div>
    </section>
 <!-- end styling -->
</div>

<?php require_once "includes/footer.php"; ?>