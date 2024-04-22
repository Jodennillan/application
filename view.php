<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

include('database.php');

// Get application ID from URL
$application_id = $_GET['application_id'];

// Fetch application and educational details
$sql_applicant = "SELECT user.fullname, user.email, user.phone,
                   programme.program_name, application.status,
                   form_four.exam_year_o, form_four.subjects_o, form_four.grades_o,
                   form_six.exam_year_a, form_six.subjects_a, form_six.grades_a
                   FROM application
                   INNER JOIN user ON application.user_id = user.user_id 
                   INNER JOIN programme ON application.program_id = programme.program_id
                   INNER JOIN form_four ON application.form_four_id = form_four.form_four_id
                   INNER JOIN form_six ON application.form_six_id = form_six.form_six_id
                   WHERE application.application_id = $application_id";

$result_applicant = mysqli_query($conn, $sql_applicant);
if (!$result_applicant) {
    die("Database error: " . mysqli_error($conn));
}

$applicant = mysqli_fetch_assoc($result_applicant);

// Update the status when the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'];
    $status_message = $_POST['status_message'] ?? '';

    $sql_update = "UPDATE application 
                   SET status = '$status', status_message = '$status_message'
                   WHERE application_id = $application_id";

    if (mysqli_query($conn, $sql_update)) {
        header("Location: admin_dashboard.php");
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
    <title>Application Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        .content {
            padding: 20px;
        }
        .btn-back {
            background-color: #007bff;
            border-color: #007bff;
            color: #fff;
        }

        .btn-back:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="content">
        <h2>Application Details</h2>
        <p><strong>Full Name:</strong> <?php echo $applicant['fullname']; ?></p>
        <p><strong>Email:</strong> <?php echo $applicant['email']; ?></p>
        <p><strong>Phone:</strong> <?php echo $applicant['phone']; ?></p>
        <p><strong>Program:</strong> <?php echo $applicant['program_name']; ?></p>
        <p><strong>Current Status:</strong> <?php echo $applicant['status']; ?></p>

        <!-- Educational Results -->
        <h3>O-Level Exam Results</h3>
        <p><strong>Exam Year:</strong> <?php echo $applicant['exam_year_o']; ?></p>
        <p><strong>Subjects:</strong> <?php echo $applicant['subjects_o']; ?></p>
        <p><strong>Grades:</strong> <?php echo $applicant['grades_o']; ?></p>

        <h3>A-Level Exam Results</h3>
        <p><strong>Exam Year:</strong> <?php echo $applicant['exam_year_a']; ?></p>
        <p><strong>Subjects:</strong> <?php echo $applicant['subjects_a']; ?></p>
        <p><strong>Grades:</strong> <?php echo $applicant['grades_a']; ?></p>

        <!-- Form to Approve or Reject the Application -->
        <form method="POST">
            <select name="status">
                <option value="approved">Approve</option>
                <option value="rejected">Reject</option>
            </select>
            <input type="text" name="status_message" placeholder="Optional status message">
            <button type="submit" class="btn btn-primary">Update Status</button>
        </form>

        <!-- Link to Return to Admin Dashboard -->
        <p><a href="admin.php" class="btn btn-primary btn-block btn-back">Back</a></p>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
