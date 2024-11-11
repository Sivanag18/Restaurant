<!DOCTYPE html>
<html lang="en">
<?php
include("../connection/connect.php");
error_reporting(0);
session_start();

if(isset($_POST['submit'])) {
    if(empty($_POST['d_name']) || empty($_POST['about']) || $_POST['price'] == '' || $_POST['res_name'] == '') {    
        $error = '<div class="alert alert-danger">All fields must be filled out!</div>';
    } else {
        $fname = $_FILES['file']['name'];
        $temp = $_FILES['file']['tmp_name'];
        $fsize = $_FILES['file']['size'];
        $extension = strtolower(pathinfo($fname, PATHINFO_EXTENSION));
        $fnew = uniqid().'.'.$extension;
        $store = "Res_img/dishes/".basename($fnew);

        if(in_array($extension, ['jpg', 'png', 'gif'])) {
            if($fsize >= 1000000) {
                $error = '<div class="alert alert-danger">Max Image Size is 1MB!</div>';
            } else {
                $sql = "INSERT INTO dishes(rs_id, title, slogan, price, img) VALUES('".$_POST['res_name']."','".$_POST['d_name']."','".$_POST['about']."','".$_POST['price']."','".$fnew."')";
                mysqli_query($db, $sql);
                move_uploaded_file($temp, $store);
                $success = '<div class="alert alert-success">New Dish Added Successfully.</div>';
            }
        } else {
            $error = '<div class="alert alert-danger">Invalid extension! Only png, jpg, and gif are accepted.</div>';
        }
    }
}
?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Menu</title>
    <style>
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
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .alert {
            padding: 15px;
            margin: 10px 0;
            border-radius: 4px;
            color: white;
        }
        .alert-danger {
            background-color: #f44336;
        }
        .alert-success {
            background-color: #4CAF50;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .form-control:focus {
            border-color: #5b9bd5;
            outline: none;
        }
        .btn {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #45a049;
        }
        .form-actions {
            text-align: center;
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

    <div class="container">
        <h1>Add Menu</h1>

        <?php echo $error; echo $success; ?>

        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="d_name">Dish Name</label>
                <input type="text" id="d_name" name="d_name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="about">Description</label>
                <input type="text" id="about" name="about" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input type="text" id="price" name="price" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="file">Image</label>
                <input type="file" id="file" name="file" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="res_name">Select Restaurant</label>
                <select name="res_name" id="res_name" class="form-control" required>
                    <option value="">--Select Restaurant--</option>
                    <?php 
                        $ssql = "SELECT * FROM restaurant";
                        $res = mysqli_query($db, $ssql);
                        while($row = mysqli_fetch_array($res)) {
                            echo '<option value="'.$row['rs_id'].'">'.$row['title'].'</option>';
                        } 
                    ?>
                </select>
            </div>

            <div class="form-actions">
                <input type="submit" name="submit" class="btn" value="Save">
                <a href="add_menu.php" class="btn" style="background-color: #ccc;">Cancel</a>
            </div>
        </form>
    </div>

</body>
</html>
