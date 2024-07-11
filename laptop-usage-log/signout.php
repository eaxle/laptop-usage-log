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

// Get JSON input
$input = json_decode(file_get_contents('php://input'), true);

$name = sanitizeData($input['name']);
$laptop = sanitizeData($input['laptop']);
$signOutTime = sanitizeData($input['signOutTime']);
$teacherId = sanitizeData($input['teacherId']);

// Validate if all required fields are filled
if (empty($name) || empty($laptop) || empty($signOutTime) || empty($teacherId)) {
    echo json_encode(['success' => false, 'error' => 'Please fill all required fields.']);
    exit();
}

// Prepare and bind
$stmt = $conn->prepare("UPDATE STUDENT_login SET signout = ?, signout_time = ? WHERE name = ? AND laptop = ? AND teacher_id = ?");
$signOut = 1; // True for sign out
$stmt->bind_param("sssss", $signOut, $signOutTime, $name, $laptop, $teacherId);

// Execute the statement
if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $stmt->error]);
}

// Close the statement
$stmt->close();
$conn->close();
