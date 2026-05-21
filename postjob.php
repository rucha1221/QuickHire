<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post a Job Page</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>
    <?php
    include("auth.php");
  include("db_connect.php");
  if(isset($_SESSION["user_id"])){
    $user_id=$_SESSION["user_id"];
    $imp_role=$_SESSION["role"];
    $user_id = $_SESSION['user_id'];
  }
  else{
    die("User not logged in.");
  }
        $job_title="";
        $job_title_err="";
        $company_name="";
        $company_name_err="";
        $email="";
        $emailErr="";
        $location="";
        $locationErr="";
        $mode="";
        $mode_err="";
        $exp="";
        $exp_err="";
        $salary="";
        $salaryErr="";
        $vacancy="";
        $vacancyErr="";
        $skills="";
        $skillsErr="";
        $type="";
        $typeErr="";
        $qua="";
        $quaErr="";
        $date="";
        $dateErr="";
        $role="";
        $roleErr="";
        $desc="";
        $descErr="";
        $today="";

        if($_SERVER["REQUEST_METHOD"]=="POST"){
            $job_title=isset($_POST["job_title"]) ? trim($_POST["job_title"]) : "";
            $company_name=isset($_POST["name"]) ? trim($_POST["name"]) : "";
            $email=$_POST["email"];
            $location=isset($_POST["location"]) ? trim($_POST["location"]) : "";
            $mode = isset($_POST['mode']) ? trim($_POST['mode']) : "";           
            $exp=$_POST["exp"];
            $salary=$_POST["salary"];
            $vacancy=isset($_POST["vacancy"]) ? trim($_POST["vacancy"]) : "";
            $skills=isset($_POST["skills"]) ? trim($_POST["skills"]) : "";
            $type=$_POST["type"];
            $qua=isset($_POST["qua"]) ? trim($_POST["qua"]) : "";
            $date=$_POST["deadline"];
            $role=isset($_POST["role"]) ? trim($_POST["role"]) : "";
            $desc=isset($_POST["desc"]) ? trim($_POST["desc"]) : "";

            if(!preg_match("#^[A-Za-z./ ]+$#",$job_title)){
                $job_title_err="Only letters Allowed";
            }
            if(!preg_match("/^[A-Za-z ]+$/",$company_name)){
                $company_name_err="Only letters Allowed";
            }
            if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
                $emailErr="Invalid Email Format";
            }
            if(!preg_match("/^[A-Za-z ]+$/",$location)){
                $locationErr="Only letters Allowed";
            }
            if(empty($mode)){
                $mode_err="Please select work mode";
            }
            if(empty($exp)){
                $exp_err = "Please select experience";
            }
            if(empty($salary)){
                $salaryErr = "Please select salary range";
            }
            if(empty($vacancy)){
    $vacancyErr = "Vacancy is required";
}
elseif(!preg_match("/^[0-9]+$/", $vacancy)){
    $vacancyErr = "Only numbers are allowed";
}
elseif($vacancy <= 0){
    $vacancyErr = "Vacancy must be greater than 0";
}
            if(!preg_match("#^[A-Za-z,./ ]+$#", $skills)){
                $skillsErr = "Only letters and commas allowed";
            }
            if(empty($type)){
                $typeErr = "Please select industry type";
            }
            if(!preg_match("#^[A-Za-z.,/ ]+$#", $qua)){
                $quaErr = "Only letters allowed";
            }
            if(empty($date)){
                $dateErr = "Please select a date";
            }
            if ($date < $today) {
                $dateErr = "Past dates are not allowed";
            }
            if(!preg_match("#^[A-Za-z0-9 ,.()\-\/&:\n\r']+$#", $role)){
                $roleErr = "Invalid characters";
        }

        if(!preg_match("#^[A-Za-z0-9 ,.()\-\/&:\n\r']+$#", $desc)){
                $descErr = "Invalid characters";
        }

        if(empty($job_title_err) && empty($company_name_err) && empty($emailErr) && empty($locationErr) && empty($mode_err) && empty($exp_err) && empty($salaryErr) && empty($vacancyErr) && empty($skillsErr) && empty($typeErr) && empty($quaErr) && empty($dateErr) && empty($roleErr) && empty($descErr)){
            if($imp_role == "Recruiter"){
                 $sql="insert into jobs (user_id,job_title,company_name,company_email,job_location,work_mode,required_experience,salary_range,number_of_vacancies,required_skills,industry_type,qualification,application_deadline,roles_responsibilities,job_description) 
                 values('$user_id','$job_title','$company_name','$email','$location','$mode','$exp','$salary','$vacancy','$skills','$type','$qua','$date','$role','$desc')";
                 if(mysqli_query($conn, $sql)){
                echo "<script>alert('Record Inserted Successfully.');</script>";
            } else {
                echo "<script>alert('Insert Failed.');</script>";
            }
            }
            else{
                echo "<script> alert('You are not a valid Recruiter to post a Job.'); </script>";
            }
        }

        }
    ?>
    <?php include 'headerrecruiter.php'; ?> 
    <div class="profile-card">

<h1 style="text-align: center; margin-top: 30px;">Post a Job</h1>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">

<div class="form-row">

<div class="form-group">
<label>Job Title</label>
<input type="text" name="job_title" value="<?php echo htmlspecialchars($job_title); ?>" required>
<span style="color: red;"><?php echo $job_title_err; ?></span>
</div>

<div class="form-group">
<label>Company Name</label>
<input type="text" name="name" value="<?php echo htmlspecialchars($company_name); ?>" required>
<span style="color: red;"><?php echo $company_name_err; ?></span>
</div>

<div class="form-group">
<label>Company Email</label>
<input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
<span style="color: red;"><?php echo $emailErr; ?></span>
</div>

<div class="form-group">
<label>Job Location</label>
<input type="text" name="location" value="<?php echo htmlspecialchars($location); ?>" required>
<span style="color: red;"><?php echo $locationErr; ?></span>
</div>

<div class="form-group">
<label>Work Mode</label>
<select name="mode" required>
    <option value="">Select Mode</option>
    <option value="Onsite">Onsite</option>
    <option value="Remote">Remote</option>
    <option value="Hybrid">Hybrid</option>
</select>
<span style="color: red;"><?php echo $mode_err; ?></span>
</div>

<div class="form-group">
<label>Required Experience</label>
<select name="exp" required>
    <option value="">Select Experience</option>
    <option value="Fresher">Fresher</option>
    <option value="0-1 Years">0-1 Years</option>
    <option value="2-3 Years">2-3 Years</option>
    <option value="4-5 Years">4-5 Years</option>
</select>
<span style="color: red;"><?php echo $exp_err; ?></span>
</div>

<div class="form-group">
<label>Salary Range</label>
<select name="salary" required>
    <option value="">Select Salary</option>
    <option value="1-3 LPA">1 - 3 LPA</option>
    <option value="3-5 LPA">3 - 5 LPA</option>
    <option value="5-8 LPA">5 - 8 LPA</option>
    <option value="8-12 LPA">8 - 12 LPA</option>
    <option value="12+ LPA">12+ LPA</option>
</select>
<span style="color: red;"><?php echo $salaryErr; ?></span>
</div>

<div class="form-group">
<label>Number of Vacancies</label>
<input type="number" name="vacancy" required>
<span style="color: red;"><?php echo $vacancyErr; ?></span>
</div>

<div class="form-group">
<label>Required Skills</label>
<input type="text" name="skills" value="<?php echo htmlspecialchars($skills); ?>" required>
<span style="color: red;"><?php echo $skillsErr; ?></span>
</div>

<div class="form-group">
<label>Industry Type</label>
<select name="type" required>
    <option value="">Select Industry</option>
    <option value="Information Technology">Information Technology</option>
    <option value="Banking & Finance">Banking & Finance</option>
    <option value="Healthcare">Healthcare</option>
    <option value="Education">Education</option>
    <option value="Manufacturing">Manufacturing</option>
    <option value="E-commerce">E-commerce</option>
</select>
<span style="color: red;"><?php echo $typeErr; ?></span>
</div>

<div class="form-group">
<label>Qualification</label>
<input type="text" name="qua" value="<?php echo htmlspecialchars($qua); ?>" required>
<span style="color: red;"><?php echo $quaErr; ?></span>
</div>

<div class="form-group">
<label>Application Deadline</label>
<input type="date" name="deadline" min="<?php echo date('Y-m-d'); ?>" required>
<span style="color: red;"><?php echo $dateErr; ?></span>
</div>

<div class="form-group">
<label>Roles & Responsibilities</label>
<textarea rows="4" name="role" value="<?php echo htmlspecialchars($role); ?>" required></textarea>
<span style="color: red;"><?php echo $roleErr; ?></span>
</div>

<div class="form-group full-width">
<label>Job Description</label>
<textarea rows="4" name="desc" value="<?php echo htmlspecialchars($desc); ?>" required></textarea>
<span style="color: red;"><?php echo $descErr; ?></span>
</div>

<button class="save-btn" style="flex:1 1 100%;">Post Job</button>
</div>

</form>

</div>
</body>
</html>