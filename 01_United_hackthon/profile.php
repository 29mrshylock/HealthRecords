<?php
session_start();
require_once 'includes/config.php';

// Fetch Doctor's Details
$doctor_id = $_SESSION['doctor_id'] ?? 1;
$stmt = $conn->prepare("SELECT * FROM doctors WHERE id = ?");
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$result = $stmt->get_result();
$doctor = $result->fetch_assoc();

// Handle Appointment Status Update
if (isset($_POST['update_status'])) {
    $appointment_id = $_POST['appointment_id'];
    $status = $_POST['status'];
    
    $stmt = $conn->prepare("UPDATE appointments SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $appointment_id);
    $stmt->execute();
    header("Location: doctor_profile.php");
    exit();
}

// Fetch All Appointments for This Doctor
$stmt = $conn->prepare("SELECT * FROM appointments WHERE doctor_id = ? ORDER BY appointment_date DESC");
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$result = $stmt->get_result();
$appointments = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dr. <?= $doctor['fullname'] ?> - Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --accent-color: #e74c3c;
            --light-bg: #f4f6f9;
            --card-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            --border-radius: 10px;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--light-bg);
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .container {
            max-width: 1200px;
            margin: auto;
            padding: 0 15px;
        }
        .profile {
            display: flex;
            flex-wrap: wrap;
            background: #fff;
            padding: 30px;
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            margin-bottom: 30px;
            align-items: center;
        }
        .profile-img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #ddd;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            margin-right: 30px;
        }
        .profile-info h1 {
            font-size: 28px;
            margin: 0 0 10px;
        }
        .profile-info p {
            margin: 5px 0;
            font-size: 16px;
        }
        .appointments-card {
            background: #fff;
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            padding: 30px;
        }
        .appointments-card h2 {
            margin-bottom: 20px;
            color: var(--secondary-color);
            font-size: 24px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        th {
            background: var(--secondary-color);
            color: #fff;
        }
        tr:hover {
            background: #f9f9f9;
        }
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
        }
        .Pending {
            background: #fff3e0;
            color: #e65100;
        }
        .Accepted {
            background: #e8f5e9;
            color: #2e7d32;
        }
        .Rejected {
            background: #ffebee;
            color: #c62828;
        }
        .action-form {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .status-select {
            padding: 6px 10px;
            border-radius: 20px;
            border: 1px solid #ccc;
            outline: none;
            font-size: 14px;
        }
        .update-btn {
            background: var(--accent-color);
            border: none;
            color: #fff;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 14px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: background 0.3s ease;
        }
        .update-btn:hover {
            background: #c0392b;
        }
        @media (max-width: 768px) {
            .profile {
                flex-direction: column;
                text-align: center;
            }
            .profile-img {
                margin: 0 0 20px 0;
            }
        }
    </style>
</head>
<body>

<div class="container">

    <div class="profile">
        <img src="<?= $doctor['photo'] ?? 'default_doctor.jpg' ?>" alt="Doctor Photo" class="profile-img">
        <div class="profile-info">
            <h1>Dr. <?= $doctor['fullname'] ?></h1>
            <p><strong>Specialty:</strong> <?= $doctor['specilaty'] ?></p>
            <p><strong>Experience:</strong> <?= $doctor['experience'] ?> years</p>
            <p><strong>Availability:</strong> <?= $doctor['availability_days'] ?>, <?= $doctor['availability_time'] ?></p>
            <p><strong>License:</strong> <?= $doctor['license'] ?></p>
            <p><strong>Email:</strong> <?= $doctor['email'] ?></p>
            <p><strong>Phone:</strong> <?= $doctor['phone'] ?></p>
            <p><strong>Gender:</strong> <?= $doctor['gender'] ?></p>
            <p><strong>Address:</strong> <?= $doctor['address'] ?></p>
            <a href="view.php?doctor_id=<?= urlencode($row['id']) ?>" class="view-patients-btn">View Patients</a>
        </div>
    </div>

    <div class="appointments-card">
        <h2><i class="fas fa-calendar-check"></i> Appointment Requests</h2>
        <table>
            <thead>
                <tr>
                    <th>Patient</th>
                    <th>Contact</th>
                    <th>Date</th>
                    <th>Symptoms</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($appointments as $appointment): ?>
                <tr>
                    <td><?= $appointment['patient_name'] ?><br><small><?= $appointment['email'] ?></small></td>
                    <td><?= $appointment['phone'] ?></td>
                    <td><?= $appointment['appointment_date'] ?><br><small><?= $appointment['appointment_time'] ?></small></td>
                    <td><?= $appointment['symptoms'] ?></td>
                    <td>
                        <span class="status-badge <?= $appointment['status'] ?>"><?= $appointment['status'] ?></span>
                    </td>
                    <td>
                        <form method="POST" class="action-form">
                            <input type="hidden" name="appointment_id" value="<?= $appointment['id'] ?>">
                            <select name="status" class="status-select">
                                <option value="Pending" <?= $appointment['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                                <option value="Accepted" <?= $appointment['status'] == 'Accepted' ? 'selected' : '' ?>>Accept</option>
                                <option value="Rejected" <?= $appointment['status'] == 'Rejected' ? 'selected' : '' ?>>Reject</option>
                            </select>
                            <button type="submit" name="update_status" class="update-btn">
                                <i class="fas fa-sync-alt"></i> Update
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>

</body>
</html>
