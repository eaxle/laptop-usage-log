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

// Get teacher_id from the query string
$teacherId = isset($_GET['teacher_id']) ? sanitizeData($_GET['teacher_id']) : '';

if (empty($teacherId)) {
    echo json_encode([]);
    exit();
}

// Fetch data from the database
$stmt = $conn->prepare("SELECT id, name, laptop, signin as signIn, signin_time as signInTime, signout as signOut, signout_time as signOutTime FROM STUDENT_login WHERE teacher_id = ?");
$stmt->bind_param("s", $teacherId);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

$stmt->close();
$conn->close();

echo json_encode($data);
?>