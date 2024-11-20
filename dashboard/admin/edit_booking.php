<?php
session_start(); // Start session

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    // Redirect to login page if not authenticated
    header("Location: login.php");
    exit();
}
ob_start();
include_once('../../database/connection.php');
include('header-admin.php');
include('sidebar-admin.php');

// Get booking ID from the URL
$booking_id = $_GET['id'];

// Fetch booking details
$query = "SELECT * FROM booking WHERE booking_id = '$booking_id'";
$result = mysqli_query($con, $query);
$booking = mysqli_fetch_assoc($result);

// Handle form submission for updating status
if (isset($_POST['update_status'])) {
    $status = $_POST['status'];

    $update_query = "UPDATE booking SET status = '$status' WHERE booking_id = '$booking_id'";
    if (mysqli_query($con, $update_query)) {
        header('Location: show_bookings.php'); // Redirect back to booking list
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($con);
    }
}
?>

<div class="page-content">
    <div class="container mt-5">
        <h2>Edit Booking</h2>
        <form method="POST">
            <div class="form-group">
                <label for="status">Booking Status:</label>
                <select id="status" name="status" class="form-control">
                    <option value="Pending" <?php echo ($booking['status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                    <option value="Approved" <?php echo ($booking['status'] == 'Approved') ? 'selected' : ''; ?>>Approved</option>
                    <option value="Rejected" <?php echo ($booking['status'] == 'Rejected') ? 'selected' : ''; ?>>Rejected</option>
                </select>
            </div>
            <button type="submit" name="update_status" class="btn btn-primary">Update Status</button>
        </form>
    </div>
</div>

<?php include('footer-admin.php'); ?>
