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
$currentPassword = $_POST['current-password'];
$newPassword = $_POST['new-password'];
$confirmNewPassword = $_POST['confirm-new-password'];

// Example user ID (Replace with actual user ID or fetch from session)
$userId = 1; // Assuming a logged-in user ID, replace with actual logic

// Fetch the current password from the database
$sql = "SELECT password FROM students WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->bind_result($storedPassword);
$stmt->fetch();
$stmt->close();

// Check if the current password is correct
if (!password_verify($currentPassword, $storedPassword)) {
    echo "Current password is incorrect.";
    exit();
}

// Check if the new passwords match
if ($newPassword !== $confirmNewPassword) {
    echo "New passwords do not match.";
    exit();
}

// Hash the new password
$hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

// Update the password in the database
$sql = "UPDATE students SET password = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $hashedPassword, $userId);

if ($stmt->execute()) {
    echo "Password changed successfully.";
    // Redirect to a confirmation page or dashboard
    header("Location: student_dashboard.html");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

// Close connection
$stmt->close();
$conn->close();
?>
