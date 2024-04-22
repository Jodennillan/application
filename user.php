<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include('database.php');

// Fetch user details
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM user WHERE user_id = $user_id";
$result = mysqli_query($conn, $sql);
if (!$result) {
    die("Database error: " . mysqli_error($conn));
}
$user = mysqli_fetch_assoc($result);


// Get the most recent application status
$sql_app_status = "SELECT status 
                   FROM application 
                   WHERE user_id = $user_id 
                   ORDER BY application_id DESC 
                   LIMIT 1";
$result_app_status = mysqli_query($conn, $sql_app_status);
if (!$result_app_status) {
    die("Database error: " . mysqli_error($conn));
}

$application_status = mysqli_fetch_assoc($result_app_status);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
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
            width: 250px;
            height: 100%;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #343a40;
            padding-top: 20px;
            padding-bottom: 20px;
        }

        .sidebar a {
            padding: 10px;
            text-decoration: none;
            font-size: 1.2rem;
            color: #f8f9fa;
            display: block;
            transition: 0.3s;
        }

        .sidebar a.active {
            background-color: #007bff;
        }

        .sidebar a:hover {
            background-color: #007bff;
            color: #f8f9fa;
        }

        .content {
            margin-left: 250px; /* Same as sidebar width */
            padding: 20px;
        }

        .card {
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .header {
            background-color: #007bff;
            color: #fff;
            padding: 15px;
            text-align: center;
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

        .navbar-nav li {
            display: inline-block;
            list-style: none;
            margin: 0 10px;
        }

        i {
            color: black;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <a class="active" href="#">User Dashboard</a>
        <a href="application.php">Application</a>
        <!-- Admission link hidden by default, shown if approved -->
        <a href="admission.php" id="admission-link" style="display: none;">Admission</a>
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
                            <a class="nav-link" href="#" onclick="toggleProfile()"><i class="fas fa-user"></i> Profile</a>
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
            <p><strong>Full Name:</strong> <?php echo htmlspecialchars($user['fullname']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        </div>
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Hi, <?php echo $user['fullname']; ?>!</h3>
                    <p class="card-text">Welcome to your user dashboard.</p>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h4>Your Application Status</h4>
                    <?php
                    if ($application_status) {
                        $status = $application_status['status'];
                        echo "<p>Status: $status</p>";
                        
                        if ($status === 'approved') {
                            // Show admission link if approved
                            echo "<script>document.getElementById('admission-link').style.display = 'block';</script>";
                        } elseif ($status === 'rejected') {
                            // Allow reapplication if rejected
                            echo "<p>You can reapply.</p>";
                            echo "<a href='application.php' class='btn btn-primary'>Reapply</a>";
                        }
                    } else {
                        echo "<p>You haven't applied yet.</p>";
                        echo "<a href='application.php' class='btn btn-primary'>Apply</a>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
