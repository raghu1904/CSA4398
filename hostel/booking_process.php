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
$roomSelection = $_POST['room-selection'];
$foodOptions = $_POST['food-options'];
$paymentMethod = $_POST['payment-method'];

// Calculate total cost
$roomCost = 0;
$foodCost = 0;

// Define costs for rooms
if ($roomSelection == 'room1') {
    $roomCost = 5000;
} elseif ($roomSelection == 'room2') {
    $roomCost = 4000;
}

// Define cost for food options
if ($foodOptions == 'with-food') {
    $foodCost = 1000;
}

// Total cost
$totalCost = $roomCost + $foodCost;

// Example user ID (Replace with actual user ID or fetch from session)
$userId = 1; // Assuming a logged-in user ID, replace with actual logic

// Insert booking data into the database
$sql = "INSERT INTO bookings (user_id, room_selection, food_options, payment_method, total_cost)
VALUES ('$userId', '$roomSelection', '$foodOptions', '$paymentMethod', '$totalCost')";

if ($conn->query($sql) === TRUE) {
    echo "Booking confirmed successfully.";
    // Redirect to a confirmation page or dashboard
    header("Location: student_dashboard.html");
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close connection
$conn->close();
?>
