<?php
include_once('../../database/connection.php');
include('header-parent.php');
include('parent-sidebar.php');
?>

<div class="page-content">
    <div class="container mt-5">
        <h2 class="text-center">Vaccination Report</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Child Name</th>
                    <th>Parent Name</th>
                    <th>Vaccine Name</th>
                    <th>Hospital Name</th>
                    <th>Vaccination Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT 
                            c.name AS child_name,
                            p.name AS parent_name,
                            v.vaccine_name,
                            h.name AS hospital_name,
                            b.booking_date AS vaccination_date,
                            b.status
                          FROM booking b
                          JOIN child c ON b.child_id = c.child_id
                          JOIN parent p ON b.parent_id = p.parent_id
                          JOIN vaccine v ON b.vaccine_id = v.vaccine_id
                          JOIN hospital h ON b.hospital_id = h.hospital_id
                          ORDER BY b.booking_date DESC";
                          
                $result = mysqli_query($con, $query);
                $i = 1;

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td>{$i}</td>
                            <td>{$row['child_name']}</td>
                            <td>{$row['parent_name']}</td>
                            <td>{$row['vaccine_name']}</td>
                            <td>{$row['hospital_name']}</td>
                            <td>{$row['vaccination_date']}</td>
                            <td>{$row['status']}</td>
                          </tr>";
                    $i++;
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php include('parent-footer.php'); ?>
