<?php
// Include database connection
include_once('../../database/connection.php');

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect to login if the parent is not logged in
if (!isset($_SESSION['parent_id']) || !isset($_SESSION['parent_name'])) {
    header("Location: login-parents.php");
    exit();
}

// Get the parent ID from the session
$parent_id = $_SESSION['parent_id'];

// Fetch the list of children for this parent
$query = "SELECT * FROM child WHERE parent_id = '$parent_id' ORDER BY created_at DESC";
$result = $con->query($query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Children</title>
    <!-- Include your stylesheets here -->
    <link rel="stylesheet" href="path/to/bootstrap.css">
    <link rel="stylesheet" href="path/to/custom.css">
</head>
<body>
<?php
// Include the header and sidebar
include('header-parent.php');
include('parent-sidebar.php');
?>
<div class="page-content">
    <div class="container">
        <h1 class="mt-4">Your Children</h1>

        <!-- Check if there are any children -->
        <?php if ($result->num_rows > 0): ?>
            <table class="table table-striped mt-4">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Date of Birth</th>
                        <th>Gender</th>
                        <th>Added On</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $counter = 1; // For numbering
                    while ($child = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $counter++; ?></td>
                            <td><?php echo htmlspecialchars($child['name']); ?></td>
                            <td><?php echo htmlspecialchars($child['date_of_birth']); ?></td>
                            <td><?php echo htmlspecialchars($child['gender']); ?></td>
                            <td><?php echo htmlspecialchars($child['created_at']); ?></td>
                            <td>
                                <a href="edit-child.php?id=<?php echo $child['child_id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="delete-child.php?id=<?php echo $child['child_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this child?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-info mt-4">You have not added any children yet.</div>
        <?php endif; ?>
    </div>
</div>

<?php
// Include the footer
include('parent-footer.php');
?>
</body>
</html>
