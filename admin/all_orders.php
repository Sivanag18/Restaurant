<!DOCTYPE html>
<html lang="en">
<?php
include("../connection/connect.php");
session_start();
?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>All Orders</title>
    <link rel="stylesheet" href="css/all_orders.css"> <!-- Use simpler CSS -->
</head>

<body>
<header>
        <div class="navbar">
            <a href="all_restaurant.php">
                <img src="images/logo.png" alt="Logo" class="logo-image">
            </a>
            <div class="nav-links">
                <a href="all_restaurant.php">All Restaurants</a>
                <a href="add_category.php">Add Category</a>
                <a href="add_restaurant.php">Add Restaurant</a>
               
                <a href="add_menu.php">Add Menu</a>
                <a href="all_orders.php">Orders</a>
            </div>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </header>

    <div class="container">
        <h1>All Orders</h1>
        <table>
            <thead>
                <tr>
                    <th>User</th>        
                    <th>Title</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Address</th>
                    <th>Status</th>                                  
                    <th>Reg-Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql = "SELECT users.*, users_orders.* FROM users INNER JOIN users_orders ON users.u_id=users_orders.u_id";
                    $query = mysqli_query($db, $sql);

                    if (mysqli_num_rows($query) > 0) {
                        while ($rows = mysqli_fetch_array($query)) {
                ?>
                <tr>
                    <td><?php echo $rows['username']; ?></td>
                    <td><?php echo $rows['title']; ?></td>
                    <td><?php echo $rows['quantity']; ?></td>
                    <td>$<?php echo $rows['price']; ?></td>
                    <td><?php echo $rows['address']; ?></td>
                    <td>
                        <?php
                        $status = $rows['status'];
                        if ($status == "" || $status == "NULL") {
                            echo '<button class="btn">Dispatch</button>';
                        } elseif ($status == "in process") {
                            echo '<button class="btn">On The Way!</button>';
                        } elseif ($status == "closed") {
                            echo '<button class="btn">Delivered</button>';
                        } elseif ($status == "rejected") {
                            echo '<button class="btn">Cancelled</button>';
                        }
                        ?>
                    </td>
                    <td><?php echo $rows['date']; ?></td>
                    <td>
                        <a href="delete_orders.php?order_del=<?php echo $rows['o_id'];?>" onclick="return confirm('Are you sure?');" class="btn">Delete</a>
                        <a href="order_update.php?form_id=<?php echo $rows['o_id']; ?>" class="btn">Edit</a>
                        </td>
                </tr>
                <?php
                        }
                    } else {
                        echo '<tr><td colspan="8">No Orders</td></tr>';
                    }
                ?>
            </tbody>
        </table>
    </div>

</body>
</html>
