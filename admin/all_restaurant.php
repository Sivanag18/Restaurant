<!DOCTYPE html>
<html lang="en">
<?php
include("../connection/connect.php");
error_reporting(0);
session_start();
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>All Restaurants</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f7f7f7;
        }

        .navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #343a40;
            padding: 10px 20px;
            color: white;
        }

        .navbar .logo-image {
            height: 40px;
        }

        .navbar .nav-links {
            display: flex;
            gap: 15px;
        }

        .navbar .nav-links a,
        .navbar .logout-btn {
            text-decoration: none;
            color: white;
            padding: 8px 12px;
            border-radius: 5px;
        }

        .navbar .logout-btn {
            background-color: #dc3545;
        }

        .navbar .nav-links a:hover,
        .navbar .logout-btn:hover {
            background-color: #495057;
        }

        main {
            padding: 20px;
        }

        .table-container {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            margin-top: 20px;
        }

        .restaurant-table {
            width: 100%;
            border-collapse: collapse;
        }

        .restaurant-table th, .restaurant-table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .no-data {
            text-align: center;
            color: #999;
            font-style: italic;
        }

        footer {
            text-align: center;
            padding: 10px;
            background-color: #343a40;
            color: white;
        }
    </style>
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

    <main>
        <h2>All Restaurants</h2>
        <div class="table-container">
            <table class="restaurant-table">
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql="SELECT * FROM restaurant ORDER BY rs_id DESC";
                    $query=mysqli_query($db,$sql);
                    if(!mysqli_num_rows($query) > 0) {
                        echo '<tr><td colspan="5" class="no-data">No Restaurants</td></tr>';
                    } else {
                        while($rows=mysqli_fetch_array($query)) {
                            $mql="SELECT * FROM res_category WHERE c_id='".$rows['c_id']."'";
                            $res=mysqli_query($db,$mql);
                            $row=mysqli_fetch_array($res);

                            echo '<tr>
                                    <td>'.$row['c_name'].'</td>
                                    <td>'.$rows['title'].'</td>
                                    <td>'.$rows['email'].'</td>
                                    <td>'.$rows['phone'].'</td>
                                    <td>'.$rows['address'].'</td>
                                  </tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>

    <footer>
        <p>© 2024 - Restaurant </p>
    </footer>
</body>
</html>
