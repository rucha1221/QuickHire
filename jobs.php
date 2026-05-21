<?php
include("auth.php");
include("db_connect.php");

if(isset($_SESSION["user_id"])){
    $user_id = $_SESSION["user_id"];
}
else{
    die("User not logged in.");
}
$desg="";
     $desgErr="";
     $location="";
     $locationErr="";

     if($_SERVER["REQUEST_METHOD"]=="POST"){
      $desg=isset($_POST["desg"]) ? trim($_POST["desg"]) : "";
      $location=isset($_POST["location"]) ? trim($_POST["location"]) : "";
      
      if(empty($desg)){
        $desgErr="Designation is Mandatory.";
      }
      else if(!preg_match("/^[A-Za-z ]+$/",$desg)){
        $desgErr="Only Letters are Allowed.";
      }

      if(empty($location)){
        $locationErr="Location is Mandatory.";
      }
      else if(!preg_match("/^[A-Za-z ]+$/",$location)){
        $locationErr="Only Letters are Allowed.";
      }
     }
/* get user's preferred role */
$preferred_role = "";

$user_sql = "SELECT * FROM job_seeker_profile WHERE user_id='$user_id'";
$user_result = mysqli_query($conn, $user_sql);

if($user_result && mysqli_num_rows($user_result) > 0){
    $user_row = mysqli_fetch_assoc($user_result);
    $preferred_role = isset($user_row["desired_role"]) ? trim($user_row["desired_role"]) : "";
}

/* recommended jobs by job title */
if(!empty($preferred_role)){
    $sql = "SELECT * FROM jobs
            WHERE job_title LIKE '%$preferred_role%'
            ORDER BY created_at DESC";
}
else{
    $sql = "SELECT * FROM jobs ORDER BY created_at DESC";
}

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recommended Jobs</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include("headerjobseeker.php"); ?>
<button type="submit" class="browse"><a href="tablejobdp.php">Browse All Jobs</a></button>
<h1 style="text-align:center; margin-top:30px;">Recommended Jobs For You</h1>

<div class="container">
    <div class="main-container">
        <div class="jobs">
            <?php
            if($result && mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
            ?>
            <div class="box-job">
                <h1>Title: <?php echo $row["job_title"]; ?></h1>
                <h2>Company: <?php echo $row["company_name"]; ?></h2>
                <h3>Location: <?php echo $row["job_location"]; ?></h3>
                <h3>Salary Range: <?php echo $row["salary_range"]; ?></h3>
                <h3>Apply By: <?php echo $row["application_deadline"]; ?></h3>
                <h3>Posted On: <?php echo date("d-m-Y", strtotime($row["created_at"])); ?></h3>

                <form action="job_details.php" method="GET">
                    <input type="hidden" name="job_id" value="<?php echo $row["job_id"]; ?>">
                    <button type="submit" class="view">View Details</button>
                </form>
            </div>
            <?php
                }
            }
            else{
                echo "<h2>No recommended jobs found</h2>";
            }
            ?>
        </div>
    </div>
</div>

<?php include("footer.php"); ?>

</body>
</html>