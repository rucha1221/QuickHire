<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Profile</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>
     <?php
     include("auth.php");
     include("db_connect.php");
     if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
    $role=$_SESSION["role"];
    }
    else {
    die("User not logged in.");
    }
         $name="";
         $nameErr="";
         $industry="";
         $industryErr="";
         $size="";
         $year="";
         $yearErr="";
         $hq="";
         $hqErr="";
         $branch="";
         $branchErr="";
         $hire="";
         $hireErr="";
         $desg="";
         $desgErr="";
         $email="";
         $emailErr="";
         $contact="";
         $contactErr="";
         $website="";
         $websiteErr="";
         $url="";
         $urlErr="";
         $loc="";
         $locErr="";
         $special="";
         $specialErr="";
         $about="";
         $aboutErr="";


         if($_SERVER["REQUEST_METHOD"]=="POST"){
            $name=isset($_POST["name"]) ? trim($_POST["name"]) : "";
            $industry=isset($_POST["industry"]) ? trim($_POST["industry"]) : "";
            $size=$_POST["size"];
            $year=isset($_POST["year"]) ? trim($_POST["year"]) : "";
            $hq=isset($_POST["hq"]) ? trim($_POST["hq"]) : "";
            $branch=isset($_POST["branch"]) ? trim($_POST["branch"]) : "";
            $hire=isset($_POST["hire"]) ? trim($_POST["hire"]) : "";
            $desg=isset($_POST["desg"]) ? trim($_POST["desg"]) : "";
            $email=isset($_POST["email"]) ? trim($_POST["email"]) : "";
            $contact=isset($_POST["contact"]) ? trim($_POST["contact"]) : "";
            $website=isset($_POST["website"]) ? trim($_POST["website"]) : "";
            $url=isset($_POST["url"]) ? trim($_POST["url"]) : "";
            $loc=isset($_POST["loc"]) ? trim($_POST["loc"]) : "";
            $special=isset($_POST["special"]) ? trim($_POST["special"]) : "";
            $about=isset($_POST["about"]) ? trim($_POST["about"]) : "";

            if(!preg_match("/^[A-Za-z ]+$/",$name)){
                $nameErr="Only Letters Allowed";
            }
            if(!preg_match("/^[A-Za-z& ]+$/",$industry)){
                $industryErr="Only Letters Allowed";
            }
            if (!preg_match("/^[0-9]{4}$/", $year)) {
                $yearErr = "Enter a valid 4-digit year";
            }
            if(!preg_match("/^[A-Za-z ]+$/",$hq)){
                $hqErr="Only Letters Allowed";
            }
            if(!preg_match("/^[A-Za-z, ]+$/",$branch)){
                $branchErr="Only Letters and Commas Allowed";
            }
            if(!preg_match("/^[A-Za-z ]+$/",$hire)){
                $hireErr="Only Letters Allowed";
            }
            if(!preg_match("/^[A-Za-z ]+$/",$desg)){
                $desgErr="Only Letters Allowed";
            }
            if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
                $emailErr="Invalid Email Format";
            }
            if(!preg_match("/^(\+91[\-\s]?)?[6-9][0-9]{9}$/", $contact)){
                $contactErr = "Enter valid Indian mobile number";
            }
            if(!preg_match("/^[A-Za-z ]+$/",$website)){
                $websiteErr="Only Letters Allowed";
            }
            if(!filter_var($url, FILTER_VALIDATE_URL)){
                $urlErr = "Invalid URL";
            }
            if(!preg_match("/^[A-Za-z ]+$/",$loc)){
                $locErr="Only Letters Allowed";
            }
            if(!preg_match("/^[A-Za-z, ]+$/",$special)){
                $specialErr="Only Letters Allowed";
            }
            if(!preg_match("/^[A-Za-z0-9 ,.()\-]+$/", $about)){
                $aboutErr = "Invalid characters";
            }
            
            if(empty($nameErr) && empty($industryErr) && empty($yearErr) && empty($hqErr) && empty($branchErr) && empty($hireErr)
    && empty($desgErr) && empty($emailErr) && empty($contactErr) && empty($websiteErr) && empty($urlErr) && empty($locErr) && empty($specialErr) && empty($aboutErr)) {

    if($role == "Recruiter") {

        // Check if recruiter profile already exists
        $check = mysqli_query($conn, "SELECT * FROM recruiter_profile WHERE user_id='$user_id'");
        if(mysqli_num_rows($check) > 0){
            // Profile exists → UPDATE
            $sql = "UPDATE recruiter_profile SET
                        company_name='$name',
                        industry_type='$industry',
                        company_size='$size',
                        founded_year='$year',
                        headquarters_location='$hq',
                        branches_offices='$branch',
                        recruiter_name='$hire',
                        hr_designation='$desg',
                        company_email='$email',
                        contact_number='$contact',
                        company_website='$website',
                        website_url='$url',
                        company_location='$loc',
                        specialties='$special',
                        about_company='$about'
                    WHERE user_id='$user_id'";

            if(mysqli_query($conn, $sql)){
                echo "<script>alert('Recruiter Profile Updated Successfully');</script>";
            } else {
                echo "<script>alert('Update Failed.');</script>";
            }

        } else {
            // Profile doesn't exist → INSERT
            $sql = "INSERT INTO recruiter_profile (
                        user_id, company_name, industry_type, company_size, founded_year, headquarters_location, 
                        branches_offices, recruiter_name, hr_designation, company_email, contact_number, 
                        company_website, website_url, company_location, specialties, about_company
                    ) VALUES (
                        '$user_id', '$name', '$industry', '$size', '$year', '$hq', 
                        '$branch', '$hire', '$desg', '$email', '$contact', '$website', '$url', '$loc', '$special', '$about'
                    )";

            if(mysqli_query($conn, $sql)){
                echo "<script>alert('Recruiter Profile Created Successfully');
                </script>";
            } else {
                echo "<script>alert('Insert Failed.');</script>";
            }
        }

    } else {
        echo "<script>alert('Insert Failed. You are not a valid Recruiter');</script>";
    }

}
         }
     ?>

    <?php include 'headerrecruiter.php'; ?> 
    <div class="profile-card">

<h1 style="text-align: center; margin-top: 30px;">Company Profile</h2>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">

<div class="form-row">

<div class="form-group">
<label>Company Name</label>
<input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
<span style="color: red;"><?php echo $nameErr; ?></span>
</div>

<div class="form-group">
<label>Industry Type</label>
<input type="text" name="industry" placeholder="e.g. Information Technology" value="<?php echo htmlspecialchars($industry); ?>" required>
<span style="color: red;"><?php echo $industryErr; ?></span>
</div>

<div class="form-group">
<label>Company Size</label>
<select name="size" required>
<option value="">Select Size</option>
<option value="1-10 Employees">1-10 Employees</option>
<option value="11-50 Employees">11-50 Employees</option>
<option value="51-200 Employees">51-200 Employees</option>
<option value="210-500 Employees">201-500 Employees</option>
<option value="500+ Employees">500+ Employees</option>
</select>
</div>

<div class="form-group">
<label>Founded Year</label>
<input type="number" name="year" min="1000" max="9999" required>
<span style="color: red;"><?php echo $yearErr; ?></span>
</div>

<div class="form-group">
    <label>Headquarters Location</label>
    <input type="text" name="hq" required>
    <span style="color: red;"><?php echo $hqErr; ?></span>
</div>

<div class="form-group">
    <label>Branches / Offices</label>
    <input type="text" name="branch" required>
    <span style="color: red;"><?php echo $branchErr; ?></span>
</div>

<div class="form-group">
    <label>Recruiter Name</label>
    <input type="text" name="hire" required>
    <span style="color: red;"><?php echo $hireErr; ?></span>
</div>

<div class="form-group">
    <label>HR Designation</label>
    <input type="text" name="desg" value="<?php echo htmlspecialchars($desg); ?>" required>
    <span style="color: red;"><?php echo $desgErr; ?></span>
</div>

<div class="form-group">
    <label>Company Email</label>
    <input type="email" name="email" required>
    <span style="color: red;"><?php echo $emailErr; ?></span>
</div>

<div class="form-group">
    <label>Contact Number</label>
    <input type="tel" name="contact" required>
    <span style="color: red;"><?php echo $contactErr; ?></span>
</div>

<div class="form-group">
<label>Company Website</label>
<input type="text" name="website" value="<?php echo htmlspecialchars($website); ?>">
<span style="color: red;"><?php echo $websiteErr; ?></span>
</div>

<div class="form-group">
<label>Website URL</label>
<input type="text" name="url" value="<?php echo htmlspecialchars($url); ?>">
<span style="color: red;"><?php echo $urlErr; ?></span>
</div>

<div class="form-group">
<label>Company Location</label>
<input type="text" name="loc" value="<?php echo htmlspecialchars($loc); ?>" required>
<span style="color: red;"><?php echo $locErr; ?></span>
</div>

<div class="form-group">
<label>Specialties</label>
<input type="text" name="special" required>
<span style="color: red;"><?php echo $specialErr; ?></span>
</div>

<div class="form-group full-width">
<label>About Company</label>
<textarea rows="4" name="about" value="<?php echo htmlspecialchars($about); ?>" required></textarea>
<span style="color: red;"><?php echo $aboutErr; ?></span>
</div>

<div class="btn-group">
    <button type="submit" class="save-btn">Save Profile or Update Profile</button>
    <?php
$sql = "SELECT * FROM recruiter_profile WHERE user_id='$user_id'";
$result = mysqli_query($conn, $sql);
?>

<?php if(mysqli_num_rows($result) > 0){ ?>
    <button type="submit" class="reset-btn">
        <a href="profile_1.php">View Profile</a>
    </button>
<?php } else { ?>
    <button type="submit" disabled class="reset-btn" style="pointer-events:none;background-color: gray; cursor: not-allowed;">
        <a href="profile_1.php">View Profile</a>
    </button>
<?php } ?>
</div>
</div>

</form>

</div>
</body>
</html>