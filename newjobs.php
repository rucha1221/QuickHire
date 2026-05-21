<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jobs</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <script>
      function toggleFilter(){
      document.getElementById("filterSidebar").classList.toggle("hidden");
      }
    </script>
  </head>
<body>
  <?php
  include("auth.php");
  include("db_connect.php");
  if(isset($_SESSION["user_id"])){
    $user_id=$_SESSION["user_id"];
  }
  else{
    die("User not logged in.");
  }
  $first_sql="select * from job_seeker_profile where user_id='$user_id'";
  $sql="select * from jobs";
  $result=mysqli_query($conn,$sql);
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
      else if(!preg_match("/^[A-Za-z]+$/",$desg)){
        $desgErr="Only Letters are Allowed.";
      }

      if(empty($location)){
        $locationErr="Location is Mandatory.";
      }
      else if(!preg_match("/^[A-Za-z]+$/",$location)){
        $locationErr="Only Letters are Allowed.";
      }
     }
  ?>
    <?php include 'headerjobseeker.php'; ?>
    <h1 style="text-align: center; margin-top: 20px;">Find the right job by entering your preferred role or skill.</h1>

  <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" class="search-bar">
    <input type="text" name="desg" placeholder="Enter designation">
    <span style="color:red;"><?php echo "<br>" .$desgErr; ?></span>
    <input type="text" name="location" placeholder="Enter location">
    <span style="color:red;"><?php echo "<br>" .$locationErr; ?></span>
    <button type="submit">Search</button>
  </form>

  <h1 style="margin-top: 40px; text-align: center; margin-bottom: -20px;">Recommended Jobs For You</h1>
  <button class="filter-btn" onclick="toggleFilter()">
<i class="bi bi-funnel"></i> Filters
</button>

<div class="container">
  <div class="main-container">

<div class="filter" id="filterSidebar">

<div class="form-group">
<h2>Experience</h2>
<label><input type="checkbox" name="exp[]" value="Fresher"> Fresher</label>
<label><input type="checkbox" name="exp[]" value="0-1 Years"> 0-1 Years</label>
<label><input type="checkbox" name="exp[]" value="2-3 Years"> 2-3 Years</label>
<label><input type="checkbox" name="exp[]" value="4-5 Years"> 4-5 Years</label>
</div>

<div class="form-group">
<h2>Salary</h2>
<label><input type="checkbox" name="salary[]" value="1-3 LPA"> 1 - 3 LPA</label>
<label><input type="checkbox" name="salary[]" value="3-5 LPA"> 3 - 5 LPA</label>
<label><input type="checkbox" name="salary[]" value="5-8 LPA"> 5 - 8 LPA</label>
<label><input type="checkbox" name="salary[]" value="8-12 LPA"> 8 - 12 LPA</label>
<label><input type="checkbox" name="salary[]" value="12+ LPA"> 12+ LPA</label>
</div>

<div class="form-group">
<h2>Work Mode</h2>
<label><input type="checkbox" name="work_mode[]" value="Onsite"> Onsite</label>
<label><input type="checkbox" name="work_mode[]" value="Remote"> Remote</label>
<label><input type="checkbox" name="work_mode[]" value="Hybrid"> Hybrid</label>
</div>
</div>

<div class="container">
    <div class="main-container">
        <div class="jobs">
            <script>
                alert("Complete your profile to receive personalized job recommendations.");
            </script>
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



</div>  

  <?php include 'footer.php'; ?>
</body>
</html>