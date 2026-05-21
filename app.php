<?php
include ('auth.php');
include ('db_connect.php');
include ('headerrecruiter.php');
$job_id="";
if(isset($_GET["job_id"])){
    $job_id=$_GET["job_id"];
}
if(isset($_SESSION["user_id"])){
    $user_id = $_SESSION["user_id"];
}
else{
    echo "user id not exist";
}

// now fetch applications for jobs posted by this recruiter
$sql = "SELECT applications.*, jobs.job_id, jobs.job_title, jobs.company_name
        FROM applications
        INNER JOIN jobs 
        ON applications.job_id = jobs.job_id
        WHERE jobs.user_id = '$user_id'
        AND jobs.job_id = '$job_id'
        ORDER BY applications.application_date DESC";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applications Received</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>
<h2 style="margin-top: 40px; text-align: center;">Applications Received</h2>

<table border="1" cellpadding="10" cellspacing="0" style="width:100%;">
    <tr>
        <th>Application ID</th>
        <th>Job Title</th>
        <th>Company Name</th>
        <th>Applicant Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Resume</th>
        <th>Cover Letter</th>
        <th>Applied Date</th>
        <th>Status</th>
        <th>Action</th>
    </tr>

    <?php
    if($result && mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            ?>
            <tr>
                <td><?php echo $row['application_id']; ?></td>
                <td><?php echo $row['job_title']; ?></td>
                <td><?php echo $row['company_name']; ?></td>
                <td><?php echo $row['full_name']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['phone']; ?></td>
                <td><a href="<?php echo $row['resume']; ?>" target="_blank">View Resume</a></td>
                <td style="width: 350px;"><?php echo $row['cover_letter']; ?></td>
                <td><?php echo date('Y-m-d', strtotime($row['application_date'])); ?></td>
                <td><?php echo $row['status']; ?></td>
                <td>
    <?php if($row['status'] == "Pending"){ ?>
        <a href="update_application_status.php?application_id=<?php echo $row['application_id']; ?>&status=Selected&job_id=<?php echo $row['job_id']; ?>" style="color: green;">
    <i class="bi bi-check2"></i> Select
</a>

<a href="update_application_status.php?application_id=<?php echo $row['application_id']; ?>&status=Rejected&job_id=<?php echo $row['job_id']; ?>" style="color: red;">
    <i class="bi bi-x-lg"></i> Reject
</a>
    <?php } else { ?>
        <?php echo $row['status']; ?>
    <?php } ?>
</td>
            </tr>
            <?php
        }
    } else {
        echo "<tr><td colspan='10'>No applications found</td></tr>";
    }
    ?>
</table>

</body>
</html>