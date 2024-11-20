<?php
// Include database connection
include_once('../../database/connection.php');

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect to login if the parent is not logged in
if (!isset($_SESSION['parent_id'])) {
    header("Location: login-parents.php");
    exit();
}

// Get the parent ID and child ID
$parent_id = $_SESSION['parent_id'];
$child_id = $_GET['id'] ?? null;

// Validate the child ID
if ($child_id) {
    $query = "DELETE FROM child WHERE child_id = '$child_id' AND parent_id = '$parent_id'";
    if ($con->query($query)) {
        header("Location: view-child.php?success=Child deleted successfully!");
        exit();
    } else {
        header("Location: view-child.php?error=Error deleting child: " . $con->error);
        exit();
    }
} else {
    header("Location: view-child.php?error=Invalid child ID!");
    exit();
}
?>
