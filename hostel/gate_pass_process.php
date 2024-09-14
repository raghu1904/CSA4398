<?php
// Database connection
$servername = "localhost";
$username = "root"; // Default username for XAMPP
$password = "";     // Default password for XAMPP (empty by default)
$dbname = "hostel_management"; // Name of your database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$register_number = $_POST['register-number'];
$from_date = $_POST['from-date'];
$to_date = $_POST['to-date'];
$reason = $_POST['reason'];
$decision = $_POST['decision'];

// Prepare SQL query to update the gate pass request status
$sql = "UPDATE gate_pass_requests SET decision = ? WHERE register_number = ? AND from_date = ? AND to_date = ? AND reason = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $decision, $register_number, $from_date, $to_date, $reason);
if ($stmt->execute()) {
    echo "<h1>Request Status Updated Successfully</h1>";
} else {
    echo "<h1>Error: " . $stmt->error . "</h1>";
}

// Move the request to history table
$sql_history = "INSERT INTO gate_pass_history (register_number, from_date, to_date, reason, decision) VALUES (?, ?, ?, ?, ?)";
$stmt_history = $conn->prepare($sql_history);
$stmt_history->bind_param("sssss", $register_number, $from_date, $to_date, $reason, $decision);
$stmt_history->execute();

// Optionally delete the request from the current table
$sql_delete = "DELETE FROM gate_pass_requests WHERE register_number = ? AND from_date = ? AND to_date = ? AND reason = ?";
$stmt_delete = $conn->prepare($sql_delete);
$stmt_delete->bind_param("ssss", $register_number, $from_date, $to_date, $reason);
$stmt_delete->execute();

// Close the statement and connection
$stmt->close();
$stmt_history->close();
$stmt_delete->close();
$conn->close();
?>

<!-- Provide a link to go back to the dashboard -->
<p><a href="admin_dashboard.html">Back to Dashboard</a></p>
