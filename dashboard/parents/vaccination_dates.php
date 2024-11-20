<?php
include_once('../../database/connection.php');
include('header-parent.php');
include('parent-sidebar.php');
?>

<div class="page-content">
    <div class="container mt-5">
        <h2>Parent Vaccination Report</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Parent Name</th>
                    <th>Child Name</th>
                    <th>Vaccine Name</th>
                    <th>Hospital Name</th>
                    <th>Vaccination Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT 
                            p.name AS parent_name,
                            c.name AS child_name,
                            v.vaccine_name,
                            h.name AS hospital_name,
                            b.booking_date AS vaccination_date
                          FROM booking b
                          JOIN parent p ON b.parent_id = p.parent_id
                          JOIN child c ON b.child_id = c.child_id
                          JOIN vaccine v ON b.vaccine_id = v.vaccine_id
                          JOIN hospital h ON b.hospital_id = h.hospital_id
                          WHERE b.status = 'Approved'"; // Only show approved bookings
                
                $result = mysqli_query($con, $query);
                $i = 1;

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td>{$i}</td>
                            <td>{$row['parent_name']}</td>
                            <td>{$row['child_name']}</td>
                            <td>{$row['vaccine_name']}</td>
                            <td>{$row['hospital_name']}</td>
                            <td>{$row['vaccination_date']}</td>
                          </tr>";
                    $i++;
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php include('parent-footer.php'); ?>
