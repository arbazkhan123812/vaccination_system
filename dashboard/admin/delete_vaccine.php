<?php
session_start(); // Start session

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    // Redirect to login page if not authenticated
    header("Location: login.php");
    exit();
}

// Start output buffering
ob_start();

include_once('../../database/connection.php');

// Get vaccine ID from the URL
$getid = $_GET['id'];

// Delete vaccine record
$query1 = "DELETE FROM `vaccine` WHERE `vaccine_id` = '$getid'";
$res1 = mysqli_query($con, $query1);

if ($res1) {
    // Redirect to the vaccine list page
    header('Location: show-vaccine.php');
    exit; // Make sure the script stops after the redirect
} else {
    echo "<script>alert('Failed to delete the vaccine. Please try again.');</script>";
}

// End output buffering and flush output
ob_end_flush();
?>
