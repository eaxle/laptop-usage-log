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
    $lesson = sanitizeData($_POST['lesson']);
    $signIn = filter_var($_POST['signIn'], FILTER_VALIDATE_BOOLEAN);
    $datetime = sanitizeData($_POST['datetime']);
    
    // Validate if all required fields are filled
    if (empty($fname) || empty($lesson) || empty($signIn) || empty($datetime)) {
        die("Please fill all required fields.");
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO teacher_login (name, lesson, signin, signin_time) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $fname, $lesson, $signIn, $datetime);

    // Execute the statement
    if ($stmt->execute()) {
        $last_id = $stmt->insert_id;
        setcookie("teacher_id", $last_id, time() + (86400 * 30), "/"); // 86400 = 1 day
        setcookie("lesson", $lesson, time() + (86400 * 30), "/"); // 86400 = 1 day

        header("Location: student.html");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
