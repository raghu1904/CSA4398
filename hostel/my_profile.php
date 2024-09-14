<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - SIMATS Hostel</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* General styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 10;
            padding: 20;
        }
        .module {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .module h2 {
            margin-top: 0;
            color: #333;
            font-size: 24px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }
        .back-to-dashboard {
            display: inline-block;
            margin-bottom: 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
        }
        .back-to-dashboard:hover {
            background-color: #0056b3;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        form label {
            margin-bottom: 5px;
            color: #333;
            font-weight: bold;
        }
        form input, form textarea {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        form input[readonly] {
            background-color: #f9f9f9;
        }
        form textarea {
            resize: vertical;
        }
    </style>
</head>
<body>
    <div class="module">
        <h2>My Profile</h2>
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

        // Assuming the student's register number is passed through session or as a GET parameter
        $register_number = $_GET['register_number']; // Or use session to store the register number

        $sql = "SELECT * FROM students WHERE register_number='$register_number'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output data of each row
            $row = $result->fetch_assoc();
            echo "<form>";
            echo "<label for='profile-name'>Name:</label>";
            echo "<input type='text' id='profile-name' name='profile-name' value='" . htmlspecialchars($row["name"]) . "' readonly>";

            echo "<label for='register-number'>Register Number:</label>";
            echo "<input type='text' id='register-number' name='register-number' value='" . htmlspecialchars($row["register_number"]) . "' readonly>";

            echo "<label for='year'>Year:</label>";
            echo "<input type='text' id='year' name='year' value='" . htmlspecialchars($row["year"]) . "' readonly>";

            echo "<label for='gender'>Gender:</label>";
            echo "<input type='text' id='gender' name='gender' value='" . htmlspecialchars($row["gender"]) . "' readonly>";

            echo "<label for='mobile'>Mobile Number:</label>";
            echo "<input type='text' id='mobile' name='mobile' value='" . htmlspecialchars($row["mobile"]) . "' readonly>";

            echo "<label for='email'>Email Address:</label>";
            echo "<input type='email' id='email' name='email' value='" . htmlspecialchars($row["email"]) . "' readonly>";

            echo "<label for='dob'>Date of Birth:</label>";
            echo "<input type='date' id='dob' name='dob' value='" . htmlspecialchars($row["dob"]) . "' readonly>";

            echo "<label for='address'>Address:</label>";
            echo "<textarea id='address' name='address' rows='4' readonly>" . htmlspecialchars($row["address"]) . "</textarea>";

            echo "<label for='department'>Department:</label>";
            echo "<input type='text' id='department' name='department' value='" . htmlspecialchars($row["department"]) . "' readonly>";

            echo "</form>";
        } else {
            echo "No profile found.";
        }

        $conn->close();
        ?>
        <a href="student_dashboard.html" class="back-to-dashboard">Back to Dashboard</a>
    </div>
</body>
</html>
