<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jobs Posted By Recruiter</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>
    <?php
      include("auth.php");
      include("db_connect.php");
      include 'headerrecruiter.php';
      $user_id=$_SESSION["user_id"];

      $new_sql="select * from jobs where user_id='$user_id'";
      $new_result=mysqli_query($conn,$new_sql);
    ?>
    <h1 style="margin-top: 40px; text-align: center;">Jobs Posted List</h1>
    <div class="table-scroll">
    <table border="1" cellpadding="10" cellspacing="0">
    <tr>
        <th>Job id</th>
        <th>Job Title</th>
        <th>Company Name</th>
        <th>Company email</th>
        <th>Job location</th>
        <th>Work Mode</th>
        <th>Required Experience</th>
        <th>Salary Range</th>
        <th>Openings</th>
        <th>Required Skills</th>
        <th>Industry Type</th>
        <th>Qualification</th>
        <th>Application_Deadline</th>
        <th>Roles & Responsibilities</th>
        <th>Job Description</th>
        <th>Posted Date</th>
        <th>Applications</th>
    </tr>
    <?php
       if(mysqli_num_rows($new_result) > 0){
         while($new_row=mysqli_fetch_assoc($new_result)){
    ?>
            <tr>
                <td><?php echo $new_row['job_id']; ?></td>
                <td><?php echo $new_row['job_title']; ?></td>
                <td><?php echo $new_row['company_name']; ?></td>
                <td><?php echo $new_row['company_email']; ?></td>
                <td><?php echo $new_row['job_location']; ?></td>
                <td><?php echo $new_row['work_mode']; ?></td>
                <td><?php echo $new_row['required_experience'];?></td>
                <td><?php echo $new_row['salary_range']; ?></td>
                <td><?php echo $new_row['number_of_vacancies']; ?></td>
                <td><?php echo $new_row['required_skills']; ?></td>
                <td><?php echo $new_row['industry_type']; ?></td>
                <td><?php echo $new_row['qualification']; ?></td>
                <td><?php echo $new_row['application_deadline']; ?></td>
                <td><?php echo $new_row['roles_responsibilities']; ?></td>
                <td><?php echo $new_row['job_description']; ?></td>
                <td><?php echo $new_row['created_at']; ?></td>
                <td>
                 <a href="app.php?job_id=<?php echo $new_row['job_id']; ?>" style="color: green;">View Applications</a>
                </td>
            </tr>
        <?php
         }
       }
       else{
        echo "<tr><td colspan='16'>No Records Found</td></tr>";
       }
        ?>
    </table>
    </div>
</body>
</html>