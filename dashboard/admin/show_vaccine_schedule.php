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


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Vaccination Schedule</title>
    <!-- Add Bootstrap CSS -->
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Vaccination Schedule</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Child Name</th>
                    <th>Vaccine</th>
                    <th>Hospital</th>
                    <th>Scheduled Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $schedules = mysqli_query($con, 
                    "SELECT vs.*, c.name AS child_name, v.vaccine_name, h.name AS hospital_name 
                     FROM vaccination_schedule vs
                     JOIN child c ON vs.child_id = c.child_id
                     JOIN vaccine v ON vs.vaccine_id = v.vaccine_id
                     JOIN hospital h ON vs.hospital_id = h.hospital_id");

                $i = 1;
                while ($schedule = mysqli_fetch_assoc($schedules)) {
                    echo "<tr>
                            <td>{$i}</td>
                            <td>{$schedule['child_name']}</td>
                            <td>{$schedule['vaccine_name']}</td>
                            <td>{$schedule['hospital_name']}</td>
                            <td>{$schedule['scheduled_date']}</td>
                            <td>{$schedule['status']}</td>
                            <td>
                                <a href='update_schedule.php?id={$schedule['schedule_id']}' class='btn btn-warning btn-sm'>Update</a>
                                <a href='delete_schedule.php?id={$schedule['schedule_id']}' class='btn btn-danger btn-sm'>Delete</a>
                            </td>
                          </tr>";
                    $i++;
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

</div>

<?php 
include('footer-admin.php');
?>