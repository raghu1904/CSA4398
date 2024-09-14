<?php
// Database connection details
$servername = "localhost";
$username = "root"; // Default XAMPP username
$password = ""; // Leave blank for XAMPP
$dbname = "hostel_management";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data using POST method
$name = $_POST['name'];
$register_number = $_POST['register-number'];
$year = $_POST['year'];
$gender = $_POST['gender'];
$department = $_POST['department'];
$dob = $_POST['dob'];
$address = $_POST['address'];
$student_mobile = $_POST['student-mobile'];

// Insert the student data into the `students` table
$sql = "INSERT INTO students (name, register_number, year, gender, department, dob, address, student_mobile)
        VALUES ('$name', '$register_number', '$year', '$gender', '$department', '$dob', '$address', '$student_mobile')";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Student added successfully');</script>";
    echo "<script>window.location.href = 'admin_dashboard.html';</script>"; // Redirect to the dashboard
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close connection
$conn->close();
?>
