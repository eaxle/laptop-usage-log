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
    // Get the JSON input
    $input = json_decode(file_get_contents('php://input'), true);

    // Validate and sanitize inputs
    $teacherID = sanitizeData($input['teacherId']);

    // Validate if all required fields are filled
    if (empty($teacherID)) {
        echo json_encode(['success' => false, 'error' => 'Please fill all required fields.']);
        exit();
    }

    // Prepare and bind
    $sql = "UPDATE teacher_login SET signout = 1, signout_time = NOW() WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $teacherID);

    // Execute the statement
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();

