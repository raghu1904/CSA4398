<?php
// Initialize variables
$error = "";
$success = "";

// Database credentials
$servername = "localhost";
$username = "root"; // Default XAMPP username
$password = ""; // Default XAMPP password
$dbname = "hostel_management";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to check admin login
function validateAdmin($conn, $username, $password) {
    $stmt = $conn->prepare("SELECT password FROM admins WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows == 1) {
        $stmt->bind_result($hashed_password);
        $stmt->fetch();
        if (password_verify($password, $hashed_password)) {
            return true;
        }
    }
    return false;
}

// Function to check student login
function validateStudent($conn, $register_number, $password) {
    $stmt = $conn->prepare("SELECT password FROM students WHERE register_number = ?");
    $stmt->bind_param("s", $register_number);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows == 1) {
        $stmt->bind_result($hashed_password);
        $stmt->fetch();
        if (password_verify($password, $hashed_password)) {
            return true;
        }
    }
    return false;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login_type = $_POST['login_type'];
    
    if ($login_type == 'admin') {
        $username = $_POST['admin-username'];
        $password = $_POST['admin-password'];
        
        if (validateAdmin($conn, $username, $password)) {
            $success = "Login successful! Redirecting...";
            header("refresh:2;url=admin_dashboard.html");
        } else {
            $error = "Invalid Admin Username or Password";
        }
        
    } elseif ($login_type == 'student') {
        $register_number = $_POST['student-username'];
        $password = $_POST['student-password'];
        
        if (validateStudent($conn, $register_number, $password)) {
            $success = "Login successful! Redirecting...";
            header("refresh:2;url=student_dashboard.html");
        } else {
            $error = "Invalid Register Number or Password";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hostel Management System - Login</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
            margin: 0;
        }
        .container {
            text-align: center;
        }
        .login-box {
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin: 10px;
            display: inline-block;
            width: 300px;
        }
        .login-box h2 {
            margin-bottom: 20px;
        }
        .login-box label {
            display: block;
            margin: 10px 0 5px;
        }
        .login-box input[type="text"],
        .login-box input[type="password"] {
            width: 100%;
            padding: 8px;
            margin: 5px 0 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .login-box input[type="submit"] {
            background: #007BFF;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
        }
        .login-box input[type="submit"]:hover {
            background: #0056b3;
        }
        .message {
            color: red;
        }
        .success {
            color: green;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>SSE HOSTEL</h1>
        
        <!-- Admin Login Section -->
        <div class="login-box">
            <h2>Admin Login</h2>
            <form action="" method="post">
                <input type="hidden" name="login_type" value="admin">
                <label for="admin-username">Admin Username:</label>
                <input type="text" id="admin-username" name="admin-username" required>

                <label for="admin-password">Admin Password:</label>
                <input type="password" id="admin-password" name="admin-password" required>

                <input type="submit" value="Login">
            </form>
        </div>

        <!-- Student Login Section -->
        <div class="login-box">
            <h2>Student Login</h2>
            <form action="" method="post">
                <input type="hidden" name="login_type" value="student">
                <label for="student-username">Register Number (Username):</label>
                <input type="text" id="student-username" name="student-username" required>

                <label for="student-password">Password:</label>
                <input type="password" id="student-password" name="student-password" required>

                <input type="submit" value="Login">
            </form>
        </div>

        <!-- Display messages -->
        <?php if (!empty($error)) : ?>
            <p class="message"><?php echo $error; ?></p>
        <?php endif; ?>
        <?php if (!empty($success)) : ?>
            <p class="success"><?php echo $success; ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
