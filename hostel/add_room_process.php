<?php
// Database connection
$host = 'localhost'; // XAMPP default host
$dbname = 'hostel_management'; // Your database name
$username = 'root'; // XAMPP default username
$password = ''; // XAMPP default password

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$hostel_name = $_POST['hostel-name'];
$room_number = $_POST['room-number'];
$room_type = $_POST['room-type'];
$price = $_POST['price'];
$food_options = $_POST['food-options'];
$extra_price = $_POST['extra-price'];

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO rooms (hostel_name, room_number, room_type, price, food_options, extra_price) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssdd", $hostel_name, $room_number, $room_type, $price, $food_options, $extra_price);

// Execute the statement
if ($stmt->execute()) {
    echo "Room added successfully!";
} else {
    echo "Error: " . $stmt->error;
}

// Close connections
$stmt->close();
$conn->close();
?>
