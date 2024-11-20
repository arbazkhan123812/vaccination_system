<?php
session_start(); // Start session

// Destroy session data
session_unset();
session_destroy();

// Redirect to login page
header("Location: login-hospital.php");
exit();
?>