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

// Get parent ID from session
$parent_id = $_SESSION['parent_id'];

// Fetch bookings for the logged-in parent
$bookings_query = "
    SELECT 
        b.booking_id,
        c.name AS child_name,
        h.name AS hospital_name,
        v.vaccine_name,
        b.booking_date,
        b.status,
        b.created_at
    FROM 
        booking b
    JOIN 
        child c ON b.child_id = c.child_id
    JOIN 
        hospital h ON b.hospital_id = h.hospital_id
    JOIN 
        vaccine v ON b.vaccine_id = v.vaccine_id
    WHERE 
        b.parent_id = '$parent_id'
    ORDER BY 
        b.created_at DESC
";
$bookings_result = $con->query($bookings_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Bookings</title>
    <link rel="stylesheet" href="path/to/bootstrap.css">
    <link rel="stylesheet" href="path/to/custom.css">
</head>
<body>
<?php include('header-parent.php'); include('parent-sidebar.php'); ?>
<div class="page-content">
    <div class="container">
        <h1 class="mt-4">Your Bookings</h1>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Child Name</th>
                        <th>Hospital Name</th>
                        <th>Vaccine Name</th>
                        <th>Booking Date</th>
                        <th>Status</th>
                        <th>Created On</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($bookings_result->num_rows > 0): ?>
                        <?php $count = 1; ?>
                        <?php while ($row = $bookings_result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $count++; ?></td>
                                <td><?php echo htmlspecialchars($row['child_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['hospital_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['vaccine_name']); ?></td>
                                <td><?php echo date('d M Y', strtotime($row['booking_date'])); ?></td>
                                <td>
                                    <?php if ($row['status'] === 'Pending'): ?>
                                        <span class="badge badge-warning"><?php echo $row['status']; ?></span>
                                    <?php elseif ($row['status'] === 'Approved'): ?>
                                        <span class="badge badge-success"><?php echo $row['status']; ?></span>
                                    <?php else: ?>
                                        <span class="badge badge-danger"><?php echo $row['status']; ?></span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo date('d M Y, h:i A', strtotime($row['created_at'])); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">No bookings found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include('parent-footer.php'); ?>
</body>
</html>
