<?php 
session_start(); // Start session

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    // Redirect to login page if not authenticated
    header("Location: login.php");
    exit();
}

include_once('../../database/connection.php');
include('header-admin.php');

$getid = $_GET['id'];

$query = "SELECT * FROM `vaccine` WHERE vaccine_id = '$getid'";

$res = mysqli_query($con,$query);

$row = mysqli_fetch_assoc($res);




include('sidebar-admin.php');
?>
<div class="page-content">



<body>
    <div class="container mt-5">
        <h2>Add New Vaccine</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label for="vaccine_name">Vaccine Name:</label>
                <input type="text" class="form-control" value="<?php echo $row['vaccine_name']?>" id="vaccine_name" name="vaccine_name" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description" rows="3"><?php echo $row['description']?></textarea>
            </div>
            <div class="form-group">
                <label for="age_group">Age Group:</label>
                <input type="text" class="form-control" value="<?php echo $row['age_group']?>" id="age_group" name="age_group">
            </div>
            <div class="form-group">
                <label for="availability_status">Availability Status:</label>
                <select class="form-control" id="availability_status" name="availability_status">
                    <option value="Available">Available</option>
                    <option value="Unavailable">Unavailable</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" name="edit_vaccine">Edit Vaccine</button>
        </form>
        <br>
        <a href="show-vaccine.php" class="btn btn-secondary">View Vaccines</a>
    </div>

</body>
</div>

<?php 
if(isset($_POST['edit_vaccine'])){
    $na = $_POST['vaccine_name'];
    $des = $_POST['description'];
    $ag = $_POST['age_group'];
    $av = $_POST['availability_status'];

    $query1 = "UPDATE `vaccine` SET `vaccine_name`='$na',`description`='$des',`age_group`='$ag',`availability_status`='$av' WHERE `vaccine_id` = '$getid'";
    $res1 = mysqli_query($con , $query1);
   
}
?>

<?php include('footer-admin.php'); ?>
    <!-- Include Bootstrap JS and dependencies (optional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
