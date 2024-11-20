<?php
session_start(); // Start session

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    // Redirect to login page if not authenticated
    header("Location: login.php");
    exit();
}

include_once('../../database/connection.php');

$request_id = $_GET['id'];
$query = "UPDATE request SET status = 'Approved' WHERE request_id = $request_id";

if (mysqli_query($con, $query)) {
    echo "Request approved successfully!";
} else {
    echo "Error: " . mysqli_error($con);
}
?>
