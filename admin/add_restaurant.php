<!DOCTYPE html>
<html lang="en">
<?php
include("../connection/connect.php");
error_reporting(0);
session_start();

if (isset($_POST['submit'])) {
    if (empty($_POST['c_name']) || empty($_POST['res_name']) || $_POST['email'] == '' || $_POST['phone'] == '' || $_POST['url'] == '' || $_POST['o_hr'] == '' || $_POST['c_hr'] == '' || $_POST['o_days'] == '' || $_POST['address'] == '') {
        $error = '<div class="alert alert-danger">All fields must be filled!</div>';
    } else {
        $fname = $_FILES['file']['name'];
        $temp = $_FILES['file']['tmp_name'];
        $fsize = $_FILES['file']['size'];
        $extension = explode('.', $fname);
        $extension = strtolower(end($extension));
        $fnew = uniqid() . '.' . $extension;
        $store = "Res_img/" . basename($fnew);

        if ($extension == 'jpg' || $extension == 'png' || $extension == 'gif') {
            if ($fsize >= 1000000) {
                $error = '<div class="alert alert-danger">Max image size is 1024KB!</div>';
            } else {
                $res_name = $_POST['res_name'];
                $sql = "INSERT INTO restaurant(c_id,title,email,phone,url,o_hr,c_hr,o_days,address,image) VALUE('".$_POST['c_name']."','".$res_name."','".$_POST['email']."','".$_POST['phone']."','".$_POST['url']."','".$_POST['o_hr']."','".$_POST['c_hr']."','".$_POST['o_days']."','".$_POST['address']."','".$fnew."')";
                mysqli_query($db, $sql);
                move_uploaded_file($temp, $store);
                $success = '<div class="alert alert-success">New restaurant added successfully.</div>';
            }
        } elseif ($extension == '') {
            $error = '<div class="alert alert-danger">Please select an image.</div>';
        } else {
            $error = '<div class="alert alert-danger">Invalid image format. Only PNG, JPG, and GIF are accepted.</div>';
        }
    }
}
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Restaurant</title>
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
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-group textarea {
            height: 100px;
        }
        .btn {
            padding: 10px 20px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #218838;
        }
        .btn-cancel {
            background-color: #6c757d;
        }
        .btn-cancel:hover {
            background-color: #5a6268;
        }
        .alert {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
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
        <h1>Add Restaurant</h1>
        <?php echo $error; echo $success; ?>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="res_name">Restaurant Name</label>
                <input type="text" name="res_name" id="res_name" class="form-control">
            </div>
            <div class="form-group">
                <label for="email">Business Email</label>
                <input type="email" name="email" id="email" class="form-control">
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" name="phone" id="phone" class="form-control">
            </div>
            <div class="form-group">
                <label for="url">Website URL</label>
                <input type="text" name="url" id="url" class="form-control">
            </div>
            <div class="form-group">
                <label for="o_hr">Open Hours</label>
                <select name="o_hr" id="o_hr" class="form-control">
                    <option value="">--Select Open Hours--</option>
                    <option value="6am">6am</option>
                    <option value="7am">12am</option>
                    <option value="8am">8pm</option>
                </select>
            </div>
            <div class="form-group">
                <label for="c_hr">Close Hours</label>
                <select name="c_hr" id="c_hr" class="form-control">
                    <option value="">--Select Close Hours--</option>
                    <option value="3pm">10am</option>
                    <option value="4pm">3pm</option>
                    <option value="5pm">11pm</option>
                </select>
            </div>
            <div class="form-group">
                <label for="o_days">Open Days</label>
                <select name="o_days" id="o_days" class="form-control">
                    <option value="">--Select Open Days--</option>
                    <option value="Mon-Tue">Mon-Tue</option>
                    <option value="Mon-Wed">Mon-Wed</option>
                    <option value="Mon-Fri">Mon-Fri</option>
                </select>
            </div>
            <div class="form-group">
                <label for="file">Restaurant Image</label>
                <input type="file" name="file" id="file" class="form-control">
            </div>
            <div class="form-group">
                <label for="c_name">Select Category</label>
                <select name="c_name" id="c_name" class="form-control">
                    <option value="">--Select Category--</option>
                    <?php
                    $ssql = "SELECT * FROM res_category";
                    $res = mysqli_query($db, $ssql);
                    while ($row = mysqli_fetch_array($res)) {
                        echo '<option value="' . $row['c_id'] . '">' . $row['c_name'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="address">Restaurant Address</label>
                <textarea name="address" id="address" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <input type="submit" name="submit" class="btn" value="Save">
                
            </div>
        </form>
    </div>
</body>
</html>
