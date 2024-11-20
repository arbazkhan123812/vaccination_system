<?php
session_start(); // Start session

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    // Redirect to login page if not authenticated
    header("Location: login.php");
    exit();
}

include_once('../../database/connection.php');

// Get hospital ID from the URL
$hospital_id = $_GET['id'];

// Delete hospital record
$query = "DELETE FROM hospital WHERE hospital_id = '$hospital_id'";
if (mysqli_query($con, $query)) {
    header('Location: show_hospital.php'); // Redirect to hospital list
    exit();
} else {
    echo "Error deleting record: " . mysqli_error($con);
}
?>
