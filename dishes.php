<?php
include("connection/connect.php");
session_start();
include_once 'product-action.php';

if (!isset($_SESSION["cart_item"])) {
    $_SESSION["cart_item"] = [];
}

if (isset($_GET['action']) && $_GET['action'] == 'add' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $quantity = $_POST['quantity'] ?? 1; 

    $result = mysqli_query($db, "SELECT * FROM dishes WHERE d_id='$id'");
    $product = mysqli_fetch_assoc($result);

    if (!isset($_SESSION["cart_item"])) {
        $_SESSION["cart_item"] = [];
    }

    $found = false;
    foreach ($_SESSION["cart_item"] as &$item) {
        if ($item['d_id'] == $product['d_id']) {
            $item['quantity'] = $quantity; 
            $found = true;
            break;
        }
    }

    if (!$found) {
        $_SESSION["cart_item"][] = [
            'd_id' => $product['d_id'],
            'title' => $product['title'],
            'price' => $product['price'],
            'quantity' => $quantity,
        ];
    }

    header("Location: dishes.php?res_id={$_GET['res_id']}");
    exit();
}

if (isset($_GET['action']) && $_GET['action'] == 'remove' && isset($_GET['id'])) {
    $id = $_GET['id'];

    foreach ($_SESSION["cart_item"] as $key => $item) {
        if ($item['d_id'] == $id) {
            unset($_SESSION["cart_item"][$key]);
        }
    }

    header("Location: dishes.php?res_id={$_GET['res_id']}");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dishes</title>
    <link rel="stylesheet" href="css/dishes.css">
</head>

<body>
    <header>
        <nav>
        <a href="index.php" class="brand">
            <img src="images/logo.png" alt="Restaurant App Logo" class="logo-image">
        </a>            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="restaurants.php">Restaurants</a></li>
                <?php
                if (empty($_SESSION["user_id"])) {
                    echo '<li><a href="login.php">Login</a></li>';
                    echo '<li><a href="registration.php">Register</a></li>';
                } else {
                    echo '<li><a href="your_orders.php">My Orders</a></li>';
                    echo '<li><a href="logout.php">Logout</a></li>';
                }
                ?>
            </ul>
        </nav>
    </header>

    <main>
        <div class="restaurant-info">
            <?php
            $ress = mysqli_query($db, "SELECT * FROM restaurant WHERE rs_id='$_GET[res_id]'");
            $rows = mysqli_fetch_array($ress);
            echo "<h2>{$rows['title']}</h2>";
            echo "<p>{$rows['address']}</p>";
            ?>
        </div>

        <div class="menu-section">
            <h3>MENU</h3>
            <?php
            $stmt = $db->prepare("SELECT * FROM dishes WHERE rs_id='$_GET[res_id]'");
            $stmt->execute();
            $products = $stmt->get_result();
            foreach ($products as $product) {
                echo "
                    <div class='menu-item'>
                        <img src='admin/Res_img/dishes/{$product['img']}' alt='Food Image'>
                        <div class='item-info'>
                            <h4>{$product['title']}</h4>
                            <p>{$product['slogan']}</p>
                            <p>₹" . number_format($product['price'], 2) . "</p>
                            <form method='post' action='dishes.php?res_id={$_GET['res_id']}&action=add&id={$product['d_id']}'>
                                <input type='number' name='quantity' value='1' min='1'>
                                <button type='submit'>Add To Cart</button>
                            </form>
                        </div>
                    </div>";
            }
            ?>
        </div>

        <div class="cart">
    <h3>Your Cart</h3>
    <?php
    $item_total = 0;

    if (!empty($_SESSION["cart_item"])) {
        foreach ($_SESSION["cart_item"] as $item) {
            $item_total += $item['price'] * $item['quantity']; 
            echo "
                <div class='cart-item'>
                    <span>{$item['title']}</span>
                    <span>₹" . number_format($item['price'], 2) . "</span> 
                    <span>Quantity: {$item['quantity']}</span> 
                    <span>Total: ₹" . number_format($item['price'] * $item['quantity'], 2) . "</span> 
                    <a href='dishes.php?res_id={$_GET['res_id']}&action=remove&id={$item['d_id']}' class='remove'>Remove</a>
                </div>";
        }
        echo "<p>Total: ₹" . number_format($item_total, 2) . "</p>"; 
    } else {
        echo "<p>Your cart is empty.</p>";
    }
    ?>
    <a href="checkout.php?res_id=<?php echo $_GET['res_id']; ?>&action=check" class="checkout">Checkout</a>
</div>

    </main>
</body>

</html>
