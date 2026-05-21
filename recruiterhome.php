<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recruiter Home Page</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>
    <?php
    include("auth.php");
    include("db_connect.php");
    ?>
    <?php include 'headerrecruiter.php'; ?>
    <div class="main">
        <div class="hero-img" style="background-image: url(https://i2.wp.com/www.roliedema.com/images/law-firm-interview-questions-01.png);"></div>
        <div class="main-title">
          <h1>Find the right talent to grow your company.</h1>
          <p class="title-1">Post jobs, review applications, and hire the best candidates with ease.</p>
        </div>
    </div>

    <h1 style="text-align: center;margin-top: 30px;">Recruiter Tools & Features</h1>
    <div class="recruiter-features">

    <div class="feature-box">
        <i class="bi bi-plus-circle"></i>
        <h3>Post a Job</h3>
        <p>Create and publish new job opportunities.</p>
    </div>

    <div class="feature-box">
        <i class="bi bi-briefcase"></i>
        <h3>Manage Jobs</h3>
        <p>Edit or delete your posted jobs easily.</p>
    </div>

    <div class="feature-box">
        <i class="bi bi-people"></i>
        <h3>View Applicants</h3>
        <p>Check candidates who applied for your jobs.</p>
    </div>

    <div class="feature-box">
        <i class="bi bi-bar-chart"></i>
        <h3>Hiring Reports</h3>
        <p>Track job performance and applications.</p>
    </div>
</div>
<?php include 'footer.php'; ?>
</body>
</html>