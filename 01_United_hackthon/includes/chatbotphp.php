<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "healthsync"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, fullname, specilaty, availability_days, availability_time FROM doctors WHERE verified = 1";
$result = $conn->query($sql);

$doctors = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $doctors[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($doctors);

$conn->close();
?>
