<?php
include("connection/connect.php");
include_once 'product-action.php';
session_start();

if(empty($_SESSION["user_id"])) {
    header('location:login.php');
    exit();
}

$success = '';
$item_total = 0;

if (isset($_SESSION["cart_item"]) && !empty($_SESSION["cart_item"])) {
    foreach ($_SESSION["cart_item"] as $item) {
        $item_total += $item["price"] * $item["quantity"];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    if (!empty($_SESSION["cart_item"])) {
        foreach ($_SESSION["cart_item"] as $item) {
            $SQL = "INSERT INTO users_orders(u_id, title, quantity, price) VALUES('".$_SESSION["user_id"]."', '".$item["title"]."', '".$item["quantity"]."', '".$item["price"]."')";
            mysqli_query($db, $SQL);
        }

        unset($_SESSION["cart_item"]);
        $success = "Thank you. Your order has been placed!";

        echo "<script>
                alert('Thank you! Your order has been confirmed.');
                setTimeout(function() {
                    window.location.href = 'index.php';
                }, 2000); 
              </script>";
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link href="css/checkout.css" rel="stylesheet"> 
</head>
<body>

<header class="header">
    <nav>
        <a href="index.php" class="logo"><img src="images/logo.png" alt="Logo"></a>
        <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="restaurants.php">Restaurants</a></li>
            <?php if (empty($_SESSION["user_id"])): ?>
                <li><a href="login.php">Login</a></li>
                <li><a href="registration.php">Register</a></li>
            <?php else: ?>
                <li><a href="your_orders.php">My Orders</a></li>
                <li><a href="logout.php">Logout</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<main class="checkout-page">
    <div class="container">
        <?php if ($success): ?>
            <div class="alert success"><?php echo $success; ?></div>
        <?php endif; ?>

        <h4>Cart Summary</h4>
        <table>
            <tr>
                <td>Cart Subtotal</td>
                <td><?php echo "₹" . number_format($item_total, 2); ?></td>
            </tr>
            <tr>
                <td>Delivery Charges</td>
                <td>Free</td>
            </tr>
            <tr>
                <td><strong>Total</strong></td>
                <td><strong><?php echo "₹" . number_format($item_total, 2); ?></strong></td>
            </tr>
        </table>

        <div class="payment-option">
            <label>
                <input type="radio" name="mod" value="COD" checked> Cash on Delivery
            </label>
        </div>

        <form action="" method="POST">
            <button type="submit" name="submit" class="btn-submit">Order Now</button>
        </form>
    </div>
</main>

<footer class="footer">
    <p>&copy; 2024 Restaurant | All Rights Reserved</p>
</footer>

<script src="js/main.js"></script>
</body>
</html>
