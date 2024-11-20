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
        <h2>Manage Requests</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Child Name</th>
                    <th>Vaccine Name</th>
                    <th>Parent Name</th>
                    <th>Hospital Name</th>
                    <th>Requested Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT 
                            r.request_id, r.requested_date, r.status,
                            c.name AS child_name,
                            v.vaccine_name,
                            p.name AS parent_name,
                            h.name AS hospital_name
                          FROM request r
                          JOIN child c ON r.child_id = c.child_id
                          JOIN vaccine v ON r.vaccine_id = v.vaccine_id
                          JOIN parent p ON r.parent_id = p.parent_id
                          JOIN hospital h ON r.hospital_id = h.hospital_id";
                $result = mysqli_query($con, $query);
                $i = 1;

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td>{$i}</td>
                            <td>{$row['child_name']}</td>
                            <td>{$row['vaccine_name']}</td>
                            <td>{$row['parent_name']}</td>
                            <td>{$row['hospital_name']}</td>
                            <td>{$row['requested_date']}</td>
                            <td>{$row['status']}</td>
                            <td>
                                <a href='approve_request.php?id={$row['request_id']}' class='btn btn-success btn-sm'>Approve</a>
                                <a href='reject_request.php?id={$row['request_id']}' class='btn btn-danger btn-sm'>Reject</a>
                            </td>
                          </tr>";
                    $i++;
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php include('footer-admin.php'); ?>
