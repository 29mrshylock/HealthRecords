<?php
// Database connection
include("includes/config.php");

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}

// Fetch doctor data (for availability)
$doctor_id = isset($_GET['doctor_id']) ? (int)$_GET['doctor_id'] : 1;
$doctor_name = isset($_GET['doctor_name']) ? htmlspecialchars($_GET['doctor_name']) : 'Dr. John Smith';
$stmt = $conn->prepare("SELECT availability FROM doctors WHERE id = :id");
$stmt->execute([':id' => $doctor_id]);
$doctor = $stmt->fetch(PDO::FETCH_ASSOC);
$availability = $doctor ? $doctor['availability'] : 'Mon-Fri: 10 AM - 4 PM';

// Process form submission
$errors = [];
$success = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patient_name = htmlspecialchars(trim($_POST['patient_name']));
    $contact = htmlspecialchars(trim($_POST['contact']));
    $email = htmlspecialchars(trim($_POST['email']));
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];
    $message = htmlspecialchars(trim($_POST['message']));

    // Validation
    if (empty($patient_name)) $errors[] = "Full name is required.";
    if (empty($contact) || !preg_match("/^\+?[1-9]\d{1,14}$/", $contact)) $errors[] = "Valid contact number is required.";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required.";
    if (empty($appointment_date)) $errors[] = "Appointment date is required.";
    if (empty($appointment_time)) $errors[] = "Appointment time is required.";
    
    // Validate date (no past dates)
    $selected_date = new DateTime($appointment_date);
    $today = new DateTime();
    $today->setTime(0, 0);
    if ($selected_date < $today) $errors[] = "Appointment date cannot be in the past.";

    // Validate time against doctor's availability
    $time = DateTime::createFromFormat('H:i', $appointment_time);
    $start_time = DateTime::createFromFormat('H:i A', '10:00 AM');
    $end_time = DateTime::createFromFormat('H:i A', '4:00 PM');
    if ($time < $start_time || $time > $end_time) $errors[] = "Appointment time must be between 10 AM and 4 PM.";

    // Check day of week (Mon-Fri)
    $day_of_week = $selected_date->format('N');
    if ($day_of_week > 5) $errors[] = "Appointments are only available Monday to Friday.";

    if (empty($errors)) {
        // Check for existing appointments (avoid double-booking)
        $stmt = $conn->prepare("SELECT COUNT(*) FROM appointments WHERE doctor_id = :doctor_id AND appointment_date = :date AND appointment_time = :time");
        $stmt->execute([
            ':doctor_id' => $doctor_id,
            ':date' => $appointment_date,
            ':time' => $appointment_time
        ]);
        if ($stmt->fetchColumn() > 0) {
            $errors[] = "This time slot is already booked. Please choose another time.";
        } else {
            // Insert into database
            $sql = "INSERT INTO appointments (doctor_id, patient_name, contact, email, appointment_date, appointment_time, message, status) 
                    VALUES (:doctor_id, :patient_name, :contact, :email, :appointment_date, :appointment_time, :message, 'Pending')";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':doctor_id' => $doctor_id,
                ':patient_name' => $patient_name,
                ':contact' => $contact,
                ':email' => $email,
                ':appointment_date' => $appointment_date,
                ':appointment_time' => $appointment_time,
                ':message' => $message
            ]);

            $success = "Appointment booked successfully! You will receive a confirmation soon.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment - <?php echo htmlspecialchars($doctor_name); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .form-input {
            transition: all 0.3s ease;
            border: 2px solid #e5e7eb;
        }
        .form-input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 12px rgba(59, 130, 246, 0.3);
        }
        .btn-submit {
            background: linear-gradient(to right, #3b82f6, #1d4ed8);
            transition: all 0.3s ease;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.5);
        }
        .error {
            color: #dc2626;
            font-size: 0.9rem;
            margin-top: 4px;
        }
        .success {
            color: #15803d;
            font-size: 1.1rem;
            font-weight: 600;
            text-align: center;
        }
        .availability-note {
            background: rgba(59, 130, 246, 0.1);
            border-left: 4px solid #3b82f6;
            padding: 12px;
            border-radius: 8px;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-100 via-blue-50 to-gray-100 font-sans min-h-screen flex items-center justify-center">
    <div class="container mx-auto p-6 max-w-3xl">
        <div class="card p-10">
            <h1 class="text-4xl font-extrabold text-gray-800 mb-6 text-center">
                <i class="fas fa-calendar-check mr-3 text-blue-500"></i> Book Appointment with <?php echo htmlspecialchars($doctor_name); ?>
            </h1>

            <!-- Availability Note -->
            <div class="availability-note mb-6">
                <p class="text-gray-700"><strong>Availability:</strong> <?php echo htmlspecialchars($availability); ?></p>
                <p class="text-sm text-gray-600 mt-1">Please select a time between 10 AM and 4 PM, Monday to Friday.</p>
            </div>

            <!-- Success or Error Messages -->
            <?php if ($success): ?>
                <p class="success mb-6"><?php echo $success; ?></p>
            <?php endif; ?>
            <?php if (!empty($errors)): ?>
                <div class="mb-6">
                    <?php foreach ($errors as $error): ?>
                        <p class="error"><?php echo $error; ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Appointment Form -->
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?doctor_id=' . $doctor_id . '&doctor_name=' . urlencode($doctor_name); ?>">
                <div class="mb-5">
                    <label for="patient_name" class="block text-gray-700 font-semibold mb-2">Full Name</label>
                    <input type="text" id="patient_name" name="patient_name" class="form-input w-full p-3 rounded-lg" 
                           value="<?php echo isset($patient_name) ? htmlspecialchars($patient_name) : ''; ?>" 
                           aria-required="true" placeholder="Enter your full name">
                </div>

                <div class="mb-5">
                    <label for="contact" class="block text-gray-700 font-semibold mb-2">Contact Number</label>
                    <input type="tel" id="contact" name="contact" class="form-input w-full p-3 rounded-lg" 
                           value="<?php echo isset($contact) ? htmlspecialchars($contact) : ''; ?>" 
                           aria-required="true" placeholder="+91XXXXXXXXXX">
                </div>

                <div class="mb-5">
                    <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
                    <input type="email" id="email" name="email" class="form-input w-full p-3 rounded-lg" 
                           value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" 
                           aria-required="true" placeholder="your.email@example.com">
                </div>

                <div class="mb-5">
                    <label for="appointment_date" class="block text-gray-700 font-semibold mb-2">Appointment Date</label>
                    <input type="date" id="appointment_date" name="appointment_date" class="form-input w-full p-3 rounded-lg" 
                           min="<?php echo date('Y-m-d'); ?>" aria-required="true">
                </div>

                <div class="mb-5">
                    <label for="appointment_time" class="block text-gray-700 font-semibold mb-2">Appointment Time</label>
                    <input type="time" id="appointment_time" name="appointment_time" class="form-input w-full p-3 rounded-lg" 
                           min="10:00" max="16:00" step="1800" aria-required="true">
                </div>

                <div class="mb-5">
                    <label for="message" class="block text-gray-700 font-semibold mb-2">Additional Message (Optional)</label>
                    <textarea id="message" name="message" class="form-input w-full p-3 rounded-lg" rows="5" 
                              placeholder="Any specific concerns or requests"><?php echo isset($message) ? htmlspecialchars($message) : ''; ?></textarea>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn-submit text-white px-10 py-4 rounded-full text-lg font-semibold flex items-center mx-auto">
                        <i class="fas fa-check-circle mr-3"></i> Confirm Appointment
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Client-side validation and enhancements
        document.addEventListener('DOMContentLoaded', () => {
            const dateInput = document.getElementById('appointment_date');
            const timeInput = document.getElementById('appointment_time');

            // Restrict past dates
            dateInput.addEventListener('change', () => {
                const selectedDate = new Date(dateInput.value);
                const today = new Date();
                today.setHours(0, 0, 0, 0);
                if (selectedDate < today) {
                    alert('Please select a future date.');
                    dateInput.value = '';
                } else {
                    // Restrict to Mon-Fri
                    const day = selectedDate.getDay();
                    if (day === 0 || day === 6) {
                        alert('Appointments are only available Monday to Friday.');
                        dateInput.value = '';
                    }
                }
            });

            // Restrict time to 10 AM - 4 PM
            timeInput.addEventListener('change', () => {
                const time = timeInput.value;
                if (time < '10:00' || time > '16:00') {
                    alert('Please select a time between 10 AM and 4 PM.');
                    timeInput.value = '';
                }
            });

            // Form animation
            const inputs = document.querySelectorAll('.form-input');
            inputs.forEach(input => {
                input.addEventListener('focus', () => {
                    input.parentElement.classList.add('animate-pulse');
                });
                input.addEventListener('blur', () => {
                    input.parentElement.classList.remove('animate-pulse');
                });
            });
        });
    </script>
</body>
</html>