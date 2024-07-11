<?php
// Database connection settings

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "student_database";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to sanitize input data
function sanitizeData($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize inputs
    $fname = sanitizeData($_POST['name']);
    $laptop = sanitizeData($_POST['laptop']);
    $signIn = filter_var($_POST['signIn'], FILTER_VALIDATE_BOOLEAN);
    $datetime = sanitizeData($_POST['datetime']);
    $teacherID = sanitizeData($_POST['teacherId']);
    // Validate if all required fields are filled
    if (empty($fname) || empty($laptop) || empty($signIn) || empty($datetime) || empty($teacherID)) {
        die("Please fill all required fields.");
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO STUDENT_login (name, laptop, signin, signin_time,teacher_id) VALUES (?, ?, ?, ?,?)");
    $stmt->bind_param("sssss", $fname, $laptop, $signIn, $datetime, $teacherID);

    // Execute the statement
    if ($stmt->execute()) {
        // $last_id = $stmt->insert_id;
        // print_r('helo world');
        header("Location: student.html");

        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}
