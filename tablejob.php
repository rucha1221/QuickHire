<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Total Jobs Table</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>
    <?php
include ("headeradmin.php");
include("db_connect.php");
include("auth.php");

$sql = "SELECT * FROM jobs";
$result = mysqli_query($conn, $sql);
?>

<h2 style="text-align: center; margin-bottom: 30px;margin-top: 40px;" class="table-scroll">Total Jobs</h2>

<?php
    $com="";
    $comErr="";
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $com=isset($_POST["company"]) ? trim($_POST["company"]) : "";
 
        if(!preg_match("/^[A-Za-z ]+$/",$com)){
            $comErr="Only Letters are Allowed.";
        }

        if(empty($comErr)){
            $sql = "SELECT * FROM jobs 
                WHERE company_name LIKE '%$com%'";  
        }
    }
    $result = mysqli_query($conn, $sql);
?>
<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" class="search-bar">
    <input type="text" name="company" placeholder="Enter Company Name" required>
    <span style="color:red;"><?php echo "<br>" .$comErr; ?></span>
    <button type="submit">Search</button>
  </form>

<table border="1" cellspacing="0" cellpadding="10">
<tr>
    <th>Job Title</th>
    <th>Company Name</th>
    <th>Company Email</th>
    <th>Location</th>
    <th>Work Mode</th>
    <th>Experience</th>
    <th>Salary Range</th>
    <th>Openings</th>
    <th>Required Skills</th>
    <th>Qualification</th>
    <th>Application Deadline</th>
    <th>Status</th>
</tr>

<?php
if($result && mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){

        $deadline = $row['application_deadline'];
        $today = date("Y-m-d");

        if($deadline >= $today){
            $status = "Active";
            $color = "green";
        } else {
            $status = "Inactive";
            $color = "red";
        }

        echo "<tr>
            <td>{$row['job_title']}</td>
            <td>{$row['company_name']}</td>
            <td>{$row['company_email']}</td>
            <td>{$row['job_location']}</td>
            <td>{$row['work_mode']}</td>
            <td>{$row['required_experience']}</td>
            <td>{$row['salary_range']}</td>
            <td>{$row['number_of_vacancies']}</td>
            <td>{$row['required_skills']}</td>
            <td>{$row['qualification']}</td>
            <td>{$row['application_deadline']}</td>
            <td style='color:$color; font-weight:bold;'>$status</td>
        </tr>";
    }
}
else{
    echo "<tr><td colspan='12'>No Records Found.</td></tr>";
}
?>

</table>

<?php include 'footer.php'; ?>
</body>
</html>