<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

include('database.php');

// Get user ID from URL and fetch user data
if (!isset($_GET['user_id'])) {
    die("User ID not specified.");
}

$user_id = (int) $_GET['user_id']; // Cast to integer for safety

$sql_user = "SELECT * FROM user WHERE user_id = $user_id";
$result_user = mysqli_query($conn, $sql_user);

if (!$result_user || mysqli_num_rows($result_user) == 0) {
    die("User not found.");
}

$user = mysqli_fetch_assoc($result_user);

// Handle form submission for updating user
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $sql_update = "UPDATE user 
                   SET fullname = '$fullname', email = '$email', phone = '$phone'
                   WHERE user_id = $user_id";

    if (mysqli_query($conn, $sql_update)) {
        header("Location: manage.php");
        exit;
    } else {
        die("Database error: " . mysqli_error($conn));
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit User</h2>

        <form method="POST">
            <div class="mb-3">
                <label for="fullname" class="form-label">Full Name:</label>
                <input type="text" class="form-control" name="fullname" required value="<?php echo htmlspecialchars($user['fullname']); ?>">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" name="email" required value="<?php echo htmlspecialchars($user['email']); ?>">
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone:</label>
                <input type="text" class="form-control" name="phone" required value="<?php echo htmlspecialchars($user['phone']); ?>">
            </div>
            <button type="submit" class="btn btn-primary">Update User</button>
        </form>

        <!-- Link to return to Manage Users -->
        <p><a href="manage.php" class="btn btn-secondary">Back</a></p>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
