
<?php 
session_start(); // Start session

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    // Redirect to login page if not authenticated
    header("Location: login.php");
    exit();
}

include_once('../../database/connection.php');
include('header-admin.php');




include('sidebar-admin.php');
?>
<div class="page-content">

<?php
if (isset($_POST['add_hospital'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $query = "INSERT INTO hospital (name, email, phone, address) VALUES ('$name', '$email', '$phone', '$address')";
    $result = mysqli_query($con, $query);

    if ($result) {
        echo "<script>alert('Hospital added successfully!');</script>";
    } else {
        echo "<script>alert('Error adding hospital!');</script>";
    }
}
?>

<div class="page-content">
    <div class="container mt-5">
        <h2>Add New Hospital</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="name">Hospital Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="text" class="form-control" id="phone" name="phone" required>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
            </div>
            <button type="submit" name="add_hospital" class="btn btn-primary">Add Hospital</button>
        </form>
    </div>
</div>







</div>

<?php 
include('footer-admin.php');
?>