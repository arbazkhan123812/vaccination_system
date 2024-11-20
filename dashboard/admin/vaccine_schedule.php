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




include('sidebar-admin.php');?>

<div class="page-content">


<body>
    <div class="container mt-5">
        <h2 class="text-center">Add Vaccination Schedule</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label for="child">Select Child:</label>
                <select class="form-control" id="child" name="child_id" required>
                    <?php
                    $children = mysqli_query($con, "SELECT * FROM child");
                    while ($child = mysqli_fetch_assoc($children)) {
                        echo "<option value='{$child['child_id']}'>{$child['name']} (DOB: {$child['date_of_birth']})</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="vaccine">Select Vaccine:</label>
                <select class="form-control" id="vaccine" name="vaccine_id" required>
                    <?php
                    $vaccines = mysqli_query($con, "SELECT * FROM vaccine WHERE availability_status='Available'");
                    while ($vaccine = mysqli_fetch_assoc($vaccines)) {
                        echo "<option value='{$vaccine['vaccine_id']}'>{$vaccine['vaccine_name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="hospital">Select Hospital:</label>
                <select class="form-control" id="hospital" name="hospital_id" required>
                    <?php
                    $hospitals = mysqli_query($con, "SELECT * FROM hospital");
                    while ($hospital = mysqli_fetch_assoc($hospitals)) {
                        echo "<option value='{$hospital['hospital_id']}'>{$hospital['name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="date">Scheduled Date:</label>
                <input type="date" class="form-control" id="date" name="scheduled_date" required>
            </div>
            <button type="submit" name="add_schedule" class="btn btn-primary btn-block">Add Schedule</button>
        </form>
    </div>

    <?php
    if (isset($_POST['add_schedule'])) {
        $child_id = $_POST['child_id'];
        $vaccine_id = $_POST['vaccine_id'];
        $hospital_id = $_POST['hospital_id'];
        $scheduled_date = $_POST['scheduled_date'];

        $query = "INSERT INTO vaccination_schedule (child_id, vaccine_id, hospital_id, scheduled_date, status) 
                  VALUES ('$child_id', '$vaccine_id', '$hospital_id', '$scheduled_date', 'Scheduled')";

        if (mysqli_query($con, $query)) {
            echo "<div class='alert alert-success text-center'>Vaccination Schedule Added Successfully!</div>";
        } else {
            echo "<div class='alert alert-danger text-center'>Error: " . mysqli_error($con) . "</div>";
        }
    }
    ?>
</body>
</html>

</div>
<?php
include('footer-admin.php');
?>