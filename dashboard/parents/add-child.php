<?php
include '../../database/connection.php';
session_start();

// Check if the parent is logged in
if (!isset($_SESSION['parent_name'])) {
    header("Location: login-parents.php"); // Redirect to login if not authenticated
    exit();
}

// Fetch parent details from the session
$parent_name = $_SESSION['parent_name'];
$parent_id = $_SESSION['parent_id']; // Ensure parent_id is set during login
$error = $success = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];

    // Validate the input
    if (empty($name) || empty($dob) || empty($gender)) {
        $error = "All fields are required!";
    } else {
        // Insert child details into the database
        $query = "INSERT INTO child (parent_id, name, date_of_birth, gender) VALUES ('$parent_id', '$name', '$dob', '$gender')";
        if ($con->query($query)) {
            $success = "Child added successfully!";
        } else {
            $error = "Error: " . $con->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include('header-parent.php'); ?>
<body>
    <?php include('parent-sidebar.php'); ?>
    <div class="page-content">
        <h2>Add Child</h2>
        <p>Welcome, <strong><?php echo htmlspecialchars($parent_name); ?></strong></p>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="name">Child Name</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Enter child's name" required>
            </div>
            <div class="form-group">
                <label for="dob">Date of Birth</label>
                <input type="date" id="dob" name="dob" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="gender">Gender</label>
                <select id="gender" name="gender" class="form-control" required>
                    <option value="">Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Add Child</button>
        </form>
    </div>
</body>
</html>
