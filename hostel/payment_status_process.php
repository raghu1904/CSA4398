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
$department = $_POST['department'];
$year = $_POST['year'];
$payment_status = $_POST['payment-status'];

// Prepare SQL query to fetch payment status based on user input
$sql = "SELECT * FROM payments WHERE department = ? AND year = ? AND payment_status = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $department, $year, $payment_status);
$stmt->execute();
$result = $stmt->get_result();

// Check if there are any results
if ($result->num_rows > 0) {
    echo "<h1>Payment Status for $department - $year - $payment_status</h1>";
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Student Name</th>
                <th>Amount</th>
                <th>Payment Status</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['student_name']}</td>
                <td>{$row['amount']}</td>
                <td>{$row['payment_status']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No records found.</p>";
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
