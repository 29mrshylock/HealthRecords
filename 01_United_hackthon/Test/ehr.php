 <?php
session_start();
require_once 'EHR.php';
require_once 'Appointments.php';

// $db = new mysqli('localhost', 'username', 'password', 'healthcare_db');
// $ehr = new EHR($db);
// $appointments = new Appointments($db);

// $patientId = $_GET['patient_id'] ?? null;
// $patient = $patientId ? $ehr->getPatientRecord($patientId) : null;

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_medical_history'])) {
        $ehr->addMedicalHistory($patientId, [
            'diagnosis' => $_POST['diagnosis'],
            'symptoms' => $_POST['symptoms'],
            'treatment' => $_POST['treatment'],
            'entry_date' => date('Y-m-d'),
            'doctor_id' => $_SESSION['doctor_id']
        ]);
    }
    // Handle other form submissions...
}
?>

<!-- // Include the same header/sidebar as index.php // -->

<div class="col-md-10 p-4">
    <?php if (!$patientId): ?>
     <!-- Patient Search/Selection  -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Select Patient</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Search patients...">
                            <button class="btn btn-primary" type="button">
                                <i class="bi bi-search"></i> Search
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Patient ID</th>
                                <th>Name</th>
                                <th>DOB</th>
                                <th>Gender</th>
                                <th>Last Visit</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $patients = $ehr->getAllPatients();
                            foreach ($patients as $p) {
                                echo "<tr>
                                    <td>{$p['id']}</td>
                                    <td>{$p['first_name']} {$p['last_name']}</td>
                                    <td>".date('m/d/Y', strtotime($p['dob']))."</td>
                                    <td>{$p['gender']}</td>
                                    <td>".date('m/d/Y', strtotime($p['updated_at']))."</td>
                                    <td>
                                        <a href='ehr.php?patient_id={$p['id']}' class='btn btn-sm btn-primary'>
                                            <i class='bi bi-folder2-open'></i> Open EHR
                                        </a>
                                    </td>
                                </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php else: ?>
       <!-- //  Patient EHR Dashboard // -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3>Electronic Health Record</h3>
                <h4 class="text-primary"><?= "{$patient['first_name']} {$patient['last_name']}" ?></h4>
            </div>
            <div>
                <span class="badge bg-light text-dark me-2">DOB: <?= date('m/d/Y', strtotime($patient['dob'])) ?></span>
                <span class="badge bg-light text-dark me-2">Gender: <?= $patient['gender'] ?></span>
                <span class="badge bg-light text-dark">Blood Type: <?= $patient['blood_type'] ?? 'Unknown' ?></span>
            </div>
        </div>

        <div class="row">
         <!-- // Patient Summary // -->
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Patient Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <div class="position-relative d-inline-block">
                                <img src="https://via.placeholder.com/150" class="rounded-circle" width="100" height="100">
                                <span class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle p-2">
                                    <i class="bi bi-camera"></i>
                                </span>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <h6>Contact Information</h6>
                            <p>
                                <i class="bi bi-telephone me-2"></i> <?= $patient['phone'] ?? 'Not provided' ?><br>
                                <i class="bi bi-envelope me-2"></i> <?= $patient['email'] ?? 'Not provided' ?><br>
                                <i class="bi bi-geo-alt me-2"></i> <?= $patient['address'] ?? 'Not provided' ?>
                            </p>
                        </div>
                        
                        <div class="mb-3">
                            <h6>Emergency Contact</h6>
                            <p>
                                <?= $patient['emergency_contact_name'] ?? 'Not provided' ?><br>
                                <i class="bi bi-telephone me-2"></i> <?= $patient['emergency_contact_phone'] ?? 'Not provided' ?>
                            </p>
                        </div>
                        
                        <button class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#editPatientModal">
                            <i class="bi bi-pencil-square me-1"></i> Edit Patient Info
                        </button>
                    </div>
                </div>
                
               <!-- // Upcoming Appointments // -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Upcoming Appointments</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <?php
                            $patientAppointments = $appointments->getPatientAppointments($patientId, 3);
                            foreach ($patientAppointments as $appt) {
                                echo "<li class='list-group-item d-flex justify-content-between align-items-center'>
                                    <div>
                                        <h6 class='mb-1'>".date('M j, Y', strtotime($appt['appointment_date']))."</h6>
                                        <small class='text-muted'>".date('h:i A', strtotime($appt['appointment_date']))." - {$appt['reason']}</small>
                                    </div>
                                    <span class='badge bg-".($appt['status']=='scheduled'?'primary':'warning')."'>".ucfirst($appt['status'])."</span>
                                </li>";
                            }
                            ?>
                        </ul>
                        <a href="appointments.php" class="btn btn-sm btn-outline-primary mt-3 w-100">
                            View All Appointments
                        </a>
                    </div>
                </div>
            </div>
            
          <!-- // Medical Records // -->
            <div class="col-md-8">
                <ul class="nav nav-tabs" id="ehrTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="medical-history-tab" data-bs-toggle="tab" data-bs-target="#medical-history" type="button">
                            Medical History
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="lab-results-tab" data-bs-toggle="tab" data-bs-target="#lab-results" type="button">
                            Lab Results
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="prescriptions-tab" data-bs-toggle="tab" data-bs-target="#prescriptions" type="button">
                            Prescriptions
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="vitals-tab" data-bs-toggle="tab" data-bs-target="#vitals" type="button">
                            Vital Signs
                        </button>
                    </li>
                </ul>
                
                <div class="tab-content p-3 border border-top-0 rounded-bottom" id="ehrTabsContent">
                   <!-- // Medical History Tab // -->
                    <div class="tab-pane fade show active" id="medical-history" role="tabpanel">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5>Medical History</h5>
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addMedicalHistoryModal">
                                <i class="bi bi-plus-lg"></i> Add Entry
                            </button>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Diagnosis</th>
                                        <th>Treatment</th>
                                        <th>Doctor</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $medicalHistory = $ehr->getMedicalHistory($patientId);
                                    foreach ($medicalHistory as $entry) {
                                        echo "<tr>
                                            <td>".date('m/d/Y', strtotime($entry['entry_date']))."</td>
                                            <td>{$entry['diagnosis']}</td>
                                            <td>".substr($entry['treatment'], 0, 50)."...</td>
                                            <td>Dr. Smith</td>
                                            <td>
                                                <button class='btn btn-sm btn-outline-primary'>
                                                    <i class='bi bi-eye'></i>
                                                </button>
                                            </td>
                                        </tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                   <!-- //  Other tabs would go here... // -->
                </div>
            </div>
        </div>
        
     <!-- //  Add Medical History Modal //  -->
        <div class="modal fade" id="addMedicalHistoryModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Medical History Entry</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="POST">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Diagnosis</label>
                                <input type="text" class="form-control" name="diagnosis" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Symptoms</label>
                                <textarea class="form-control" name="symptoms" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Treatment</label>
                                <textarea class="form-control" name="treatment" rows="3" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" name="add_medical_history" class="btn btn-primary">Save Entry</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
     <!-- //  Edit Patient Modal // -->
        <div class="modal fade" id="editPatientModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Patient Information</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form>
                        <div class="modal-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">First Name</label>
                                    <input type="text" class="form-control" value="<?= $patient['first_name'] ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Last Name</label>
                                    <input type="text" class="form-control" value="<?= $patient['last_name'] ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Date of Birth</label>
                                    <input type="date" class="form-control" value="<?= $patient['dob'] ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Gender</label>
                                    <select class="form-select">
                                        <option <?= $patient['gender']=='Male'?'selected':'' ?>>Male</option>
                                        <option <?= $patient['gender']=='Female'?'selected':'' ?>>Female</option>
                                        <option <?= $patient['gender']=='Other'?'selected':'' ?>>Other</option>
                                    </select>
                                </div>
                            </div>
                           <!-- //  More fields would go here... //  -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div> 