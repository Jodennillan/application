<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

include('database.php');

// Handle user addition
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql_insert = "INSERT INTO user (fullname, email, phone, password) VALUES ('$fullname', '$email', '$phone', '$password')";
    if (!mysqli_query($conn, $sql_insert)) {
        die("Database error: " . mysqli_error($conn));
    }
}

// Handle user deletion
if (isset($_GET['delete_user_id'])) {
    $delete_user_id = $_GET['delete_user_id'];
    $sql_delete = "DELETE FROM user WHERE user_id = $delete_user_id";
    if (!mysqli_query($conn, $sql_delete)) {
        die("Database error: " . mysqli_error($conn));
    }
}

// Fetch all users
$sql_users = "SELECT * FROM user";
$result_users = mysqli_query($conn, $sql_users);
if (!$result_users) {
    die("Database error: " . mysqli_error($conn));
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Manage Users</h2>

        <!-- Form to Add a New User -->
        <h3>Add New User</h3>
        <form method="POST">
            <div class="mb-3">
                <label for="fullname" class="form-label">Full Name:</label>
                <input type="text" class="form-control" name="fullname" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone:</label>
                <input type="text" class="form-control" name="phone" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <button type="submit" name="add_user" class="btn btn-primary">Add User</button>
        </form>

        <!-- Table of Existing Users -->
        <h3>Existing Users</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($user = mysqli_fetch_assoc($result_users)) {
                    echo "<tr>";
                    echo "<td>" . $user['user_id'] . "</td>";
                    echo "<td>" . $user['fullname'] . "</td>";
                    echo "<td>" . $user['email'] . "</td>";
                    echo "<td>" . $user['phone'] . "</td>";
                    echo "<td>";
                    echo "<a href='edit_user.php?user_id=" . $user['user_id'] . "' class='btn btn-warning'>Edit</a>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
