<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Seeker Profile</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>
    <?php
    include("auth.php");
    include("db_connect.php");
    // fetch user_id from session
if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
    $imp_role=$_SESSION["role"];
} else {
    die("User not logged in.");
}
        $name="";
        $nameErr="";
        $email="";
        $emailErr="";
        $number="";
        $numberErr="";
        $location="";
        $locationErr="";
        $role="";
        $roleErr="";
        $exp="";
        $skills="";
        $skillsErr="";
        $qua="";
        $quaErr="";
        $college="";
        $collegeErr="";
        $special="";
        $specialErr="";
        $year="";
        $yearErr="";
        $cer="";
        $cerErr="";
        $company="";
        $companyErr="";
        $corole="";
        $coroleErr="";
        $start="";
        $startErr="";
        $end="";
        $endErr="";
        $res="";
        $resErr="";
        $aboutme="";
        $aboutmeErr="";

        if($_SERVER["REQUEST_METHOD"]=="POST"){
            $name=isset($_POST["name"]) ? trim($_POST["name"]) : "";
            $email=isset($_POST["email"]) ? trim($_POST["email"]) : "";
            $number=isset($_POST["number"]) ? trim($_POST["number"]) : "";
            $location=isset($_POST["location"]) ? trim($_POST["location"]) : "";
            $role=isset($_POST["role"]) ? trim($_POST["role"]) : "";
            $exp=$_POST["exp"];
            $skills=isset($_POST["skills"]) ? trim($_POST["skills"]) : "";
            $qua=isset($_POST["qua"]) ? trim($_POST["qua"]) : "";
            $college=isset($_POST["college"]) ? trim($_POST["college"]) : "";
            $special=isset($_POST["special"]) ? trim($_POST["special"]) : "";
            $year=isset($_POST["year"]) ? trim($_POST["year"]) : "";
            $cer=isset($_POST["cer"]) ? trim($_POST["cer"]) : "";
            $aboutme=isset($_POST["aboutme"]) ? trim($_POST["aboutme"]) : "";
            $today = date('Y-m-d');
            
            if(!preg_match("/^[A-Za-z ]+$/",$name)){
                $nameErr="Only Letters Allowed";
            }
            if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
                $emailErr="Invalid Email Format";
            }
            if(!preg_match("/^(\+91[\-\s]?)?[6-9][0-9]{9}$/", $number)){
                $numberErr = "Enter valid mobile number";
            }
            if(!preg_match("/^[A-Za-z ]+$/",$location)){
                $locationErr="Only Letters Allowed";
            }
            if(!preg_match("/^[A-Za-z ]+$/",$role)){
                $roleErr="Only Letters Allowed";
            }
            if(!preg_match("/^[A-Za-z,. ]+$/",$skills)){
                $skillsErr="Only Letters Allowed";
            }
            if(!preg_match("/^[A-Za-z. ]+$/",$qua)){
                $quaErr="Only Letters Allowed";
            }
            if(!preg_match("/^[A-Za-z ]+$/",$college)){
                $collegeErr="Only Letters Allowed";
            }
            if(!preg_match("/^[A-Za-z, ]+$/",$special)){
                $specialErr="Only Letters Allowed";
            }
            if (!preg_match("/^[0-9]{4}$/", $year)) {
                $yearErr = "Enter a valid 4-digit year";
            }
            if(!preg_match("/^[A-Za-z,. ]+$/",$cer)){
                $cerErr="Only Letters Allowed";
            }
            if(!preg_match("/^[A-Za-z0-9 ,.()\-]+$/",$aboutme)){
                $aboutmeErr="Only Letters and Digits Allowed";
            } 
             

$imageName = "";
$imageErr="";

if (isset($_FILES["image"]) && $_FILES["image"]["error"] != 4) {
    $fileName = $_FILES["image"]["name"];
    $fileType = $_FILES["image"]["type"];
    $fileSize = $_FILES["image"]["size"];
    $fileTmpName = $_FILES["image"]["tmp_name"];
    $fileError = $_FILES["image"]["error"];

    $allowedTypes = array("jpg", "png", "jpeg", "webp");
    $allowedMime = array("image/jpeg", "image/png", "image/webp");

    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    if ($fileError != 0) {
        $imageErr = "Error while uploading file.";
    }
    elseif (!in_array($fileExt, $allowedTypes)) {
        $imageErr = "Only JPG, JPEG, PNG, and WEBP files are allowed.";
    }
    elseif (!in_array($fileType, $allowedMime)) {
        $imageErr = "Invalid image type.";
    }
    elseif ($fileSize > 2000000) {
        $imageErr = "File size must be less than 2MB.";
    }
    else {
        $uploadFolder = "upload/";

        if (!is_dir($uploadFolder)) {
            mkdir($uploadFolder, 0777, true);
        }

        $newFileName = uniqid() . "." . $fileExt;
        $destination = $uploadFolder . $newFileName;

        if (move_uploaded_file($fileTmpName, $destination)) {
            $imageName = $newFileName;
        } else {
            $imageErr= "Failed to upload file.";
        }
    }
}



if(empty($imageErr) && empty($nameErr) && empty($emailErr) && empty($numberErr) && empty($locationErr)
    && empty($roleErr) && empty($skillsErr) && empty($quaErr) && empty($collegeErr) && empty($specialErr) 
    && empty($yearErr) && empty($cerErr) && empty($aboutmeErr)) {

    if($imp_role == "Job Seeker") {

        // Check if profile already exists for this user
        $check = mysqli_query($conn, "SELECT * FROM job_seeker_profile WHERE user_id='$user_id'");
        if(mysqli_num_rows($check) > 0){
            // Profile exists → UPDATE
            $sql = "UPDATE job_seeker_profile SET
                        image='$imageName',
                        full_name='$name',
                        email_address='$email',
                        mobile_number='$number',
                        location='$location',
                        desired_role='$role',
                        experience='$exp',
                        skills='$skills',
                        qualification='$qua',
                        college_name='$college',
                        specialization='$special',
                        graduation_year='$year',
                        certificates='$cer',
                        about_me='$aboutme'
                    WHERE user_id='$user_id'";
            if(mysqli_query($conn, $sql)){
                echo "<script>alert('Profile Updated Successfully.');</script>";
            } else {
                echo "<script>alert('Update Failed.');</script>";
            }
        } else {
            // Profile doesn't exist → INSERT
            $sql = "INSERT INTO job_seeker_profile 
                        (user_id, image, full_name, email_address, mobile_number, location, desired_role, experience, skills, qualification, college_name, specialization, graduation_year, certificates, about_me)
                    VALUES
                        ('$user_id','$imageName','$name','$email','$number','$location','$role','$exp','$skills','$qua','$college','$special','$year','$cer','$aboutme')";
            if(mysqli_query($conn, $sql)){
                echo "<script>alert('Profile Created Successfully.');</script>";
            } else {
                echo "<script>alert('Insert Failed.');</script>";
            }
        }

    } else {
        echo "<script>alert('Insert Failed. You are not a valid Job Seeker');</script>";
    }

}

}
?>

    <?php include 'headerjobseeker.php'; ?>
    <h1 style="text-align: center; margin-top: 30px;">Complete Your Profile</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">

<div class="photo-section">
    <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" alt="profile">
    <input type="file" name="image">
<span><?php echo isset($imageErr) ? $imageErr : ""; ?></span>
</div>

<div class="form-row">

<div class="form-group">
<label>Full Name</label>
<input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
<span style="color: red;"><?php echo $nameErr; ?></span>
</div>

<div class="form-group">
<label>Email Address</label>
<input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
<span style="color: red;"><?php echo $emailErr; ?></span>
</div>

<div class="form-group">
<label>Mobile Number</label>
<input type="number" name="number" value="<?php echo htmlspecialchars($number); ?>" required>
<span style="color: red;"><?php echo $numberErr; ?></span>
</div>

<div class="form-group">
<label>Location</label>
<input type="text" name="location" value="<?php echo htmlspecialchars($location); ?>" required>
<span style="color: red;"><?php echo $locationErr; ?></span>
</div>

<div class="form-group">
<label>Job Title / Desired Role</label>
<input type="text" name="role" value="<?php echo htmlspecialchars($role); ?>" required>
<span style="color: red;"><?php echo $roleErr; ?></span>
</div>

<div class="form-group">
<label>Experience</label>
<select name="exp" required>
<option value="">Select Experience</option>
<option value="Fresher">Fresher</option>
<option value="0-1 Years">0-1 Years</option>
<option value="2-3 Years">2-3 Years</option>
<option value="4-5 Years">4-5 Years</option>
</select>
</div>

<div class="form-group">
<label>Skills</label>
<input type="text" name="skills" value="<?php echo htmlspecialchars($skills); ?>" required>
<span style="color: red;"><?php echo $skillsErr; ?></span>
</div>

<div class="form-group">
<label>Qualification</label>
<input type="text" name="qua" value="<?php echo htmlspecialchars($qua); ?>" required>
<span style="color: red;"><?php echo $quaErr; ?></span>
</div>

<div class="form-group">
<label>College Name</label>
<input type="text" name="college" value="<?php echo htmlspecialchars($college); ?>" required>
<span style="color: red;"><?php echo $collegeErr; ?></span>
</div>

<div class="form-group">
<label>Specialization</label>
<input type="text" name="special" value="<?php echo htmlspecialchars($special); ?>" required>
<span style="color: red;"><?php echo $specialErr; ?></span>
</div>

<div class="form-group">
<label>Graduation Year</label>
<input type="number" name="year" min="1000" max="9999" value="<?php echo htmlspecialchars($year); ?>" required>
<span style="color: red;"><?php echo $yearErr; ?></span>
</div>

<div class="form-group">
<label>Certificates</label>
<input type="text" name="cer" value="<?php echo htmlspecialchars($cer); ?>" required>
<span style="color: red;"><?php echo $cerErr; ?></span>
</div>

<div class="form-group full-width">
<label>About Me</label>
<textarea rows="4" name="aboutme" required><?php echo htmlspecialchars($aboutme); ?></textarea>
<span style="color: red;"><?php echo $aboutmeErr; ?></span>
</div>

</div>

<div class="btn-group">
    <button type="submit" class="save-btn">Save Profile or Update Profile</button>
    <?php
$sql = "SELECT * FROM job_seeker_profile WHERE user_id='$user_id'";
$result = mysqli_query($conn, $sql);
?>

<?php if(mysqli_num_rows($result) > 0){ ?>
    <button type="submit" class="reset-btn">
        <a href="profile_2.php">View Profile</a>
    </button>
<?php } else { ?>
    <button type="submit" disabled class="reset-btn" style="pointer-events:none;background-color: gray; cursor: not-allowed;">
        <a href="profile_2.php">View Profile</a>
    </button>
<?php } ?>
</div>
</div>
</form>
</body>
</html>