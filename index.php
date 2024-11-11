<!DOCTYPE html>
<html lang="en">
<?php
include("connection/connect.php");
error_reporting(0);
session_start();
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="css/styles.css" rel="stylesheet">
</head>

<body class="home">
    <header class="top-header">
        <nav class="navbar">
            <div class="container">
                <a class="navbar-brand" href="index.php"> 
                    <img src="images/logo.png" alt="Brand Logo"> 
                </a>
                <ul class="nav-links">
                    <li><a href="index.php" class="active">Home</a></li>
                    <li><a href="restaurants.php">Restaurants</a></li>
                    <?php if(empty($_SESSION["user_id"])) { ?>
                        <li><a href="login.php">Login</a></li>
                        <li><a href="registration.php">Register</a></li>
                    <?php } else { ?>
                        <li><a href="your_orders.php">My Orders</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    <?php } ?>
                </ul>
            </div>
        </nav>
    </header>

    <section class="hero">
        <div class="hero-content">
            <h1>Order Delivery & Take-Out</h1>
            <div class="steps">
                <div class="step">1. Choose Restaurant</div>
                <div class="step">2. Order Food</div>
                <div class="step">3. Delivery or Takeout</div>
            </div>
        </div>
    </section>

    <section class="popular">
        <div class="container">
            <h2>Popular Dishes of the Month</h2>
            <p class="lead">Order your favorite food from these top 6 dishes</p>
            <div class="dishes">
                <?php 
                $query_res = mysqli_query($db, "SELECT * FROM dishes LIMIT 6"); 
                while($r = mysqli_fetch_array($query_res)) {
                    echo '<div class="dish">
                            <img src="admin/Res_img/dishes/'.$r['img'].'" alt="'.$r['title'].'">
                            <h5><a href="dishes.php?res_id='.$r['rs_id'].'">'.$r['title'].'</a></h5>
                            <p>'.$r['slogan'].'</p>
                            <span class="price">₹'.$r['price'].'</span>
                            <a href="dishes.php?res_id='.$r['rs_id'].'" class="order-btn">Order Now</a>
                          </div>';
                } 
                ?>
            </div>
        </div>
    </section>
</body>
</html>
