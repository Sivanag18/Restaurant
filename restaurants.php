<!DOCTYPE html>
<html lang="en">
<?php
include("connection/connect.php");
session_start();
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Restaurants</title>
    <link rel="stylesheet" href="css/restaurant.css">
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


<main>
    <section class="top-links">
        <div class="container">
            <ul class="steps">
                <li>1. Choose Restaurant</li>
                <li>2. Pick Your Favorite Food</li>
                <li>3. Order and Pay</li>
            </ul>
        </div>
    </section>

    <section class="restaurants">
        <div class="container">
            <div class="restaurant-list">
                <?php
                $result = mysqli_query($db, "SELECT * FROM restaurant");
                while($row = mysqli_fetch_array($result)) {
                    echo '<div class="restaurant-card">
                            <a href="dishes.php?res_id='.$row['rs_id'].'">
                                <img src="admin/Res_img/'.$row['image'].'" alt="Restaurant Logo">
                            </a>
                            <h3>'.$row['title'].'</h3>
                            <p>'.$row['address'].'</p>
                            <a href="dishes.php?res_id='.$row['rs_id'].'" class="view-menu-btn">View Menu</a>
                          </div>';
                }
                ?>
            </div>
        </div>
    </section>
</main>

</body>
</html>
