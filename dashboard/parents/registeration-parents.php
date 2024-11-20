<?php include_once('../../database/connection.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parent Registration</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(#c3e4fa);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Arial', sans-serif;
        }
        .register-card {
            height: 600px;
            background: #fff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 500px;
        }
        .register-card h2 {
            font-size: 28px;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }
        .btn-primary {
            background: #ff7e5f;
            border: none;
            transition: background 0.3s ease;
        }
        .btn-primary:hover {
            background: #feb47b;
        }
        .form-label {
            font-weight: bold;
        }
        .link-login {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #ff7e5f;
        }
        .link-login:hover {
            color: #feb47b;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="register-card">
        <h2>Parent Registration</h2>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone:</label>
                <input type="number" name="phone" id="phone" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address:</label>
                <input type="text" name="address" id="address" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Register</button>
        </form>
        <a href="login-parents.php" class="link-login">Already have an account? Login</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $password = $_POST['password'];

    // Hash the password

    // Insert into the appropriate table
        $query = "INSERT INTO `parent`( `name`, `email`, `password`, `created_at`, `phone`, `address`) VALUES ('$name','$email','$password',NOW(),'$phone','$address')";
        $res = mysqli_query($con,$query);

    if ($res) {
        echo "Registration successful!";
        header('location:login-parents.php');
    } else {
        echo "Error: " . mysqli_error($con);
    }

    mysqli_close($con);
}
?>

