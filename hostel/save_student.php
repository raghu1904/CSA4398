<?php
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

$name = $_POST['name'];
$register_number = $_POST['register_number'];
$year = $_POST['year'];
$gender = $_POST['gender'];
$mobile = $_POST['mobile'];
$email = $_POST['email'];
$dob = $_POST['dob'];
$address = $_POST['address'];
$department = $_POST['department'];

$sql = "INSERT INTO students (name, register_number, year, gender, mobile, email, dob, address, department)
VALUES ('$name', '$register_number', '$year', '$gender', '$mobile', '$email', '$dob', '$address', '$department')";

if ($conn->query($sql) === TRUE) {
    echo "New student saved successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
