<?php
include 'includes/config.php';

$error = "";

$doctor_id = isset($_GET['doctor_id']) ? intval($_GET['doctor_id']) : 0;
$doctor_name = '';



$doctor_id = isset($_GET['doctor_id']) ? intval($_GET['doctor_id']) : 0;

if ($doctor_id <= 0) {
    echo "Invalid Doctor ID!";
    exit;
}

// Handle Appointment Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patientName = mysqli_real_escape_string($conn, $_POST['patientName']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $appointmentDate = mysqli_real_escape_string($conn, $_POST['appointmentDate']);
    $appointmentTime = mysqli_real_escape_string($conn, $_POST['appointmentTime']);
    $symptoms = mysqli_real_escape_string($conn, $_POST['symptoms']);
    $docId = intval($_POST['doctorId']);

    if (!empty($patientName) && !empty($phone) && !empty($appointmentDate) && !empty($appointmentTime) && $docId > 0) {
        $sql = "INSERT INTO appointments (patient_name, phone, email, doctor_id, appointment_date, appointment_time, symptoms)
                VALUES ('$patientName', '$phone', '$email', $docId, '$appointmentDate', '$appointmentTime', '$symptoms')";

        if ($conn->query($sql) === TRUE) {
            header("Location: success.php");
            exit();
        } else {
            $error = "Something went wrong while booking appointment.";
        }
    } else {
        $error = "Please fill all the required fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book Appointment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php else: ?>
            <div class="card shadow p-4 mx-auto" style="max-width: 700px; border-radius: 15px;">
                <h3 class="text-center mb-4">Book Appointment with <strong><?php echo htmlspecialchars($doctor_name); ?></strong></h3>

                <form method="post" action="">
                    <input type="hidden" name="doctorId" value="<?php echo $doctor_id; ?>">

                    <div class="mb-3">
                        <label for="patientName" class="form-label">Your Name</label>
                        <input type="text" class="form-control" id="patientName" name="patientName" required>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Your Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Your Email (optional)</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="appointmentDate" class="form-label">Appointment Date</label>
                            <input type="date" class="form-control" id="appointmentDate" name="appointmentDate" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="appointmentTime" class="form-label">Appointment Time</label>
                            <input type="time" class="form-control" id="appointmentTime" name="appointmentTime" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="symptoms" class="form-label">Symptoms</label>
                        <textarea class="form-control" id="symptoms" name="symptoms" rows="3"></textarea>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Confirm Appointment</button>
                    </div>
                </form>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
