<?php
include ('auth.php');
include ('db_connect.php');

if(isset($_GET['application_id']) && isset($_GET['status']) && isset($_GET['job_id'])){

    $application_id = $_GET['application_id'];
    $status = $_GET['status'];
    $job_id = $_GET['job_id'];

    if($status == "Selected" || $status == "Rejected"){

        $sql = "UPDATE applications 
                SET status='$status' 
                WHERE application_id='$application_id'";

        $result = mysqli_query($conn, $sql);

        if($result){
            header("location: app.php?job_id=$job_id");
            exit();
        }
        else{
            die("Update Failed: " . mysqli_error($conn));
        }
    }
    else{
        die("Invalid status");
    }
}
else{
    die("Missing values");
}
?>