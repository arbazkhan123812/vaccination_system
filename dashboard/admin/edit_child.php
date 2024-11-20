<?php
session_start(); // Start session

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    // Redirect to login page if not authenticated
    header("Location: login.php");
    exit();
}

ob_start(); // Start output buffering
include_once('../../database/connection.php');
include('header-admin.php');
include('sidebar-admin.php');

// Get child ID from the URL
$child_id = $_GET['id'];

// Fetch child details for editing
$query = "SELECT * FROM child WHERE child_id = '$child_id'";
$result = mysqli_query($con, $query);
$child = mysqli_fetch_assoc($result);

// Handle form submission for updating
if (isset($_POST['update_child'])) {
    $name = $_POST['name'];
    $dob = $_POST['date_of_birth'];
    $gender = $_POST['gender'];
    $parent_id = $_POST['parent_id'];

    $update_query = "UPDATE child 
                     SET name = '$name', date_of_birth = '$dob', gender = '$gender', parent_id = '$parent_id'
                     WHERE child_id = '$child_id'";
    if (mysqli_query($con, $update_query)) {
        header('Location: show_child.php'); // Redirect to child list
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($con);
    }
}
?>

<div class="page-content">
    <div class="container mt-5">
        <h2>Edit Child</h2>
        <form method="POST">
            <div class="form-group">
                <label for="name">Child Name:</label>
                <input type="text" id="name" name="name" class="form-control" value="<?php echo $child['name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="date_of_birth">Date of Birth:</label>
                <input type="date" id="date_of_birth" name="date_of_birth" class="form-control" value="<?php echo $child['date_of_birth']; ?>" required>
            </div>
            <div class="form-group">
                <label for="gender">Gender:</label>
                <select id="gender" name="gender" class="form-control">
                    <option value="Male" <?php echo ($child['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                    <option value="Female" <?php echo ($child['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                </select>
            </div>
            <div class="form-group">
                <label for="parent_id">Parent ID:</label>
                <input type="text" id="parent_id" name="parent_id" class="form-control" value="<?php echo $child['parent_id']; ?>" required>
            </div>
            <button type="submit" name="update_child" class="btn btn-primary">Update Child</button>
        </form>
    </div>
</div>

<?php include('footer-admin.php'); ?>
