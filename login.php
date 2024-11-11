<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: Arial, sans-serif;
    }

    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background-color: #f0f0f0;
    }

    .login-container {
      width: 300px;
      padding: 20px;
      background-color: #fff;
      border-radius: 5px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      text-align: center;
    }

    .login-container h2 {
      margin-bottom: 20px;
      color: #333;
    }

    .login-container input[type="text"],
    .login-container input[type="password"] {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #ddd;
      border-radius: 3px;
    }

    .login-container input[type="submit"] {
      width: 100%;
      padding: 10px;
      background-color: #5c4ac7;
      border: none;
      color: #fff;
      font-weight: bold;
      cursor: pointer;
      border-radius: 3px;
    }

    .login-container .register-link {
      display: block;
      margin-top: 10px;
      color: #5c4ac7;
      text-decoration: none;
    }
  </style>
</head>

<body>

<?php
include("connection/connect.php"); 
error_reporting(0); 
session_start();

if(isset($_POST['submit'])) { 
    $username = $_POST['username'];  
    $password = $_POST['password'];
    
    if(!empty($username) && !empty($password)) { 
        $loginquery = "SELECT * FROM users WHERE username='$username' AND password='".md5($password)."'";
        $result = mysqli_query($db, $loginquery);
        $row = mysqli_fetch_array($result);

        if(is_array($row)) {
            $_SESSION["user_id"] = $row['u_id'];
            header("Location: index.php");
            exit();
        } else {
            $message = "Invalid Username or Password!";
        }
    } else {
        $message = "Please enter both username and password!";
    }
}
?>


<div class="login-container">
  <h2>Login to your account</h2>

  <?php if (isset($message)) echo "<p style='color: red;'>$message</p>"; ?>

  <form action="" method="post">
    <input type="text" placeholder="Username" name="username" required>
    <input type="password" placeholder="Password" name="password" required>
    <input type="submit" name="submit" value="Login">
  </form>

  <a class="register-link" href="registration.php">Not registered? Create an account</a>
</div>

</body>
</html>
