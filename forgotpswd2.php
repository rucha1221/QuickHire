<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password Page</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>
  <?php  
  include("db_connect.php");
  session_start();
  if (!isset($_SESSION['reset_email'])) {
    header("Location: forgot_password.php");
    exit;
}
else{
    $email=$_SESSION["reset_email"];
}
  $password="";
  $passwordErr="";
  $length="";
  $confirmPassword="";
  $confirmPasswordErr="";
  
  if($_SERVER["REQUEST_METHOD"]=="POST"){
    $password=$_POST["password"];
    $confirmPassword=$_POST["confirm_password"];
    $length=strlen($password);
    
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

    if(empty($confirmPassword)){
        $confirmPasswordErr = "Confirm password is required";
    }
    else if($password !== $confirmPassword){
        $confirmPasswordErr = "Passwords do not match";
    }
    
    if(empty($passwordErr) && empty($confirmPasswordErr)){
      $sql="update users set password='$confirmPassword' where email='$email'";
      if(mysqli_query($conn,$sql)){
        echo "<script> alert('Password Updated Successfully.'); window.location.href='login.php';</script>";
        
      }
      else{
        echo "<script> alert('Update Failed.'); </script>";
      }
    }
  }
  ?>
  <?php include 'headerLanding.php'; ?>
    <div class="signup-background">
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="signup-form" style="height: 310px;">
        <h1 style="color: #1D4ED8; text-align: center;">Forgot Password</h1>
        <label>New Password</label>
        <input type="password" placeholder="Password" name="password" required>
        <span style="color: red;"><?php echo "<br>" .$passwordErr; ?></span>
        <label>Confirm Password</label>
        <input type="password" placeholder="Password" name="confirm_password" required>
        <span style="color: red;"><?php echo "<br>" .$confirmPasswordErr; ?></span>
        <button type="submit" class="reset">Reset Password</button>
      </form>
    </div>
</body>
</html>