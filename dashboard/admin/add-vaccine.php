<?php
session_start(); // Start session

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    // Redirect to login page if not authenticated
    header("Location: login.php");
    exit();
}

include_once('../../database/connection.php'); // Adjust the path as needed
?>

<?php 
include('header-admin.php');




include('sidebar-admin.php');
?>
<div class="page-content">

<body>
    <div class="container mt-5">
        <h2>Add New Vaccine</h2>
        <form action="add-vaccine.php" method="POST">
            <div class="form-group">
                <label for="vaccine_name">Vaccine Name:</label>
                <input type="text" class="form-control" id="vaccine_name" name="vaccine_name" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label for="age_group">Age Group:</label>
                <input type="text" class="form-control" id="age_group" name="age_group">
            </div>
            <div class="form-group">
                <label for="availability_status">Availability Status:</label>
                <select class="form-control" id="availability_status" name="availability_status">
                    <option value="Available">Available</option>
                    <option value="Unavailable">Unavailable</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Add Vaccine</button>
        </form>
        <br>
        <a href="show-vaccine.php" class="btn btn-secondary">View Vaccines</a>
    </div>

    <!-- Include Bootstrap JS and dependencies (optional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>
</div>


<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form inputs
    $vaccine_name = mysqli_real_escape_string($con, $_POST['vaccine_name']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $age_group = mysqli_real_escape_string($con, $_POST['age_group']);
    $availability_status = mysqli_real_escape_string($con, $_POST['availability_status']);

    // SQL query to insert the new vaccine
    $query = "INSERT INTO vaccine (vaccine_name, description, age_group, availability_status) 
              VALUES ('$vaccine_name', '$description', '$age_group', '$availability_status')";

    if (mysqli_query($con, $query)) {
        echo "<script>alert('vaccine added successfully')</script>";
    } else {
        echo "<script>alert('vaccine added successfully')</script>";
    }

    // Close the database connection
    mysqli_close($con);
}

include('footer-admin.php')
?>

