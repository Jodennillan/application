<?php
session_start();

include('database.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect the user to the login page if not logged in
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Get the most recent application
$sql_check = "SELECT * FROM application WHERE user_id = $user_id 
              ORDER BY application_id DESC 
              LIMIT 1";
$result_check = mysqli_query($conn, $sql_check);

$can_reapply = true;

if (mysqli_num_rows($result_check) > 0) {
    $latest_application = mysqli_fetch_assoc($result_check);
    if ($latest_application['status'] !== 'rejected') {
        // If the latest application isn't rejected, prevent reapplication
        $can_reapply = false;
    }
}

// If the form is submitted
if ($_SERVER['REQUEST_METHOD'] == "POST") {
       $user_id = $_SESSION['user_id'];
    
    $program_id = $_POST['program_id'];
    $exam_year_o = $_POST['exam_year_o'];
    $subjects_o = $_POST['subjects_o'];
    $grades_o = $_POST['grades_o'];
    $exam_year_a = $_POST['exam_year_a'];
    $subjects_a = $_POST['subjects_a'];
    $grades_a = $_POST['grades_a'];

    // Insert into form_four
    $sql_o = "INSERT INTO form_four (exam_year_o, subjects_o, grades_o) VALUES ('$exam_year_o', '$subjects_o', '$grades_o')";
    mysqli_query($conn, $sql_o);
    $form_four_id = mysqli_insert_id($conn);

    // Insert into form_six
    $sql_a = "INSERT INTO form_six (exam_year_a, subjects_a, grades_a) VALUES ('$exam_year_a', '$subjects_a', '$grades_a')";
    mysqli_query($conn, $sql_a);
    $form_six_id = mysqli_insert_id($conn);

    // Insert into application along with user_id
    $sql_app = "INSERT INTO application (user_id, program_id, form_four_id, form_six_id) 
                VALUES ('$user_id', '$program_id', '$form_four_id', '$form_six_id')";
    mysqli_query($conn, $sql_app);

    mysqli_close($conn);

    header('Location: user.php');
    exit();
}

// Retrieve user details from the database
$sql_user = "SELECT fullname, email, phone FROM user WHERE user_id = $user_id";
$result_user = mysqli_query($conn, $sql_user);

// Check if the query was successful
if ($result_user) {
    // Check if the user exists
    if (mysqli_num_rows($result_user) > 0) {
        // Fetch user details
        $user = mysqli_fetch_assoc($result_user);
    } else {
        // Redirect the user to the login page if user doesn't exist
        header('Location: login.php');
        exit();
    }
} else {
    // Handle database error
    echo "Error: " . mysqli_error($conn);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Application Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <?php if (!$can_reapply): ?>
                    <div class="alert alert-warning" role="alert">
                        You have already submitted an application.
                    </div>
                <?php else: ?>
                    <h2 class="text-center mb-4">University Application Form</h2>
                    <form action="application.php" method="POST">
                    <!-- Full Name, Email, and Phone are pre-filled -->
                    <div class="mb-3">
                        <label for="full_name" class="form-label">Full Name:</label>
                        <input type="text" class="form-control" id="full_name" name="full name" value="<?php echo $user['fullname']; ?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone:</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $user['phone']; ?>" disabled>
                    </div>
                    <!-- Select Program and other fields remain editable -->
                    <div class="mb-3">
                        <label for="program_id" class="form-label">Select Program:</label>
                        <select class="form-select" id="program_id" name="program_id" required>
                            <option value="" selected disabled>Select Program</option>
                            <!-- Options fetched dynamically from the database -->
                            <?php
                            include('database.php');

                            $sql = "SELECT program_id, program_name FROM programme";
                            $result = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='" . $row['program_id'] . "'>" . $row['program_name'] . "</option>";
                                }
                            }
                            mysqli_close($conn);
                            ?>
                        </select>
                    </div>
                    <!-- Remaining fields for exam details -->
                    <div class="mb-3">
                        <label for="exam_year_o" class="form-label">O-Level Exam Year:</label>
                        <input type="text" class="form-control" id="exam_year_o" name="exam_year_o" required>
                    </div>
                    <div class="mb-3">
                        <label for="subjects_o" class="form-label">O-Level Subjects (comma-separated):</label>
                        <input type="text" class="form-control" id="subjects_o" name="subjects_o" required>
                    </div>
                    <div class="mb-3">
                        <label for="grades_o" class="form-label">O-Level Grades (comma-separated):</label>
                        <input type="text" class="form-control" id="grades_o" name="grades_o" required>
                    </div>
                    <div class="mb-3">
                        <label for="exam_year_a" class="form-label">A-Level Exam Year:</label>
                        <input type="text" class="form-control" id="exam_year_a" name="exam_year_a" required>
                    </div>
                    <div class="mb-3">
                        <label for="subjects_a" class="form-label">A-Level Subjects (comma-separated):</label>
                        <input type="text" class="form-control" id="subjects_a" name="subjects_a" required>
                    </div>
                    <div class="mb-3">
                        <label for="grades_a" class="form-label">A-Level Grades (comma-separated):</label>
                        <input type="text" class="form-control" id="grades_a" name="grades_a" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Application</button>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
