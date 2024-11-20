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

// Fetch vaccines from the database
$query = "SELECT * FROM vaccine";
$result = mysqli_query($con, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($con));
}
?>



<div class="page-content">
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Vaccines</title>
    <!-- Bootstrap CSS -->
</head>
<body>
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h3 class="text-center">Available Vaccines</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>Vaccine ID</th>
                            <th>Vaccine Name</th>
                            <th>Description</th>
                            <th>Age Group</th>
                            <th>Availability Status</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($result) > 0): ?>
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td><?php echo $row['vaccine_id']; ?></td>
                                    <td><?php echo $row['vaccine_name']; ?></td>
                                    <td><?php echo $row['description']; ?></td>
                                    <td><?php echo $row['age_group']; ?></td>
                                    <td><?php echo $row['availability_status']; ?></td>
                                    <td><a href="edit_vaccine.php?id=<?php echo $row['vaccine_id']?>">Edit</a></td>
                                    <td><a href="delete_vaccine.php?id=<?php echo $row['vaccine_id']?>">delete</a></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">No vaccines found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.7/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.min.js"></script>
</body>
</html>

    </div>
<?php
// Fetch vaccines from the database
$query = "SELECT * FROM vaccine";
$result = mysqli_query($con, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($con));
}
?>


<?php
// Close the database connection
mysqli_close($con);
?>


    <?php 
    include('footer-admin.php');
    ?>