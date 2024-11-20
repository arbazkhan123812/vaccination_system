
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




include('sidebar-admin.php');
?>



<div class="page-content">
    <div class="container mt-5">
        <h2>Hospital List</h2>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Hospital Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT * FROM hospital";
                $result = mysqli_query($con, $query);
                $i = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td>{$i}</td>
                            <td>{$row['name']}</td>
                            <td>{$row['email']}</td>
                            <td>{$row['phone']}</td>
                            <td>{$row['address']}</td>
                            <td>
                                <a href='edit_hospital.php?id={$row['hospital_id']}' class='btn btn-warning btn-sm'>Edit</a>
                                <a href='delete_hospital.php?id={$row['hospital_id']}' class='btn btn-danger btn-sm'>Delete</a>
                            </td>
                          </tr>";
                    $i++;
                }
                ?>
            </tbody>
        </table>
    </div>
</div>




</div>

<?php 
include('footer-admin.php');
?>