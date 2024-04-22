<?php
session_start();
include("database.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $fullname = $_POST["fullname"];
    $password = $_POST["password"];

    // Check if the user is an admin
    $sql = "SELECT * FROM admin WHERE fullname='$fullname'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            $_SESSION['admin_id'] = $row['admin_id'];
            $_SESSION['fullname'] = $fullname; // Set username in session
            $_SESSION['userType'] = 'admin'; // Set user type as 'admin'

            // Redirect to admin dashboard
            header("Location: admin.php");
            exit();
        }
    }

    // Check if the user is a regular user
    $sql = "SELECT * FROM user WHERE fullname='$fullname'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['fullname'] = $fullname; // Set username in session
            $_SESSION['userType'] = 'user'; // Set user type as 'user'

            // Redirect to user dashboard
            header("Location: user.php");
            exit();
        }
    }

    // If login fails, redirect back to login page
    header("Location: login.php");
    exit();
}

mysqli_close($conn);
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Online University Application</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body {
            background-image: url('study-group-african-people.jpg');
            background-size: cover;
            background-position: center;
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
        }

        .login-container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        .login-container img {
            width: 150px;
            margin-bottom: 20px;
        }

        .form-control {
            margin-bottom: 20px;
        }

        .btn-login {
            background-color: #007bff;
            border-color: #007bff;
            color: #fff;
        }

        .btn-login:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2 class="mb-4">Login to your account</h2>
        <form action="login.php" method="POST">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="full name" name="fullname" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="Password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block btn-login">Login</button>
        </form>
        <p class="mt-3">Don't have an account? <a href="register.php" class="btn btn-primary btn-register">Register</a></p>
    </div>
</body>
</html>
