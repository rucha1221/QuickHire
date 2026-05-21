<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Total Jobs Seekers Table</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>
    <?php
    include ("headeradmin.php");
    include("db_connect.php");
    include("auth.php");
    $sql="select * from users where role!='admin'";
    $result=mysqli_query($conn,$sql);
    ?>
<h2 style="text-align: center; margin-bottom: 30px; margin-top: 40px;">List of Users</h2>
<table border="1" cellspacing="0" cellpadding="10">
    <tr>
        <th>User_id</th>
        <th>Name</th>
        <th>Email</th>
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
                <td>" .$row["role"]. "</td>
                <td>" .$row['created_at']. "</td>
                </tr>";
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