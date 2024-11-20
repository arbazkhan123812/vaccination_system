<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parent Dashboard</title>
    <!-- Include your stylesheets here -->
    <link rel="stylesheet" href="path/to/bootstrap.css">
    <link rel="stylesheet" href="path/to/custom.css">
</head>
<body>
<?php
// Include database connection
include_once('../../database/connection.php');

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect to login if the session is not set
if (!isset($_SESSION['parent_id']) || !isset($_SESSION['parent_name'])) {
    header("Location: login-parents.php");
    exit();
}

// Fetch parent name from session
$parent_name = $_SESSION['parent_name'];

// Include header and sidebar components
include('header-parent.php');
include('parent-sidebar.php');
?>
<div class="page-content">
    <div class="container">
        <h1>Welcome, <?php echo htmlspecialchars($parent_name); ?>!</h1>
        <p>This is your dashboard. Use the sidebar to navigate through your options.</p>
    </div>
</div>

<?php
// Include footer component
include('parent-footer.php');
?>
</body>
</html>
