<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setting up</title>
</head>
<body>
    <?php
        $conn=mysqli_connect("localhost","root","","",3307);
        if(!$conn){
            die("connection failed.");
        }

        $sql="create database if not exists practice";
        if(mysqli_query($conn,$sql)){
            echo "database created successfully.";
        }
        else{
            echo "database creation failed.";
        }
        
        mysqli_close($conn);

        $con=mysqli_connect("localhost","root","","practice",3307);
        if(!$con){
            die("connection failed.");
        }

        $sql="create table if not exists login (id int(4) auto_increment primary key, email varchar(30) not null, password varchar(30) not null)";
        if(mysqli_query($con,$sql)){
            echo "table created successfully.";
        }
        else{
            echo "table creation failed.";
        }
    ?>
</body>
</html>