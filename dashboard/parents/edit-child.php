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

// Get the parent ID and child ID
$parent_id = $_SESSION['parent_id'];
$child_id = $_GET['id'] ?? null;

// Fetch child details
if ($child_id) {
    $query = "SELECT * FROM child WHERE child_id = '$child_id' AND parent_id = '$parent_id'";
    $result = $con->query($query);
    $child = $result->fetch_assoc();
    if (!$child) {
        echo "Child not found!";
        exit();
    }
} else {
    echo "Invalid child ID!";
    exit();
}

$error = $success = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];

    if (empty($name) || empty($dob) || empty($gender)) {
        $error = "All fields are required!";
    } else {
        $update_query = "UPDATE child SET name='$name', date_of_birth='$dob', gender='$gender' WHERE child_id='$child_id' AND parent_id='$parent_id'";
        if ($con->query($update_query)) {
            $success = "Child details updated successfully!";
        } else {
            $error = "Error: " . $con->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Child</title>
    <link rel="stylesheet" href="path/to/bootstrap.css">
    <link rel="stylesheet" href="path/to/custom.css">
</head>
<body>
<?php
include('header-parent.php');
include('parent-sidebar.php');
?>
<div class="page-content">
    <div class="container">
        <h1 class="mt-4">Edit Child</h1>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="name">Child Name</label>
                <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($child['name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="dob">Date of Birth</label>
                <input type="date" id="dob" name="dob" class="form-control" value="<?php echo htmlspecialchars($child['date_of_birth']); ?>" required>
            </div>
            <div class="form-group">
                <label for="gender">Gender</label>
                <select id="gender" name="gender" class="form-control" required>
                    <option value="Male" <?php echo $child['gender'] === 'Male' ? 'selected' : ''; ?>>Male</option>
                    <option value="Female" <?php echo $child['gender'] === 'Female' ? 'selected' : ''; ?>>Female</option>
                    <option value="Other" <?php echo $child['gender'] === 'Other' ? 'selected' : ''; ?>>Other</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
<?php include('parent-footer.php'); ?>
</body>
</html>
