<?php
$conn = mysqli_connect("localhost", "root", "", "healthsync");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $id = $_POST['doctor_id'];

  // Toggle verification status
  $check = mysqli_query($conn, "SELECT verified FROM doctors WHERE id = $id");
  $row = mysqli_fetch_assoc($check);
  $newStatus = $row['verified'] ? 0 : 1;

  mysqli_query($conn, "UPDATE doctors SET verified = $newStatus WHERE id = $id");
}

mysqli_close($conn);
// Redirect back to the admin panel
header("Location: admin.php");
exit;
?>