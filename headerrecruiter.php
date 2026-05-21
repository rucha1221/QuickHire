<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header of recruiter</title>
</head>
<body>
    <?php
        include ('db_connect.php');
        if(isset($_SESSION["name"])){
            $name=$_SESSION["name"];
        }
        else{
            echo "error occurred";
        }
    ?>
    <header>
        <div class="web-name">
        <i class="bi bi-person-square"></i>
        <h1>Quick<span style="color: #1D4ED8;">Hire</span></h1>
     </div> 
        <div class="menus">
            <a href="recruiterhome.php">Home</a>
            <a href="postjob.php">Post Job</a>
            <a href="jobsposted.php">My Posted Jobs & Applications</a>
            <h3 style="font-weight: 300;"><?php echo "Hi, " .$name; ?></h3>
            <a href="coprofile.php">Company Profile</a>
            <a href="logout.php">Logout</a>
        </div>
</header>
</body>
</html>