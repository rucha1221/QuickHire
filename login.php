<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>
  <?php 
  session_start();
  include("db_connect.php"); 
  $password="";
  $passwordErr="";
  $length="";
  $email="";
  $emailErr="";
  $role="";
  $roleErr="";

  if($_SERVER["REQUEST_METHOD"]=="POST"){
    $password=$_POST["password"];
    $length=strlen($password);
    $email=isset($_POST["email"]) ? trim($_POST["email"]) : "";
    $role=$_POST["role"];
    
    if(empty($password)){
      $passwordErr="Password is Mandatory";
    }
    else if($length < 8){
      $passwordErr="Password must contain atleast 8 characters";
    }
    else if(!preg_match("/[A-Z]/",$password)){
      $passwordErr="Password must contain atleast 1 Uppercase Letter";
    }
    else if(!preg_match("/[a-z]/",$password)){
      $passwordErr="Password must contain atleast 1 Lowercase Letter";
    }
    else if(!preg_match("/[\W]/",$password)){
      $passwordErr="Password must contain atleast 1 special symbol Letter";
    }

    if(empty($email)){
      $emailErr="Email is Mandatory";
    }
    else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $emailErr = "Invalid email format";
    } 

    if(empty($role)){
      $roleErr="Select a Role";
    }
    
    if(empty($passwordErr) && empty($emailErr) && empty($roleErr)){
       $sql="select * from users where email='$email' AND password='$password' AND role='$role'";
       $result=mysqli_query($conn,$sql);

       if(mysqli_num_rows($result)==1){
        $row=mysqli_fetch_assoc($result);

        $_SESSION["user_id"]=$row["user_id"];
        $_SESSION["name"]=$row["name"];
        $_SESSION["email"]=$row["email"];
        $_SESSION["role"]=$row["role"];
        $_SESSION["logged_in"]=true;
        if($role=="Job Seeker"){
          header("location: jobseekerhome.php");
          exit();
        }
        else if($role=="Recruiter"){
          header("location: recruiterhome.php");
          exit();
        }
        else if($role=="admin"){
          header("location: admin.php");
          exit();
        }
       }
       else{
        echo "<script> alert('You may have entered incorrect details or you have not signed up yet.'); </script>";
       }
    }
  }
  ?>
  <?php include 'headerLanding.php'; ?>
    <div class="signup-background">
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="signup-form" style="height: 480px;">
        <h1 style="color: #1D4ED8; text-align: center;">Login</h1>
        <label>Email</label>
        <input type="email" placeholder="Email Address" name="email" value="<?php echo $email; ?>" required>
        <span style="color: red;"><?php echo "<br>" .$emailErr; ?></span>
        <label>Password</label>
        <input type="password" placeholder="Password" name="password" required>
        <span style="color: red;"><?php echo "<br>" .$passwordErr; ?></span>
        <label>Role</label>
        <select name="role" required>
          <option value="">---Select Role---</option>
          <option value="Job Seeker">Job Seeker</option>
          <option value="Recruiter">Recruiter</option>
          <option value="admin">Admin</option>
        </select>
        <span style="color: red;"><?php echo "<br>" .$roleErr; ?></span>
        <a href="forgotpswd.php" class="nopswd">Forgot Password</a>
        <button type="submit" class="login" id="signup-submit">Login</button>
        <p class="hasaccount">Don't have an Account?</p>
        <a href="signup.php" class="go-to-login">Sign-Up</a>
      </form>
    </div> 
</body>
</html>