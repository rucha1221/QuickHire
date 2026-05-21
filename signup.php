<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>
  <?php 
  session_start();
  include("db_connect.php"); 
  $name="";
  $nameErr="";
  $password="";
  $passwordErr="";
  $length="";
  $email="";
  $emailErr="";
  $role="";
  $roleErr="";
  $msg="";

  if($_SERVER["REQUEST_METHOD"]=="POST"){
    $name=isset($_POST["name"]) ? trim($_POST["name"]) : "";
    $password=$_POST["password"];
    $length=strlen($password);
    $email=isset($_POST["email"]) ? trim($_POST["email"]) : "";
    $role=$_POST["role"];
    
    if(empty($name)){
      $nameErr="Name is Mandatory";
    }
    else if(!preg_match("/^[A-Za-z ]+$/",$name)){
      $nameErr="Name must contain only Letters";
    }

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
if(empty($nameErr) && empty($emailErr) && empty($passwordErr) && empty($roleErr)) {

        // Check if email already exists
        $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
        if(mysqli_num_rows($check) > 0){
            echo "<script>alert('Email already registered!'); window.location='signup.php';</script>";
            exit();
        } else {
            // Insert new user
            $sql = "INSERT INTO users (name, email, password, role) 
                    VALUES ('$name', '$email', '$password', '$role')";
            if(mysqli_query($conn, $sql)){
                // ✅ Set session for new user
                $_SESSION['logged_in'] = true;
                $_SESSION['username'] = $name;
                $_SESSION['user_id'] = mysqli_insert_id($conn);
                $_SESSION['role']=$role;

                // Redirect based on role
                if($role=="Job Seeker"){
                    header("Location: jobseekerhome.php");
                    exit();
                } else if($role=="Recruiter"){
                    header("Location: recruiterhome.php");
                    exit();
                } else if($name=="Admin" && $email=="admin@gmail.com" && $role=="admin"){
                    header("Location: admin.php");
                    exit();
                }
            } else {
                echo "<script>alert('Insert Failed.'); window.location='signup.php';</script>";
                exit();
            }
        }
    }  }
  ?>
  <?php include 'headerLanding.php'; ?>
    <div class="signup-background">
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="signup-form" style="height: 560px;">
        <h1 style="color: #1D4ED8; text-align: center;">Sign Up</h1>
        <label>Full Name</label>
        <input type="text" placeholder="Full Name" name="name" required>
        <span style="color: red;"><?php echo "<br>" .$nameErr; ?></span>
        <label>Email</label>
        <input type="email" placeholder="Email Address" name="email" required>
        <span style="color: red;"><?php echo "<br>" .$emailErr; ?></span>
        <label>Password</label>
        <input type="password" placeholder="Create Password" name="password" required>
        <span style="color: red;"><?php echo "<br>" .$passwordErr; ?></span>
        <label>Role</label>
        <select name="role" required>
          <option value="">---Select Role---</option>
          <option value="Job Seeker">Job Seeker</option>
          <option value="Recruiter">Recruiter</option>
          <option value="admin">Admin</option>
        </select>
        <span style="color: red;"><?php echo "<br>" .$roleErr; ?></span>
        <button type="submit" class="login" id="signup-submit" name="submit">Create Account</button>
        <p class="hasaccount">Already have an Account?</p>
        <a href="login.php" class="go-to-login">Login</a>
      </form>
    </div>
</body>
</html>