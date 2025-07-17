<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit;
}

$con = mysqli_connect("localhost", "root", "", "healthsync");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$doctor_id = $_GET['id'];
$doctor_query = mysqli_query($con, "SELECT fullname FROM doctors WHERE id = $doctor_id");
$doctor = mysqli_fetch_assoc($doctor_query);

$patient_result = mysqli_query($con, "SELECT * FROM patient WHERE doctor_id = $doctor_id");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Doctor's Patients</title>
    <style>
        body { font-family: Arial; padding: 40px; background: #f0f0f0; }
        h2 { color: #333; }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        th, td { padding: 10px; border: 1px solid #ccc; text-align: center; }
        th { background: #4A90E2; color: white; }
        a { text-decoration: none; color: #4A90E2; }
    </style>
</head>
<body>

<h2>Patients of Dr. <?= $doctor['fullname'] ?></h2>

<table>
    <tr>
        <th>Patient ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
    </tr>
    <?php while ($patient = mysqli_fetch_assoc($patient_result)) : ?>
        <tr>
            <td><?= $patient['id'] ?></td>
            <td><?= $patient['name'] ?></td>
            <td><?= $patient['email'] ?></td>
            <td><?= $patient['phone'] ?></td>
        </tr>
    <?php endwhile; ?>
</table>

<p><a href="admin.php">⬅ Back to Doctor List</a></p>

<?php include 'includes/chatbot.php'; ?>

</body>
</html>