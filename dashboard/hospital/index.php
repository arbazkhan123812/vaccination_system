<?php
include_once('../../database/connection.php');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect if the session is not set
if (!isset($_SESSION['id'])) {
    header("Location: login-hospital.php");
    exit();
}
?>
<?php
if (!isset($_SESSION['id'])) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Hospital Login</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="bg-light d-flex align-items-center" style="height: 100vh;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-header text-center">
                            <h4>Hospital Login</h4>
                        </div>
                        <div class="card-body">
                            <?php if (isset($error)) { echo "<div class='alert alert-danger'>$error</div>"; } ?>
                            <form method="POST" action="">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control" required>
                                </div>
                                <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    </html>
    <?php
    exit();
}

// Handle Vaccine Updates
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_vaccine'])) {
    $vaccine_id = $_POST['vaccine_id'];
    $status = $_POST['status'];
    $query = "UPDATE vaccine SET availability_status = '$status' WHERE vaccine_id = $vaccine_id";
    mysqli_query($con, $query);
    $vaccine_message = "Vaccine status updated successfully.";
}

// Fetch Vaccines
$vaccine_query = "SELECT * FROM vaccine";
$vaccine_result = mysqli_query($con, $vaccine_query);

// Fetch Bookings
$booking_query = "SELECT 
                    b.booking_id, b.booking_date, b.status, 
                    c.name AS child_name, 
                    v.vaccine_name, 
                    p.name AS parent_name 
                  FROM booking b
                  JOIN child c ON b.child_id = c.child_id
                  JOIN vaccine v ON b.vaccine_id = v.vaccine_id
                  JOIN parent p ON b.parent_id = p.parent_id
                  WHERE b.hospital_id = " . $_SESSION['id'];
$booking_result = mysqli_query($con, $booking_query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Hospital Dashboard</a>
            <div class="d-flex">
                <span class="navbar-text me-3">Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>!</span>
                <a href="logout-hospital.php" class="btn btn-outline-light btn-sm">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>Manage Vaccine Status</h2>
        <?php if (isset($vaccine_message)) { echo "<div class='alert alert-success'>$vaccine_message</div>"; } ?>
        <table class="table table-bordered table-hover">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>Vaccine Name</th>
                    <th>Age Group</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($vaccine = mysqli_fetch_assoc($vaccine_result)) { ?>
                <tr>
                    <td><?php echo $vaccine['vaccine_id']; ?></td>
                    <td><?php echo $vaccine['vaccine_name']; ?></td>
                    <td><?php echo $vaccine['age_group']; ?></td>
                    <td><?php echo $vaccine['availability_status']; ?></td>
                    <td>
                        <form method="POST" action="">
                            <input type="hidden" name="vaccine_id" value="<?php echo $vaccine['vaccine_id']; ?>">
                            <select name="status" class="form-select form-select-sm">
                                <option value="Available" <?php if ($vaccine['availability_status'] == 'Available') echo 'selected'; ?>>Available</option>
                                <option value="Unavailable" <?php if ($vaccine['availability_status'] == 'Unavailable') echo 'selected'; ?>>Unavailable</option>
                            </select>
                            <button type="submit" name="update_vaccine" class="btn btn-sm btn-success mt-1">Update</button>
                        </form>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <h2 class="mt-5">Manage Bookings</h2>
        <table class="table table-bordered table-hover">
            <thead class="table-success">
                <tr>
                    <th>#</th>
                    <th>Child Name</th>
                    <th>Vaccine Name</th>
                    <th>Parent Name</th>
                    <th>Booking Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($booking = mysqli_fetch_assoc($booking_result)) { ?>
                <tr>
                    <td><?php echo $booking['booking_id']; ?></td>
                    <td><?php echo $booking['child_name']; ?></td>
                    <td><?php echo $booking['vaccine_name']; ?></td>
                    <td><?php echo $booking['parent_name']; ?></td>
                    <td><?php echo $booking['booking_date']; ?></td>
                    <td><?php echo $booking['status']; ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>