<?php
// Database connection parameters
$servername = "localhost";
$username = "root"; // default XAMPP username
$password = ""; // default XAMPP password (empty)
$dbname = "hostel_management"; // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$roomNumber = $_POST['room-number'];
$issueDate = $_POST['issue-date'];
$issueDescription = $_POST['issue-description'];

// Example user ID (Replace with actual user ID or fetch from session)
$userId = 1; // Assuming a logged-in user ID, replace with actual logic

// Insert issue data into the database
$sql = "INSERT INTO issues (user_id, room_number, issue_date, issue_description)
VALUES ('$userId', '$roomNumber', '$issueDate', '$issueDescription')";

if ($conn->query($sql) === TRUE) {
    echo "Issue submitted successfully.";
    // Redirect to a confirmation page or dashboard
    header("Location: student_dashboard.html");
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close connection
$conn->close();
?>
