<?php
include("database.php");

function sanitizeInput($conn, $data)
{
    $data = trim($data);
    $data = htmlspecialchars($data);
    $data = mysqli_real_escape_string($conn, $data);
    return $data;
}

function validatePhoneNumber($phone) {
    // Check if the phone number starts with zero and has ten digits
    if (preg_match('/^0[0-9]{9}$/', $phone)) {
        return true;
    } else {
        return false;
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $fullname = sanitizeInput($conn, $_POST["fullname"]);
    $email = sanitizeInput($conn, $_POST["email"]);
    $password = sanitizeInput($conn, $_POST["password"]);
    $userType = $_POST["userType"];
    $phone = ($userType === "admin") ? "" : sanitizeInput($conn, $_POST['phone']);

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Validate phone number for regular users
    if ($userType !== "admin" && !validatePhoneNumber($phone)) {
        echo "Error: Phone number must start with zero and have ten digits!";
        exit;
    }

    // Insert data into the appropriate table based on user type
    if ($userType === "admin") {
        $sql = "INSERT INTO admin (fullname, email, password) VALUES ('$fullname', '$email', '$hashed_password')";
    } else {
        $sql = "INSERT INTO user (fullname, email, password, phone) VALUES ('$fullname', '$email', '$hashed_password', '$phone')";
    }

    if (mysqli_query($conn, $sql)) {
        // Redirect to login page
        header("Location: login.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>


<!DOCTYPE html>
<html>
<head>
    <!-- Your HTML head content here -->
</head>
<body>
    <!-- Your HTML body content here -->
</body>
</html>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body {
            background-image: url('1.jpg');
            background-size: cover;
            background-position: center;
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        .card-header {
            background-color: #007bff;
            color: #fff;
            border-radius: 10px 10px 0 0;
            padding: 15px 0;
            text-align: center;
        }

        .card-body {
            padding: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .btn-login {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3>Account Creation</h3>
                </div>
                <div class="card-body">
                    <form action="register.php" method="POST">
                        <div class="form-group">
                            <label for="username">Full name</label>
                            <input type="text" class="form-control" name="fullname" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="tel" name="phone" id="phone" required>
                        </div>
                        <div class="form-group">
                            <label for="userType">User Type</label>
                            <select class="form-control" id="userType" name="userType">
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Create Account</button>
                    </form>
                    <p class="text-center mt-3">Already have an account? <a href="login.php">Login</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("userType").addEventListener("change", function() {
        var userType = this.value;
        var phoneInput = document.getElementById("phone");
        if (userType === "admin") {
            phoneInput.setAttribute("disabled", "disabled");
        } else {
            phoneInput.removeAttribute("disabled");
        }
    });
});
</script>

</body>
</html>
