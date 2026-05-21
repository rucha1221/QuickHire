<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password page</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>
  <?php 
  include("db_connect.php"); 
  session_start();
  $email="";
  $emailErr="";

  if($_SERVER["REQUEST_METHOD"]=="POST"){
    $email=isset($_POST["email"]) ? trim($_POST["email"]) : "";

    if(empty($email)){
      $emailErr="Email is Mandatory";
    }
    else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $emailErr = "Invalid email format";
    } 

    if (empty($emailErr)) { 
    $sql = "SELECT user_id FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        $emailErr = "Email not found";
    }
    $_SESSION["reset_email"]=$email;
    header("location: forgotpswd2.php");
    exit();
}
  }
?>
  <?php include 'headerLanding.php'; ?>
    <div class="signup-background">
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="signup-form" style="height: 230px;">
        <h1 style="color: #1D4ED8; text-align: center;">Forgot Password</h1>
        <label>Email</label>
        <input type="email" placeholder="Email Address" name="email" value="<?php echo $email; ?>" required>
        <span style="color: red;"><?php echo "<br>" .$emailErr; ?></span>
        <button type="submit" class="reset">Send Reset Link</button>
      </form>
    </div>
</body>
</html>