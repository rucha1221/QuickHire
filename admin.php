<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <?php
    include("auth.php"); 
    include("db_connect.php");
    ?>
    <?php include 'headeradmin.php' ?>
    <div class="card-container">
    <?php  
      $sql="select count(*) as total_users from users where role!='admin'";
      $result=mysqli_query($conn,$sql);
      $row=mysqli_fetch_assoc($result);
    ?>
    <div class="card">
        <h3>Total Users</h3>
        <h1><?php echo $row["total_users"];  ?></h1>
        <p>Registered Users</p>
    </div>

    <?php
      $sql="select count(*) as total_apps from applications";
      $result=mysqli_query($conn,$sql);
      $row=mysqli_fetch_assoc($result);
    ?>
    <div class="card">
        <h3>Total Applications</h3>
        <h1><?php echo $row["total_apps"]; ?></h1>
        <p>Received Applications</p>
    </div>
    <?php
        $sql="select count(*) as total_jobs from jobs";
        $result=mysqli_query($conn,$sql);
        $row=mysqli_fetch_assoc($result);
    ?>
    <div class="card">
        <h3>Total Job Posts</h3>
        <h1><?php echo $row["total_jobs"] ?></h1>
        <p>Company Job Listings</p>
    </div>

</div>

<div class="report-cont">
    <div class="usage-box">
<h2 style="margin-bottom: 20px;">Application Status</h2>
    <div class="item">
        <div class="label">
            <?php
            $sql_total = "SELECT COUNT(*) as total FROM applications";
            $res_total = mysqli_query($conn, $sql_total);
            $row_total = mysqli_fetch_assoc($res_total);
            $total = $row_total['total'];

               $sql="select count(*) as total_pending from applications where status='Pending'";
               $result=mysqli_query($conn,$sql);
               $row=mysqli_fetch_assoc($result);
               $pending_percent = ($total > 0) ? ($row["total_pending"] / $total) * 100 : 0;
            ?>
            <span class="data">Pending Applications</span>
            <span class="data"><?php echo $row["total_pending"]; ?></span>
        </div>
        <div class="bar">
            <div class="fill blue" style="width: <?php echo $pending_percent; ?>%;"></div>
        </div>
    </div>

    <div class="item">
        <div class="label">
            <?php
               $sql="select count(*) as total_selected from applications where status='Selected'";
               $result=mysqli_query($conn,$sql);
               $row=mysqli_fetch_assoc($result);
               $selected_percent = ($total > 0) ? ($row["total_selected"] / $total) * 100 : 0;
            ?>
            <span class="data">Selected Applications</span>
            <span class="data"><?php echo $row["total_selected"]; ?></span>
        </div>
        <div class="bar">
            <div class="fill orange" style="width: <?php echo $selected_percent; ?>%;"></div>
        </div>
    </div>

    <div class="item">
        <div class="label">
            <?php
               $sql="select count(*) as total_rejected from applications where status='Rejected'";
               $result=mysqli_query($conn,$sql);
               $row=mysqli_fetch_assoc($result);
               $rejected_percent = ($total > 0) ? ($row["total_rejected"] / $total) * 100 : 0;
            ?>
            <span class="data">Rejected Applications</span>
            <span class="data"><?php echo $row["total_rejected"]; ?></span>
        </div>
        <div class="bar">
            <div class="fill yellow" style="width: <?php echo $rejected_percent; ?>%;"></div>
        </div>
    </div>

</div>

<div class="job-card">
    <h2 style="color: #1d4ed8;margin-bottom: 10px;font-weight: 800;">Top 5 Recent Job Titles</h2>

    <?php 
    $sql = "SELECT job_title FROM jobs ORDER BY created_at DESC LIMIT 5";
    $result = mysqli_query($conn, $sql);

    $count = 1;
    while($row = mysqli_fetch_assoc($result)){
    ?>
        <h2>#<?php echo $count; ?> <?php echo $row['job_title']; ?></h2>
    <?php
        $count++;
    }
    ?>
</div>

<div class="pie-chart">
    <?php
        $date=date("Y-m-d");
        $sql = "SELECT COUNT(*) as active FROM jobs WHERE application_deadline >= '$date'";
        $result = mysqli_query($conn, $sql);
        $active_row = mysqli_fetch_assoc($result);

        $new_sql = "SELECT COUNT(*) as inactive FROM jobs WHERE application_deadline < '$date'";
        $new_result = mysqli_query($conn, $new_sql);
        $inactive_row = mysqli_fetch_assoc($new_result);

        $active = $active_row['active'];
        $inactive = $inactive_row['inactive'];
    ?>
    <h2 style="margin-top: 20px;font-weight: 800;">Active & Inactive Jobs</h2>
    <canvas id="jobChart" width="70" height="60"></canvas>
 <script>
    const active = <?php echo $active; ?>;
    const inactive = <?php echo $inactive; ?>;

    const ctx = document.getElementById('jobChart').getContext('2d');
    const jobChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Active Jobs', 'Inactive Jobs'],
            datasets: [{
                data: [active, inactive], // ✅ dynamic values
                backgroundColor: [
                    '#28a745',
                    '#dc3545'
                ],
                borderWidth: 1
            }]
        },
        options: {
            plugins: {
                legend: {
                    position: 'right'
                }
            }
        }
    });
</script>

</div>
</div>

<?php
$current_date = date("Y-m-d");
$sql = "SELECT * FROM users order by created_at desc limit 5";
$result = mysqli_query($conn, $sql);
?>
<h2 style="text-align: center; margin-bottom: 30px;">Recent Registered Users</h2>
<table border="1" cellspacing="0" cellpadding="10">
    <tr>
        <th>User_id</th>
        <th>Name</th>
        <th>Email</th>
        <th>Password</th>
        <th>Role</th>
        <th>Registered Date</th>
    </tr>

    <?php
        if(mysqli_num_rows($result) > 0){
            while($row=mysqli_fetch_assoc($result)){
                echo "<tr>
            <td>" .$row['user_id']. "</td>
            <td>" .$row['name']. "</td>
            <td>" .$row['email']. "</td>
            <td>" .$row['password']. "</td>
            <td>" .$row['role']. "</td>
            <td>". date("d-m-Y", strtotime($row['created_at'])) ."</td>
            </tr>";
            }
        }
        else{
            echo "<tr><td colspan='6'>No Recent Records Found.</td></tr>";
        }
    ?>
</table>
<?php include 'footer.php' ?>
</body>
</html>