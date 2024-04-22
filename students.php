<?php
include('database.php');

$sql_selected_students = "SELECT user.user_id, user.fullname, programme.program_name, application.status 
                          FROM application 
                          INNER JOIN user ON application.user_id = user.user_id 
                          INNER JOIN programme ON application.program_id = programme.program_id 
                          WHERE application.status = 'approved'"; // Only fetch selected students

$result_selected_students = mysqli_query($conn, $sql_selected_students);
if (!$result_selected_students) {
    die("Database error: " . mysqli_error($conn));
}

$students = [];
while ($row = mysqli_fetch_assoc($result_selected_students)) {
    $students[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Selected Students</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>All Selected Students</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>S/N</th>
                    <th>Full Name</th>
                    <th>Program</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (count($students) > 0) {
                    $sn = 1;
                    foreach ($students as $student) {
                        echo "<tr>";
                        echo "<td>{$sn}</td>";
                        echo "<td>{$student['fullname']}</td>";
                        echo "<td>{$student['program_name']}</td>";
                        echo "<td>{$student['status']}</td>"; // Approved status
                        echo "</tr>";
                        $sn++;
                    }
                } else {
                    echo "<tr><td colspan='4'>No students found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
