<?php
include '../../database/connection.php';
session_start();

$error = ""; // To store error messages

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error = "Email and Password are required!";
    } else {
        // Query to fetch the parent details
        $query = "SELECT * FROM parent WHERE email = '$email' AND password = '$password'";
        $result = $con->query($query);

        if ($result->num_rows > 0) {
            $parent = $result->fetch_assoc();
            // Set session variables
            $_SESSION['parent_name'] = $parent['name'];
            $_SESSION['parent_id'] = $parent['parent_id'];

            // Redirect to the parent dashboard
            header("Location: index.php");
            exit();
        } else {
            $error = "Invalid email or password!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parent Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(to right, #1b6ea6, #2575fc);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Arial', sans-serif;
        }
        .login-card {
            background: #fff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }
        .login-card h2 {
            font-size: 24px;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }
        .btn-primary {
            background: #6a11cb;
            border: none;
            transition: background 0.3s ease;
        }
        .btn-info {
            border: none;
            transition: background 0.3s ease;
        }
        .btn-primary:hover {
            background: #2575fc;
        }
        .alert {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <h2>Parent Login</h2>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
            <a href="registeration-parents.php" class="btn btn-info mt-3">Register Here</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
