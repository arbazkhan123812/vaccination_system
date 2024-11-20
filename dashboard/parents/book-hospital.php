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

// Fetch parent ID
$parent_id = $_SESSION['parent_id'];
$success = $error = "";

// Fetch available hospitals and children
$hospitals_query = "SELECT hospital_id, name FROM hospital WHERE email IS NOT NULL";
$hospitals_result = $con->query($hospitals_query);

$children_query = "SELECT child_id, name FROM child WHERE parent_id = '$parent_id'";
$children_result = $con->query($children_query);

// Handle form submission for booking
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $child_id = $_POST['child_id'];
    $hospital_id = $_POST['hospital_id'];
    $vaccine_id = $_POST['vaccine_id'];
    $booking_date = $_POST['booking_date'];

    // Validation
    if (empty($child_id) || empty($hospital_id) || empty($vaccine_id) || empty($booking_date)) {
        $error = "All fields are required!";
    } else {
        $booking_query = "
            INSERT INTO booking (parent_id, child_id, hospital_id, vaccine_id, booking_date, status, created_at) 
            VALUES ('$parent_id', '$child_id', '$hospital_id', '$vaccine_id', '$booking_date', 'Pending', NOW())
        ";
        if ($con->query($booking_query)) {
            $success = "Booking request submitted successfully!";
        } else {
            $error = "Error: " . $con->error;
        }
    }
}

// Fetch available vaccines
$vaccines_query = "SELECT vaccine_id, vaccine_name FROM vaccine WHERE availability_status = 'Available'";
$vaccines_result = $con->query($vaccines_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Hospital</title>
    <link rel="stylesheet" href="path/to/bootstrap.css">
    <link rel="stylesheet" href="path/to/custom.css">
</head>
<body>
<?php include('header-parent.php'); include('parent-sidebar.php'); ?>
<div class="page-content">
    <div class="container">
        <h1 class="mt-4">Book Hospital</h1>
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="child_id">Select Child</label>
                <select id="child_id" name="child_id" class="form-control" required>
                    <option value="">-- Select Child --</option>
                    <?php while ($row = $children_result->fetch_assoc()): ?>
                        <option value="<?php echo $row['child_id']; ?>">
                            <?php echo htmlspecialchars($row['name']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="hospital_id">Select Hospital</label>
                <select id="hospital_id" name="hospital_id" class="form-control" required>
                    <option value="">-- Select Hospital --</option>
                    <?php while ($row = $hospitals_result->fetch_assoc()): ?>
                        <option value="<?php echo $row['hospital_id']; ?>">
                            <?php echo htmlspecialchars($row['name']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="vaccine_id">Select Vaccine</label>
                <select id="vaccine_id" name="vaccine_id" class="form-control" required>
                    <option value="">-- Select Vaccine --</option>
                    <?php while ($row = $vaccines_result->fetch_assoc()): ?>
                        <option value="<?php echo $row['vaccine_id']; ?>">
                            <?php echo htmlspecialchars($row['vaccine_name']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="booking_date">Select Booking Date</label>
                <input type="date" id="booking_date" name="booking_date" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Book Hospital</button>
        </form>
    </div>
</div>
<?php include('parent-footer.php'); ?>
</body>
</html>
