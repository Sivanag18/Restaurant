<?php
session_start(); 
error_reporting(0); 
include("connection/connect.php"); 

if(isset($_POST['submit'])) {
    if(empty($_POST['firstname']) || 
    empty($_POST['lastname'])|| 
    empty($_POST['email']) ||  
    empty($_POST['phone'])||
    empty($_POST['password'])||
    empty($_POST['cpassword'])) {
        $message = "All fields must be Required!";
    }
    else {
        $check_username= mysqli_query($db, "SELECT username FROM users where username = '".$_POST['username']."' ");
        $check_email = mysqli_query($db, "SELECT email FROM users where email = '".$_POST['email']."' ");
        
        if($_POST['password'] != $_POST['cpassword']){  
            echo "<script>alert('Password not match');</script>"; 
        }
        elseif(strlen($_POST['password']) < 6) {
            echo "<script>alert('Password Must be >=6');</script>"; 
        }
        elseif(strlen($_POST['phone']) < 10) {
            echo "<script>alert('Invalid phone number!');</script>"; 
        }
        elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            echo "<script>alert('Invalid email address please type a valid email!');</script>"; 
        }
        elseif(mysqli_num_rows($check_username) > 0) {
            echo "<script>alert('Username Already exists!');</script>"; 
        }
        elseif(mysqli_num_rows($check_email) > 0) {
            echo "<script>alert('Email Already exists!');</script>"; 
        }
        else {
            $mql = "INSERT INTO users(username,f_name,l_name,email,phone,password,address) VALUES('".$_POST['username']."','".$_POST['firstname']."','".$_POST['lastname']."','".$_POST['email']."','".$_POST['phone']."','".md5($_POST['password'])."','".$_POST['address']."')";
            mysqli_query($db, $mql);
            header("refresh:0.1;url=login.php");
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/registration.css" rel="stylesheet">
</head>
<body>

<header>
    <nav>
        <div class="container">
            <a href="index.php" class="logo">
                <img src="images/logo.png" alt="Restaurant App Logo" class="logo-image">
            </a>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="restaurants.php">Restaurants</a></li>
                <?php if(empty($_SESSION["user_id"])): ?>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="registration.php">Register</a></li>
                <?php else: ?>
                    <li><a href="your_orders.php">My Orders</a></li>
                    <li><a href="logout.php">Logout</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
</header>

<div class="registration-form">
    <div class="container">
        <h2 class="text-center">Register</h2>
        <form action="" method="post">
            <div class="form-group">
                <label for="username">User Name</label>
                <input class="form-control" type="text" name="username" id="username" required>
            </div>
            <div class="form-group">
                <label for="firstname">First Name</label>
                <input class="form-control" type="text" name="firstname" id="firstname" required>
            </div>
            <div class="form-group">
                <label for="lastname">Last Name</label>
                <input class="form-control" type="text" name="lastname" id="lastname" required>
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" class="form-control" name="email" id="email" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input class="form-control" type="text" name="phone" id="phone" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" id="password" required>
            </div>
            <div class="form-group">
                <label for="cpassword">Confirm Password</label>
                <input type="password" class="form-control" name="cpassword" id="cpassword" required>
            </div>
            <div class="form-group">
                <label for="address">Delivery Address</label>
                <textarea class="form-control" name="address" id="address" rows="3" required></textarea>
            </div>
            <div class="form-group text-center">
                <input type="submit" value="Register" name="submit" class="btn btn-primary">
            </div>
        </form>
    </div>
</div>

<footer>
    <div class="container text-center">
        <p>&copy; 2024 Restaurant - All Rights Reserved</p>
    </div>
</footer>

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
