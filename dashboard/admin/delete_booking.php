<?php
session_start(); // Start session

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    // Redirect to login page if not authenticated
    header("Location: login.php");
    exit();
}

include_once('../../database/connection.php');

$booking_id = $_GET['id'];

// Delete booking
$query = "DELETE FROM booking WHERE booking_id = '$booking_id'";
if (mysqli_query($con, $query)) {
    header('Location: show_bookings.php'); // Redirect to booking list
    exit();
} else {
    echo "Error deleting record: " . mysqli_error($con);
}
?>
