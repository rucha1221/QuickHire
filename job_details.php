<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>job_details</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>
    <?php
  include("auth.php");
  include("db_connect.php");
  include ('headerjobseeker.php');

  if(isset($_SESSION["user_id"])){
    $user_id=$_SESSION["user_id"];
  }
  else{
    die("User not logged in.");
  }
  
  if(isset($_GET['job_id'])){
    $job_id = $_GET['job_id'];

    $sql = "SELECT * FROM jobs WHERE job_id='$job_id'";
    $result = mysqli_query($conn, $sql);

    if($result && mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
    } else {
        echo "Job not found";
        exit();
    }
} else {
    echo "No job id received";
    exit();
}
  ?>

   <div class="section1">
    <h1>Job Title: <?php echo $row['job_title']; ?></h1>
    <h2>Company: <?php echo $row['company_name']; ?></h2>

    <div class="grid">
        <div class="item"><span>Location :</span> <?php echo $row['job_location']; ?></div>
        <div class="item"><span>Salary Range :</span> <?php echo $row['salary_range']; ?></div>
        <div class="item"><span>Apply By :</span> <?php echo date("d-m-Y", strtotime($row['application_deadline'])); ?></div>
        <div class="item"><span>Posted On :</span> <?php echo date("d-m-Y", strtotime($row['created_at'])); ?></div>
    </div>

    <div class="line"></div>

    <div class="grid">
        <div class="item"><span>Company Email :</span> <?php echo $row['company_email']; ?></div>
        <div class="item"><span>Work Mode :</span> <?php echo $row['work_mode']; ?></div>
        <div class="item"><span>Required Experience :</span> <?php echo $row['required_experience']; ?></div>
        <div class="item"><span>Openings :</span> <?php echo $row['number_of_vacancies']; ?></div>
        <div class="item"><span>Industry Type :</span> <?php echo $row['industry_type']; ?></div>
        <div class="item"><span>Qualification :</span> <?php echo $row['qualification']; ?></div>
        <div class="item"><span>Skills :</span> <?php echo $row['required_skills']; ?></div>
    </div>

    <div class="line"></div>

    <div class="major-box">
        <h3>Job Description</h3>
        <p><?php echo $row['job_description']; ?></p>

        <h3>Roles and Responsibilities</h3>
        <p><?php echo $row['roles_responsibilities']; ?></p>
    </div>

    <?php
$deadline = $row['application_deadline'];
$currentDate = date("Y-m-d");

if ($currentDate <= $deadline) {
?>
    <a href="apply.php?job_id=<?php echo $row['job_id']; ?>">
        <button type="button" class="apply-btn">Apply Now</button>
    </a>
<?php
} else {
?>
    <button type="button" disabled style="background-color: gray; cursor: not-allowed;" class="apply-btn">
        Apply Closed
    </button>
    <p style="color:red; margin-top:5px;">Application deadline has passed.</p>
<?php
}
?>
</body>
</html>