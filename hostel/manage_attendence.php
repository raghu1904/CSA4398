<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hostel_management";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the form data
$department = $_POST['department'];
$year = $_POST['year'];
$date = date("Y-m-d"); // Current date

// Loop through the attendance inputs
foreach ($_POST as $key => $value) {
    if (strpos($key, 'attendance_') === 0) {
        $student_id = str_replace('attendance_', '', $key);
        $attendance_status = $value;

        // Insert attendance data into the 'attendance' table
        $sql = "INSERT INTO attendance (student_id, attendance_status, date) VALUES ('$student_id', '$attendance_status', '$date')";

        if (!$conn->query($sql)) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// After submitting attendance, redirect back to the attendance page
header("Location: attendance_success.php");
exit();

$conn->close();
?>
