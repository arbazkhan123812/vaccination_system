<?php
session_start(); // Start session

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    // Redirect to login page if not authenticated
    header("Location: login.php");
    exit();
}

include_once('../../database/connection.php');

$id = $_GET['id'];

$query = "UPDATE child_vaccination SET status = 'Completed' WHERE id = '$id'";
if (mysqli_query($con, $query)) {
    header('Location: show_assigned_vaccines.php');
    exit();
} else {
    echo "Error: " . mysqli_error($con);
}
?>
