<?php
session_start(); // Start session

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    // Redirect to login page if not authenticated
    header("Location: login.php");
    exit();
}

include_once('../../database/connection.php');

// Get child ID from the URL
$child_id = $_GET['id'];

// Delete query
$query = "DELETE FROM child WHERE child_id = '$child_id'";
if (mysqli_query($con, $query)) {
    header('Location: show_child.php'); // Redirect to child list
    exit();
} else {
    echo "Error deleting record: " . mysqli_error($con);
}
?>
