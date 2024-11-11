<!DOCTYPE html>
<html lang="en">
<?php
include("../connection/connect.php");
error_reporting(0);
session_start();

if(strlen($_SESSION['user_id'])==0) { 
    header('location:../login.php');
} else {
    if(isset($_POST['update'])) {
        $form_id = $_GET['form_id'];
        $status = $_POST['status'];
        $remark = $_POST['remark'];
        $query = mysqli_query($db, "INSERT INTO remark(frm_id, status, remark) VALUES('$form_id', '$status', '$remark')");
        $sql = mysqli_query($db, "UPDATE users_orders SET status='$status' WHERE o_id='$form_id'");

        echo "<script>alert('Form Details Updated Successfully');</script>";
    }
}
?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Update</title>
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        .dialog-container {
            width: 300px;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
        }
        .dialog-container h2 {
            margin-top: 0;
            font-size: 18px;
            color: #333;
        }
        .form-group {
            margin: 15px 0;
            text-align: left;
        }
        select, textarea, input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .btn-primary {
            background-color: #004684;
            color: white;
            border: none;
            cursor: pointer;
        }
        .btn-secondary {
            background-color: #777;
            color: white;
            border: none;
            cursor: pointer;
            margin-top: 10px;
        }
        .btn-primary:hover, .btn-secondary:hover {
            opacity: 0.9;
        }
    </style>
</head>

<body>
<div class="dialog-container">
    <h2>Update Order Status</h2>
    <form name="updateticket" method="post"> 
        <div class="form-group">
            <label><b>Order ID:</b> <?php echo htmlentities($_GET['form_id']); ?></label>
        </div>
        <div class="form-group">
            <label>Status</label>
            <select name="status" required>
                <option value="">Select Status</option>
                <option value="in process">On the way</option>
                <option value="closed">Delivered</option>
                <option value="rejected">Cancelled</option>
            </select>
        </div>
        <div class="form-group">
            <label>Message</label>
            <textarea name="remark" rows="3" required></textarea>
        </div>
        <input type="submit" name="update" value="Submit" class="btn-primary">
        <input type="button" value="Close" class="btn-secondary" onclick="window.location.href='all_orders.php';">
        </form>
</div>
</body>
</html>
