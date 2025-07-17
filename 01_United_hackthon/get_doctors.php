<?php
include 'includes/config.php';

$id = intval($_GET['id']);
$result = mysqli_query($conn, "SELECT * FROM doctors WHERE id = $id");

if ($row = mysqli_fetch_assoc($result)) {
    echo json_encode($row);
} else {
    echo json_encode(["error" => "Doctor not found"]);
}
?>


<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'healthsync'); // <-- adjust if your DB username/password different

if ($conn->connect_error) {
    die(json_encode(['error' => 'Database connection failed']));
}

// Query doctors
$sql = "SELECT fullname, specilaty, availability_days, availability_time FROM doctors WHERE id = $id"; // only verified doctors
$result = $conn->query($sql);

$doctors = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $doctors[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($doctors);
?>
