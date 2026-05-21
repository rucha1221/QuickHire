<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recruiter Profile</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <?php
       include ('headerrecruiter.php');
       include ('db_connect.php');
       include ('auth.php');

       if(isset($_SESSION["user_id"])){
        $user_id=$_SESSION["user_id"];
        $sql = "SELECT * FROM recruiter_profile WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0){
    $row = mysqli_fetch_assoc($result);
}else{
    echo "<script>alert('Profile not found. Please complete your profile first.'); window.location.href='coprofile.php';</script>";
    exit();
}
       }
       else{
        die("User not logged in.");
       }
    ?>
     <div class="side">
        <h2>User Profile</h2>
        <a href="coprofile.php?user_id=<?php echo $row['user_id']; ?>" class="apply-btn">Edit Profile</a>
     </div>
    <div class="profile-container">

    <div class="left-card">
        <div class="company-logo">
            <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Company Logo">
        </div>

        <h2><?php echo $row['company_name']; ?></h2>
        <p class="industry"><?php echo $row['industry_type']; ?></p>
        <p class="location"><i class="fa-solid fa-location-dot"></i> <?php echo $row['company_location']; ?></p>

        <div class="small-info">
            <p><strong>Founded:</strong> <?php echo $row['founded_year']; ?></p>
            <p><strong>Company Size:</strong> <?php echo $row['company_size']; ?></p>
            <p><strong>Recruiter:</strong> <?php echo $row['recruiter_name']; ?></p>
            <p><strong>Designation:</strong> <?php echo $row['hr_designation']; ?></p>
        </div>

        <div class="tag-box">
            <?php
            $specialties = explode(",", $row['specialties']);
            foreach($specialties as $specialties){
                echo "<span>" . trim($specialties) . "</span>";
            }
            ?>
        </div>
    </div>

    <div class="right-section">

        <div class="top-card">
            <h3>Company Information</h3>
            <div class="info-grid">
                <div>
                    <label>Company Name</label>
                    <p><?php echo $row['company_name']; ?></p>
                </div>

                <div>
                    <label>Industry Type</label>
                    <p><?php echo $row['industry_type']; ?></p>
                </div>

                <div>
                    <label>Headquarters</label>
                    <p><?php echo $row['headquarters_location']; ?></p>
                </div>

                <div>
                    <label>Branches / Offices</label>
                    <p><?php echo $row['branches_offices']; ?></p>
                </div>

                <div>
                    <label>Company Email</label>
                    <p><?php echo $row['company_email']; ?></p>
                </div>

                <div>
                    <label>Contact Number</label>
                    <p><?php echo $row['contact_number']; ?></p>
                </div>

                <div>
                    <label>Company Website</label>
                    <p><?php echo $row['company_website']; ?></p>
                </div>

                <div>
                    <label>Website URL</label>
                    <p>
                        <a href="<?php echo $row['website_url']; ?>" target="_blank">
                            <?php echo $row['website_url']; ?>
                        </a>
                    </p>
                </div>

                <div>
                    <label>Created At</label>
                    <p><?php echo $row['created_at']; ?></p>
                </div>

                <div>
                    <label>Company Location</label>
                    <p><?php echo $row['company_location']; ?></p>
                </div>
            </div>
        </div>

        <div class="bottom-grid">

            <div class="card">
                <h3>Recruiter Details</h3>
                <div class="details-list">
                    <p><strong>Recruiter Name:</strong> <?php echo $row['recruiter_name']; ?></p>
                    <p><strong>HR Designation:</strong> <?php echo $row['hr_designation']; ?></p>
                    <p><strong>Email:</strong> <?php echo $row['company_email']; ?></p>
                    <p><strong>Contact:</strong> <?php echo $row['contact_number']; ?></p>
                    <p><strong>Location:</strong> <?php echo $row['company_location']; ?></p>
                </div>
            </div>

            <div class="card">
                <h3>About Company</h3>
                <p class="about-text"><?php echo $row['about_company']; ?></p>
            </div>

            <div class="card full-width">
                <h3>Specialties</h3>
                <div class="tag-box">
    <?php
    $specialties = explode(",", $row['specialties']);
    foreach($specialties as $specialty){
        echo "<span>" . trim($specialty) . "</span>";
    }
    ?>
</div>
            </div>

        </div>

    </div>
</div>

</body>
</html>