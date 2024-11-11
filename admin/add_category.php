<!DOCTYPE html>
<html lang="en">
<?php
include("../connection/connect.php");
error_reporting(0);
session_start();

if (isset($_POST['submit'])) {
    if (empty($_POST['c_name'])) {
        $error = '<div class="alert alert-danger alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Field Required!</strong>
                    </div>';
    } else {
        $check_cat = mysqli_query($db, "SELECT c_name FROM res_category WHERE c_name = '" . $_POST['c_name'] . "'");

        if (mysqli_num_rows($check_cat) > 0) {
            $error = '<div class="alert alert-danger alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Category already exists!</strong>
                    </div>';
        } else {
            $mql = "INSERT INTO res_category(c_name) VALUES('" . $_POST['c_name'] . "')";
            mysqli_query($db, $mql);
            $success = '<div class="alert alert-success alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            New Category Added Successfully.
                        </div>';
        }
    }
}
?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Category</title>
    <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="css/add_category.css" rel="stylesheet">
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
        <?php echo $error; echo $success; ?>

        <div class="card mt-4">
            <div class="card-header">
                <h4 class="m-b-0 text-black">Add Restaurant Category</h4>
            </div>
            <form action='' method='post'>
                <div class="form-body p-4">
                    <div class="form-group">
                        <label for="c_name">Category Name</label>
                        <input type="text" name="c_name" class="form-control" id="c_name" required>
                    </div>
                    <div class="form-actions">
                        <button type="submit" name="submit" class="btn btn-primary">Save</button>
                        <a href="add_category.php" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>
            </form>
        </div>

        <div class="card mt-4">
            <div class="card-body">
                <h4 class="card-title">Listed Categories</h4>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Category Name</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM res_category ORDER BY c_id DESC";
                            $query = mysqli_query($db, $sql);

                            if (mysqli_num_rows($query) > 0) {
                                while ($rows = mysqli_fetch_array($query)) {
                                    echo '<tr>
                                            <td>' . $rows['c_id'] . '</td>
                                            <td>' . $rows['c_name'] . '</td>
                                            <td>' . $rows['date'] . '</td>
                                            <td>
                                                <a href="delete_category.php?cat_del=' . $rows['c_id'] . '" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></a>
         
                                            </td>
                                        </tr>';
                                }
                            } else {
                                echo '<tr><td colspan="4" class="text-center">No Categories Data!</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer bg-dark text-white text-center py-3">© 2024 - Restaurant</footer>

    <script src="js/lib/jquery/jquery.min.js"></script>
    <script src="js/lib/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>
