<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Seeker Home Page</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    </head>
<body>
    <?php
    include("auth.php");
    include("db_connect.php");
    ?>
    <?php include 'headerjobseeker.php'; ?>
    <div class="main">
        <div class="hero-img"></div>
        <div class="main-title">
          <h1>Discover Opportunities That Match Your Skills.</h1>
          <p class="title-1">Start your journey today and turn your career goals into reality.</p>
        </div>
    </div>

    <h1 style="text-align: center;margin-top: 70px;">BROWSE JOBS BY CATEGORIES</h1>
    <div class="cat">
        <div class="catbox">
            <i class="bi bi-currency-dollar"></i>
            <h2>Accounting/Finanace</h3>
        </div>
        <div class="catbox">
            <i class="bi bi-person-badge"></i>
            <h2>HR/Org. Development</h3>
        </div>
        <div class="catbox">
            <i class="bi bi-gear"></i>
            <h2>Engineer/Architect</h3>
        </div>
        <div class="catbox">
            <i class="bi bi-palette"></i>
            <h2>Design/Creative</h3>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>