<?php
session_start();
include "db_connect.php"; 

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$job_id = $_GET['job_id'] ?? $_POST['job_id'] ?? '';

if(empty($job_id)){
    echo "Job ID not found.";
    exit();
}

$full_name = "";
$email = "";
$phone = "";
$cover_letter = "";
$fullNameErr = $emailErr = $phoneErr = $resumeErr = "";

$user_sql = "SELECT name, email FROM users WHERE user_id='$user_id'";
$user_result = mysqli_query($conn, $user_sql);
if($user_result && mysqli_num_rows($user_result) > 0){
    $user_row = mysqli_fetch_assoc($user_result);
    $full_name = $user_row['name'];
    $email = $user_row['email'];
}

if(isset($_POST['apply'])){
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $cover_letter = trim($_POST['cover_letter']);
    $status = "Pending";
    $application_date = date("Y-m-d");

    if(empty($full_name)){
        $fullNameErr = "Full name is required";
    }

    if(empty($email)){
        $emailErr = "Email is required";
    }

    if(empty($phone)){
        $phoneErr = "Phone is required";
    }
    else{
        if(!preg_match("/^(\+91[\-\s]?)?[6-9][0-9]{9}$/", $phone)){
                $phoneErr = "Enter valid mobile number";
        }
    }

    $resumeErr = "";
$resume = "";

if(isset($_FILES['resume']) && $_FILES['resume']['error'] == 0){

    $allowed_types = ['pdf', 'doc', 'docx'];
    $file_name = $_FILES['resume']['name'];
    $file_tmp = $_FILES['resume']['tmp_name'];
    $file_size = $_FILES['resume']['size'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    if(!in_array($file_ext, $allowed_types)){
        $resumeErr = "Only PDF, DOC, and DOCX files are allowed.";
    }
    else if($file_size > 2 * 1024 * 1024){
        $resumeErr = "File size must be less than 2MB.";
    }
    else{
        $resume = "uploads/" . time() . "_" . $file_name;

        if(!is_dir("uploads")){
            mkdir("uploads", 0777, true);
        }

        move_uploaded_file($file_tmp, $resume);
    }
}
else{
    $resumeErr = "Resume is required.";
}
    $check_sql = "SELECT * FROM applications WHERE user_id='$user_id' AND job_id='$job_id'";
    $check_result = mysqli_query($conn, $check_sql);

    if($check_result && mysqli_num_rows($check_result) > 0){
        echo "<script>alert('You have already applied for this job.'); window.location='job_details.php?job_id=$job_id';</script>";
        exit();
    }

    if(empty($fullNameErr) && empty($emailErr) && empty($phoneErr) && empty($resumeErr)){
        $sql = "INSERT INTO applications (user_id, job_id, full_name, email, phone, resume, cover_letter, application_date, status) 
                VALUES ('$user_id', '$job_id', '$full_name', '$email', '$phone', '$resume', '$cover_letter', '$application_date', '$status')";

        if(mysqli_query($conn, $sql)){
            echo "<script>alert('Applied Successfully'); window.location='jobseekerhome.php';</script>";
            exit();
        } else {
            echo "Application failed: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <style>
            text-align: center;
    margin-top: 30px;
    color: #222;
}

form{
    width: 40%;
    margin: 30px auto;
    background: #fff;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

label{
    display: block;
    font-size: 16px;
    font-weight: bold;
    margin-bottom: 8px;
    color: #333;
}

input[type="text"],
input[type="email"],
input[type="file"],
textarea{
    width: 99%;
    padding: 12px;
    margin-bottom: 8px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 15px;
    box-sizing: border-box;
}

textarea{
    resize: vertical;
    min-height: 120px;
}

span{
    font-size: 14px;
    color: red;
    display: block;
    margin-bottom: 15px;
}

button{
    width: 100%;
    padding: 14px;
    background: #007bff;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 17px;
    cursor: pointer;
    transition: 0.3s;
}

button:hover{
    background: #0056b3;
}
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply Job</title>
</head>
<body>

<h2>Apply for Job</h2>

<form action="" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="job_id" value="<?php echo $job_id; ?>">

    <label>Full Name</label><br>
    <input type="text" name="full_name" value="<?php echo $full_name; ?>" required><br>
    <span style="color:red;"><?php echo $fullNameErr; ?></span><br><br>

    <label>Email</label><br>
    <input type="email" name="email" value="<?php echo $email; ?>" required><br>
    <span style="color:red;"><?php echo $emailErr; ?></span><br><br>

    <label>Phone</label><br>
    <input type="text" name="phone" value="<?php echo $phone; ?>" autocomplete="new-password" required><br>
    <span style="color:red;"><?php echo $phoneErr; ?></span><br><br>

    <label>Resume</label><br>
    <input type="file" name="resume" required><br>
    <span style="color:red;"><?php echo $resumeErr; ?></span><br><br>

    <label>Cover Letter</label><br>
    <textarea name="cover_letter" rows="5" cols="40" required><?php echo $cover_letter; ?></textarea><br><br>

    <button type="submit" name="apply">Submit Application</button>
</form>

</body>
</html>
