<?php
session_start();

// Redirect user to login page if not logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

include('database.php');

// Fetch admin details
$admin_id = $_SESSION['admin_id'];
$sql_admin = "SELECT * FROM admin WHERE admin_id = $admin_id";
$result_admin = mysqli_query($conn, $sql_admin);
if (!$result_admin) {
    die("Database error: " . mysqli_error($conn));
}
$admin = mysqli_fetch_assoc($result_admin);

if (isset($_POST['update_status'])) {
    if (isset($_POST['application_id']) && isset($_POST['status'])) {
        $application_id = $_POST['application_id'];
        $status = $_POST['status'];
        $status_message = $_POST['status_message'] ?? ''; // Default to empty string if not set
        $sql_update = "UPDATE application 
                       SET status = '$status', status_message = '$status_message'
                       WHERE application_id = $application_id";
        if (mysqli_query($conn, $sql_update)) {
            // If successful, redirect to avoid re-submission of form
            header("Location: admin.php");
            exit;
        } else {
            die("Database error: " . mysqli_error($conn));
        }
    } else {
        echo "Application ID or status not set.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cabin&display=swap" rel="stylesheet">
    <script>
    function toggleProfile() {
        var profileSection = document.getElementById("profile-section");
        if (profileSection.style.display === "none") {
            profileSection.style.display = "block";
        } else {
            profileSection.style.display = "none";
        }
    }
    </script>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Cabin', sans-serif;
        }

        .sidebar {
            height: 100%;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #343a40;
            padding-top: 20px;
        }

        .sidebar a {
            padding: 10px;
            text-decoration: none;
            font-size: 1.2rem;
            color: #f8f9fa;
            display: block;
        }

        .sidebar a.active {
            background-color: #007bff;
        }

        .sidebar a:hover {
            background-color: #007bff;
            color: #f8f9fa;
        }

        .content {
            padding-top: 50px;
            margin-left: 250px;
        }

        .card {
            margin-bottom: 20px;
        }

        .navbar-brand {
            font-size: 1.5rem;
        }

        .navbar-toggler {
            order: 1;
        }

        .navbar-collapse {
            text-align: left;
        }

        .navbar-nav {
            margin-left: auto;
        }

        .navbar-nav .nav-item {
            margin-right: 10px;
        }

        .navbar-nav .nav-link {
            color: black;
        }

        .profile-section {
            display: none; /* Initially hidden */
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 20px;
            margin: 10px 0;
        }

        .fa-user,
        .fa-gears,
        .fa-right-from-bracket {
            font-size: 1.5rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #dee2e6;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        .btn-view {
            background-color: #007bff;
            border-color: #007bff;
            color: #fff;
        }

        .btn-view:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <a class="active" href="#">Admin Dashboard</a>
        <a href="program.php">Add Program</a>
        <a href="#">Admission</a>
        <a href="students.php">All Students</a>
        <a href="manage.php">Manage users</a>
    </div>
    <div class="content">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="toggleProfile()"><i class="fas fa-user"></i> Welcome <?php echo $admin['fullname']; ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="fas fa-gears"></i> Settings</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php"><i class="fas fa-right-from-bracket"></i> Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Profile section for the admin, initially hidden -->
        <div id="profile-section" class="profile-section">
            <h4>Your Profile</h4>
            <p><strong>Full Name:</strong> <?php echo htmlspecialchars($admin['fullname']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($admin['email']); ?></p>
        </div>

        <div class="container">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Hi, Admin!</h3>
                    <p class="card-text">You have access to manage users, settings, and more.</p>
                </div>
            </div>

            <h2>All Applications</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Program</th>
                        <th>Current Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch all applications
                    $sql_applications = "SELECT application.application_id, user.fullname, user.email, user.phone, programme.program_name, application.status
                                         FROM application
                                         INNER JOIN user ON application.user_id = user.user_id
                                         INNER JOIN programme ON application.program_id = programme.program_id";

                    $result_applications = mysqli_query($conn, $sql_applications);
                    if (!$result_applications) {
                        die("Database error: " . mysqli_error($conn));
                    }

                    if (mysqli_num_rows($result_applications) > 0) {
                        $num = 1;
                        while ($row = mysqli_fetch_assoc($result_applications)) {
                            echo "<tr>";
                            echo "<td>" . $num++ . "</td>";
                            echo "<td>" . $row['fullname'] . "</td>";
                            echo "<td>" . $row['email'] . "</td>";
                            echo "<td>" . $row['phone'] . "</td>";
                            echo "<td>" . $row['program_name'] . "</td>";
                            echo "<td>" . $row['status'] . "</td>"; // Display current status
                            echo "<td>";
                            echo "<a href='view.php?application_id=" . $row['application_id'] . "'>View</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No applications found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
