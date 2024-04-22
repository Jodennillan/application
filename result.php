<?php
session_start();

// Redirect users to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include('database.php');

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Handle form four results submission
    if (isset($_POST['submit_form_four'])) {
        // Process form four results submission
        // Your code to handle form four results submission goes here
    }

    // Handle form six results submission
    if (isset($_POST['submit_form_six'])) {
        // Process form six results submission
        // Your code to handle form six results submission goes here
    }

    // Handle application form submission
    if (isset($_POST['submit_application'])) {
        // Process application form submission
        // Your code to handle application form submission goes here
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Application</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div id="formFour" class="row">
            <div class="col-md-6">
                <h2 class="text-center mb-4">Form Four Results</h2>
                <form action="application.php" method="POST">
                    <!-- Form Four result fields -->
                     <div class="col-md-6">
                <h3 class="text-center mb-3">Form Four Results</h3>
                <form action="submit_form_four_results.php" method="POST">
                    <div class="mb-3">
                        <label for="exam_year_4" class="form-label">Exam Year:</label>
                        <input type="text" class="form-control" id="exam_year_4" name="exam_year" required>
                    </div>
                    <div class="mb-3">
                        <label for="subjects_4" class="form-label">Subjects (comma-separated):</label>
                        <input type="text" class="form-control" id="subjects_4" name="subjects" required>
                    </div>
                    <div class="mb-3">
                        <label for="grade_4" class="form-label">Grade:</label>
                        <input type="text" class="form-control" id="grade_4" name="grade" required>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="showFormSix()">Next</button>
                </form>
            </div>
        </div>

        <div id="formSix" class="row" style="display: none;">
            <div class="col-md-6">
                <h3 class="text-center mb-3">Form Six Results</h3>
                <form action="submit_form_six_results.php" method="POST">
                    <div class="mb-3">
                        <label for="exam_year_6" class="form-label">Exam Year:</label>
                        <input type="text" class="form-control" id="exam_year_6" name="exam_year" required>
                    </div>
                    <div class="mb-3">
                        <label for="subjects_6" class="form-label">Subjects (comma-separated):</label>
                        <input type="text" class="form-control" id="subjects_6" name="subjects" required>
                    </div>
                    <div class="mb-3">
                        <label for="grade_6" class="form-label">Grade:</label>
                        <input type="text" class="form-control" id="grade_6" name="grade" required>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="showApplicationForm()">Next</button>
                </form>
            </div>
        </div>

        <div id="applicationForm" class="row" style="display: none;">
            <div class="col-md-6">
                <h2 class="text-center mb-4">Application Form</h2>
                <form action="application.php" method="POST">
                    <!-- Application form fields -->
                    <div class="container mt-5">
        <h2 class="text-center mb-4">User Application Form</h2>
        <form action="submit_application.php" method="POST">
            <div class="mb-3">
                <label for="program_id" class="form-label">Select Program:</label>
                <select class="form-select" id="program_id" name="program_id" required>
                    <option value="" selected disabled>Select Program</option>
                    <!-- PHP code to fetch and display program options -->
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
            <div class="mb-3">
                <label for="id_four" class="form-label">Form Four Results ID:</label>
                <input type="text" class="form-control" id="id_four" name="id_four" required>
            </div>
            <div class="mb-3">
                <label for="id_six" class="form-label">Form Six Results ID:</label>
                <input type="text" class="form-control" id="id_six" name="id_six" required>
            </div>
                    <button type="submit" class="btn btn-primary" name="submit_application">Submit Application</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function showFormSix() {
            document.getElementById('formFour').style.display = 'none';
            document.getElementById('formSix').style.display = 'block';
        }

        function showApplicationForm() {
            document.getElementById('formSix').style.display = 'none';
            document.getElementById('applicationForm').style.display = 'block';
        }
    </script>
</body>
</html>
