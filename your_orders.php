<?php
include("connection/connect.php");
session_start();


if (!isset($_SESSION["user_id"])) {
   
    header("Location: login.php");
    exit(); 
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <link href="css/your_order.css" rel="stylesheet">
</head>

<body class="home">
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
        <div class="container mt-5">
            <h2 class="text-center">My Orders</h2>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $query_res = mysqli_query($db, "SELECT * FROM users_orders WHERE u_id='" . $_SESSION['user_id'] . "'");
                    if(mysqli_num_rows($query_res) > 0) {
                        while($row = mysqli_fetch_array($query_res)) {
                    ?>
                    <tr>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo $row['quantity']; ?></td>
                        <td>₹<?php echo $row['price']; ?></td>
                        <td>
                            <?php
                            $status = $row['status'];
                            if($status == "" || $status == "NULL") {
                                echo '<button class="btn btn-info">Dispatch</button>';
                            } elseif($status == "in process") {
                                echo '<button class="btn btn-warning">On The Way</button>';
                            } elseif($status == "closed") {
                                echo '<button class="btn btn-success">Delivered</button>';
                            } elseif($status == "rejected") {
                                echo '<button class="btn btn-danger">Cancelled</button>';
                            }
                            ?>
                        </td>
                        <td><?php echo $row['date']; ?></td>
                        <td>
                            <a href="delete_orders.php?order_del=<?php echo $row['o_id'];?>" onclick="return confirm('Are you sure you want to cancel your order?');" class="btn btn-danger btn-sm">
                                <i class="fa fa-trash"></i> Cancel
                            </a>
                        </td>
                    </tr>
                    <?php 
                        }
                    } else {
                        echo '<tr><td colspan="6" class="text-center">You have no orders placed yet.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>

    <footer class="footer text-center mt-5">
        <p>&copy; 2024 Restaurant - All Rights Reserved</p>
    </footer>

</body>
</html>
