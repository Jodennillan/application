<?php
include("database.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $program_name = $_POST["program_name"];
    $duration = $_POST["duration"];

    // Insert program into database
    $sql = "INSERT INTO programme (program_name, duration) VALUES ('$program_name', '$duration')";
    if (mysqli_query($conn, $sql)) {
        echo "Program added successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    header("Location: admin.php");
    exit();

    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Program</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Add Program</h2>
        <form action="program.php" method="POST">
            <div class="mb-3">
                <label for="program_name" class="form-label">Program Name:</label>
                <input type="text" class="form-control" id="program_name" name="program_name" required>
            </div>
            <div class="mb-3">
                <label for="duration" class="form-label">Duration:</label>
                <input type="text" class="form-control" id="duration" name="duration" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Program</button>
        </form>
    </div>
</body>
</html>
