<?php 

session_start(); // Start session

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    // Redirect to login page if not authenticated
    header("Location: login.php");
    exit();
}

include('header-admin.php');




include('sidebar-admin.php');

include('body-admin.php');

include('footer-admin.php');
?>