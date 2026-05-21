<?php
include ('auth.php');
include("db_connect.php");
include ('headerjobseeker.php');

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM job_seeker_profile WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
} else {
    echo "Profile not found";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Seeker Profile</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<div class="side">
        <h2>User Profile</h2>
        <a href="seekerprofile.php?user_id=<?php echo $row['user_id']; ?>" class="apply-btn">Edit Profile</a>
     </div>
<div class="profile-container">

    <div class="left-card">
        <div class="profile-image">
            <img src="upload/<?php echo $row['image']; ?>" alt="Profile Image" width="300" height="300">
        </div>

        <h2><?php echo $row['full_name']; ?></h2>
        <p class="role"><?php echo $row['desired_role']; ?></p>
        <p class="location">
            <i class="fa-solid fa-location-dot"></i>
            <?php echo $row['location']; ?>
        </p>

        <div class="quick-info">
            <p><strong>Experience:</strong> <?php echo $row['experience']; ?></p>
            <p><strong>Qualification:</strong> <?php echo $row['qualification']; ?></p>
            <p><strong>Graduation Year:</strong> <?php echo $row['graduation_year']; ?></p>
        </div>

        <div class="tag-box">
            <?php
            $skills = explode(",", $row['skills']);
            foreach ($skills as $skill) {
                echo "<span>" . trim($skill) . "</span>";
            }
            ?>
        </div>
    </div>

    <div class="right-section">

        <div class="top-card">
            <h3>Personal Information</h3>

            <div class="info-grid">
                <div>
                    <label>Full Name</label>
                    <p><?php echo $row['full_name']; ?></p>
                </div>

                <div>
                    <label>Email Address</label>
                    <p><?php echo $row['email_address']; ?></p>
                </div>

                <div>
                    <label>Mobile Number</label>
                    <p><?php echo $row['mobile_number']; ?></p>
                </div>

                <div>
                    <label>Location</label>
                    <p><?php echo $row['location']; ?></p>
                </div>

                <div>
                    <label>Desired Role</label>
                    <p><?php echo $row['desired_role']; ?></p>
                </div>

                <div>
                    <label>Experience</label>
                    <p><?php echo $row['experience']; ?></p>
                </div>
            </div>
        </div>

        <div class="bottom-grid">

            <div class="card">
                <h3>Education Details</h3>
                <div class="details-list">
                    <p><strong>Qualification:</strong> <?php echo $row['qualification']; ?></p>
                    <p><strong>College Name:</strong> <?php echo $row['college_name']; ?></p>
                    <p><strong>Specialization:</strong> <?php echo $row['specialization']; ?></p>
                    <p><strong>Graduation Year:</strong> <?php echo $row['graduation_year']; ?></p>
                </div>
            </div>

            <div class="card">
                <h3>Certificates</h3>
                <div class="tag-box">
                    <?php
                    $certificates = explode(",", $row['certificates']);
                    foreach ($certificates as $certificate) {
                        echo "<span>" . trim($certificate) . "</span>";
                    }
                    ?>
                </div>
            </div>

            <div class="card full-width">
                <h3>Skills</h3>
                <div class="tag-box">
                    <?php
                    $skills = explode(",", $row['skills']);
                    foreach ($skills as $skill) {
                        echo "<span>" . trim($skill) . "</span>";
                    }
                    ?>
                </div>
            </div>

            <div class="card full-width">
                <h3>About Me</h3>
                <p class="about-text"><?php echo $row['about_me']; ?></p>
            </div>

            <div class="card full-width">
                <h3>Profile Created</h3>
                <p class="about-text"><?php echo $row['created_at']; ?></p>
            </div>

        </div>

    </div>
</div>

</body>
</html>