<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Total Recruiters Table</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>
    <?php
    include ("headeradmin.php");
    include("db_connect.php");
    include("auth.php");

    $sql = "SELECT applications.*, jobs.job_title, jobs.company_name
        FROM applications
        INNER JOIN jobs ON applications.job_id = jobs.job_id";
    $result = mysqli_query($conn, $sql);
    ?>
<h2 style="text-align: center; margin-bottom: 30px; margin-top: 40px;">Application List</h2>

<?php
    $title="";
    $titleErr="";
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $title=isset($_POST["title"]) ? trim($_POST["title"]) : "";

        if(!preg_match("#^[A-Za-z./ ]+$#",$title)){
            $titleErr="incorrect job title";
        }

        if(empty($titleErr)){
            $sql = "SELECT applications.*, jobs.job_title, jobs.company_name
        FROM applications
        INNER JOIN jobs ON applications.job_id = jobs.job_id 
        where jobs.job_title like '%$title%'";
        $result = mysqli_query($conn, $sql);
        }
    }
?>
<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" class="search-bar">
    <input type="text" name="title" placeholder="Enter Job Title" required>
    <span style="color:red;"><?php echo "<br>" .$titleErr; ?></span>
    <button type="submit">Search</button>
  </form>


<table border="1" cellspacing="0" cellpadding="10">
    <tr>
        <th>Application ID</th>
        <th>Job Title</th>
        <th>Company</th>
        <th>Applicant Name</th>
        <th>Email</th>
        <th>Resume</th>
        <th>Cover Letter</th>
        <th>Applied Date</th>
        <th>Status</th>
    </tr>
    <?php 
        if(mysqli_num_rows($result) > 0){
            while($row=mysqli_fetch_assoc($result)){
                ?>
                <td><?php echo $row['application_id']; ?></td>
                <td><?php echo $row['job_title']; ?></td>
                <td><?php echo $row['company_name']; ?></td>
                <td><?php echo $row['full_name']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><a href="<?php echo $row['resume']; ?>" target="_blank">View Resume</a></td>
                <td><?php echo $row['cover_letter']; ?></td>
                <td><?php echo date("d-m-Y", strtotime($row['application_date'])); ?></td>
                <td><?php echo $row['status']; ?></td>
</tr>
<?php
            }
        }
        else{
            echo "<tr><td colspan='5'>No Records Found.</td></tr>";
        }
    ?>
    
</table>
<?php include 'footer.php' ?>
</body>
</html>