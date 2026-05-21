<?php
include ('auth.php');
include ('db_connect.php');
include ('headerjobseeker.php');

if(isset($_SESSION["user_id"])){
    $user_id = $_SESSION["user_id"];
}
else{
    echo "user id not exist";
}

$sql = "SELECT applications.*, jobs.job_title, jobs.company_name, jobs.job_location, jobs.salary_range
        FROM applications
        INNER JOIN jobs ON applications.job_id = jobs.job_id
        WHERE applications.user_id = '$user_id'
        ORDER BY applications.application_date DESC";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Applications</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>

<h2 style="text-align: center; margin-top: 40px;">My Applied Jobs</h2>

<table border="1" cellpadding="10" cellspacing="0">
    <tr>
        <th>Application ID</th>
        <th>Job Title</th>
        <th>Company</th>
        <th>Location</th>
        <th>Salary</th>
        <th>Applied Date</th>
        <th>Resume</th>
        <th>Cover Letter</th>
        <th>Status</th>
    </tr>

    <?php
    if($result && mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            ?>
            <tr>
                <td><?php echo $row['application_id']; ?></td>
                <td><?php echo $row['job_title']; ?></td>
                <td><?php echo $row['company_name']; ?></td>
                <td><?php echo $row['job_location']; ?></td>
                <td><?php echo $row['salary_range']; ?></td>
                <td><?php echo date("d-m-Y", strtotime($row['application_date'])); ?></td>
                <td><a href="<?php echo $row['resume']; ?>" target="_blank" style="color: green;">View Resume</a></td>
                <td><?php echo $row['cover_letter']; ?></td>
                <td><?php echo $row['status']; ?></td>
            </tr>
            <?php
        }
    } else {
        echo "<tr><td colspan='9'>No applications found</td></tr>";
    }
    ?>
</table>


</body>
</html>