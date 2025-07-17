 <?php

require_once 'Appointments.php';
require_once 'EHR.php';

// $db = new mysqli('localhost', 'username', 'password', 'healthcare_db');
// $appointments = new Appointments($db);
// $ehr = new EHR($db);

// // Handle form submissions
// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     if (isset($_POST['create_appointment'])) {
//         $appointments->createAppointment(
//             $_POST['patient_id'],
//             $_SESSION['doctor_id'],
//             $_POST['appointment_date'],
//             $_POST['reason']
//         );
//     }
// }
// ?>

<!-- // Include the same header/sidebar as index.php  -->

<div class="col-md-10 p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Appointment Management</h3>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newAppointmentModal">
            <i class="bi bi-plus-circle me-1"></i> New Appointment
        </button>
    </div>

   <!-- // Appointment Calendar View  -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Appointment Calendar</h5>
        </div>
        <div class="card-body">
            <div id="calendar"></div>
        </div>
    </div>

  <!-- // Appointment List // -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Upcoming Appointments</h5>
            <div class="btn-group">
                <button class="btn btn-sm btn-outline-secondary">Today</button>
                <button class="btn btn-sm btn-outline-secondary">Week</button>
                <button class="btn btn-sm btn-outline-secondary">Month</button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Date & Time</th>
                            <th>Patient</th>
                            <th>Doctor</th>
                            <th>Purpose</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $allAppointments = $appointments->getDoctorAppointments($_SESSION['doctor_id']);
                        foreach ($allAppointments as $appt) {
                            $patient = $ehr->getPatientRecord($appt['patient_id']);
                            echo "<tr>
                                <td>".date('M j, Y h:i A', strtotime($appt['appointment_date']))."</td>
                                <td>{$patient['first_name']} {$patient['last_name']}</td>
                                <td>Dr. Smith</td>
                                <td>{$appt['reason']}</td>
                                <td><span class='badge bg-".($appt['status']=='scheduled'?'primary':($appt['status']=='completed'?'success':'warning'))."'>".ucfirst($appt['status'])."</span></td>
                                <td>
                                    <div class='btn-group btn-group-sm'>
                                        <a href='appointment.php?id={$appt['id']}' class='btn btn-outline-primary' title='View'>
                                            <i class='bi bi-eye'></i>
                                        </a>
                                        <button class='btn btn-outline-success' title='Check In'>
                                            <i class='bi bi-check-circle'></i>
                                        </button>
                                        <button class='btn btn-outline-danger' title='Cancel'>
                                            <i class='bi bi-x-circle'></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- // New Appointment Modal // -->
<div class="modal fade" id="newAppointmentModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Schedule New Appointment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Patient</label>
                            <select class="form-select" name="patient_id" required>
                                <option value="">Select Patient</option>
                                <?php
                                $patients = $ehr->getAllPatients();
                                foreach ($patients as $patient) {
                                    echo "<option value='{$patient['id']}'>{$patient['first_name']} {$patient['last_name']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Date & Time</label>
                            <input type="datetime-local" class="form-control" name="appointment_date" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Reason for Visit</label>
                        <textarea class="form-control" name="reason" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="create_appointment" class="btn btn-primary">Schedule Appointment</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- 
// Include JavaScript for calendar and other functionality // -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: [
                
                <?php
                foreach ($allAppointments as $appt) {
                    echo "{
                        title: '{$appt['reason']}',
                        start: '{$appt['appointment_date']}',
                        url: 'appointment.php?id={$appt['id']}'
                    },";
                }
                ?>
                
            ]
        });
        calendar.render();
    });
</script>