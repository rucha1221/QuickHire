<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse all Jobs</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body style="overflow-x: hidden;">
    <?php
  include("auth.php");
  include("db_connect.php");
  if(isset($_SESSION["user_id"])){
    $user_id=$_SESSION["user_id"];
  }
  else{
    die("User not logged in.");
  }
  $sql="select * from jobs order by created_at desc";
  $result=mysqli_query($conn,$sql);
     $desg="";
     $desgErr="";
     $location="";
     $locationErr="";

     if($_SERVER["REQUEST_METHOD"]=="POST"){
      $desg=isset($_POST["desg"]) ? trim($_POST["desg"]) : "";
      $location=isset($_POST["location"]) ? trim($_POST["location"]) : "";
      
      if(empty($desg)){
        $desgErr="";
      }
      else if(!preg_match("/^[A-Za-z ]+$/",$desg)){
        $desgErr="Only Letters are Allowed.";
      }

      if(empty($location)){
        $locationErr="";
      }
      else if(!preg_match("/^[A-Za-z ]+$/",$location)){
        $locationErr="Only Letters are Allowed.";
      }

      if(empty($desgErr) && empty($locationErr)){
        $desg = mysqli_real_escape_string($conn, $desg);
        $location = mysqli_real_escape_string($conn, $location);

        $sql = "SELECT * FROM jobs 
                WHERE job_title LIKE '%$desg%' 
                AND job_location LIKE '%$location%'";
        $result = mysqli_query($conn, $sql);
    }
     }
  ?>
  <?php include 'headerjobseeker.php'; ?>
    <h1 style="text-align: center; margin-top: 20px;">Find the right job by entering your preferred role or skill.</h1>

  <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" class="search-bar">
    <input type="text" name="desg" placeholder="Enter Job Title">
    <span style="color:red;"><?php echo "<br>" .$desgErr; ?></span>
    <input type="text" name="location" placeholder="Enter Location">
    <span style="color:red;"><?php echo "<br>" .$locationErr; ?></span>
    <button type="submit">Search</button>
  </form>

  <div class="job-container">
  <?php  
    if(mysqli_num_rows($result) > 0){
        while($row=mysqli_fetch_assoc($result)){
  ?>
    <div class="mini-jobs">
        <h1>Title: <?php echo $row["job_title"]; ?></h1>
        <h2>Company: <?php echo $row["company_name"]; ?></h2>
        <h3>Location: <?php echo $row["job_location"]; ?></h3>
        <h3>Salary Range: <?php echo $row["salary_range"];  ?></h3>
        <h3>Apply by: <?php echo $row["application_deadline"];  ?></h3>
        <h3>Posted on: <?php echo date("d-m-Y", strtotime($row["created_at"])); ?></h3>
        <form action="job_details.php" method="GET">
        <input type="hidden" name="job_id" value="<?php echo $row["job_id"]; ?>">
        <button type="submit" class="view">View Details</button>
        </form>
    </div>
    <?php  
        }
    }
    else{
        echo "<h2 style='text-align: center; margin-top: 50px;'>No jobs found</h2>";
    }
    ?>
  </div>
</body>
</html>