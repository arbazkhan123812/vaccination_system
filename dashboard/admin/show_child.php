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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Child Information</title>
    <!-- Add Bootstrap CSS -->
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Child Information</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Child Name</th>
                    <th>Parent Name</th>
                    <th>Date of Birth</th>
                    <th>Gender</th>
                    <th>Parent Contact</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT 
                            c.child_id, c.name AS child_name, c.date_of_birth, c.gender, 
                            p.name AS parent_name, p.phone, p.address 
                          FROM child c
                          JOIN parent p ON c.parent_id = p.parent_id";
                $result = mysqli_query($con, $query);
                $i = 1;

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td>{$i}</td>
                            <td>{$row['child_name']}</td>
                            <td>{$row['parent_name']}</td>
                            <td>{$row['date_of_birth']}</td>
                            <td>{$row['gender']}</td>
                            <td>{$row['phone']}</td>
                            <td>{$row['address']}</td>
                            <td>
                                <a href='edit_child.php?id={$row['child_id']}' class='btn btn-warning btn-sm'>Edit</a>
                                <a href='delete_child.php?id={$row['child_id']}' class='btn btn-danger btn-sm' 
                                    onclick=\"return confirm('Are you sure you want to delete this child?');\">Delete</a>
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
