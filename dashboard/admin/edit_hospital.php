<?php
session_start(); // Start session

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    // Redirect to login page if not authenticated
    header("Location: login.php");
    exit();
}

ob_start(); // Start output buffering
include_once('../../database/connection.php');
include('header-admin.php');
include('sidebar-admin.php');

// Get hospital ID from the URL
$hospital_id = $_GET['id'];

// Fetch hospital details for editing
$query = "SELECT * FROM hospital WHERE hospital_id = '$hospital_id'";
$result = mysqli_query($con, $query);
$hospital = mysqli_fetch_assoc($result);

// Handle form submission for updating
if (isset($_POST['update_hospital'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $update_query = "UPDATE hospital 
                     SET name = '$name', email = '$email', phone = '$phone', address = '$address' 
                     WHERE hospital_id = '$hospital_id'";
    if (mysqli_query($con, $update_query)) {
        header('Location: show_hospital.php'); // Redirect to hospital list
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($con);
    }
}
?>

<div class="page-content">
    <div class="container mt-5">
        <h2>Edit Hospital</h2>
        <form method="POST">
            <div class="form-group">
                <label for="name">Hospital Name:</label>
                <input type="text" id="name" name="name" class="form-control" value="<?php echo $hospital['name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control" value="<?php echo $hospital['email']; ?>" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" class="form-control" value="<?php echo $hospital['phone']; ?>" required>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <textarea id="address" name="address" class="form-control" required><?php echo $hospital['address']; ?></textarea>
            </div>
            <button type="submit" name="update_hospital" class="btn btn-primary">Update Hospital</button>
        </form>
    </div>
</div>

<?php include('footer-admin.php'); ?>
