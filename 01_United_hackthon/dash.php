<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get user role from session
$user_role = $_SESSION['user_role'] ?? 'patient'; // Default to patient if not set
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HealthSync Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1e40af;
            --secondary: #0d9488;
            --accent: #dc2626;
            --light: #f8fafc;
            --dark: #1e293b;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f5f7fa;
        }
        
        .sidebar {
            background-color: var(--dark);
            color: white;
            height: 100vh;
            position: fixed;
            width: 250px;
            transition: all 0.3s;
        }
        
        .sidebar-header {
            padding: 20px;
            background-color: rgba(0,0,0,0.2);
        }
        
        .sidebar-menu {
            padding: 0;
            list-style: none;
        }
        
        .sidebar-menu li {
            padding: 10px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .sidebar-menu li a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .sidebar-menu li a:hover {
            color: white;
            padding-left: 5px;
        }
        
        .sidebar-menu li.active a {
            color: white;
            font-weight: 600;
        }
        
        .sidebar-menu li i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        .main-content {
            margin-left: 250px;
            padding: 20px;
            transition: all 0.3s;
        }
        
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: all 0.3s;
            margin-bottom: 20px;
            border: none;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .card-header {
            background-color: var(--primary);
            color: white;
            border-radius: 10px 10px 0 0 !important;
        }
        
        .user-profile-img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid white;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .badge {
            padding: 5px 10px;
            border-radius: 50px;
        }
        
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            font-size: 10px;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                margin-left: -250px;
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .sidebar.active {
                margin-left: 0;
            }
            
            .main-content.active {
                margin-left: 250px;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header text-center">
            <img src="assets/img/healthsync-logo-white.png" alt="HealthSync" height="40" class="mb-3">
            <h5>Welcome, <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'User'); ?></h5>
            <small class="text-muted"><?php echo ucfirst($user_role); ?></small>
        </div>
        
        <ul class="sidebar-menu">
            <li class="active">
                <a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
            </li>
            
            <?php if ($user_role === 'patient'): ?>
                <li>
                    <a href="appointments.php"><i class="fas fa-calendar-check"></i> My Appointments</a>
                </li>
                <li>
                    <a href="prescriptions.php"><i class="fas fa-prescription-bottle-alt"></i> Prescriptions</a>
                </li>
                <li>
                    <a href="medical-records.php"><i class="fas fa-file-medical"></i> Medical Records</a>
                </li>
                <li>
                    <a href="doctors.php"><i class="fas fa-user-md"></i> Find Doctors</a>
                </li>
                
            <?php elseif ($user_role === 'doctor'): ?>
                <li>
                    <a href="schedule.php"><i class="fas fa-calendar-alt"></i> My Schedule</a>
                </li>
                <li>
                    <a href="patients.php"><i class="fas fa-procedures"></i> My Patients</a>
                </li>
                <li>
                    <a href="e-prescribe.php"><i class="fas fa-prescription"></i> E-Prescribe</a>
                </li>
                <li>
                    <a href="telemedicine.php"><i class="fas fa-video"></i> Telemedicine</a>
                </li>
                
            <?php elseif ($user_role === 'admin'): ?>
                <li>
                    <a href="staff-management.php"><i class="fas fa-users"></i> Staff Management</a>
                </li>
                <li>
                    <a href="patient-records.php"><i class="fas fa-database"></i> Patient Records</a>
                </li>
                <li>
                    <a href="inventory.php"><i class="fas fa-warehouse"></i> Inventory</a>
                </li>
                <li>
                    <a href="reports.php"><i class="fas fa-chart-bar"></i> Reports</a>
                </li>
            <?php endif; ?>
            
            <li>
                <a href="profile.php"><i class="fas fa-user-cog"></i> Profile Settings</a>
            </li>
            <li>
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="main-content">
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm rounded mb-4">
            <div class="container-fluid">
                <button class="btn btn-primary d-lg-none" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
                
                <div class="d-flex align-items-center ms-auto">
                    <div class="dropdown me-3">
                        <a href="#" class="dropdown-toggle position-relative" id="notificationDropdown" data-bs-toggle="dropdown">
                            <i class="fas fa-bell fs-4"></i>
                            <span class="badge bg-danger notification-badge">3</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown">
                            <h6 class="dropdown-header">Notifications</h6>
                            <a class="dropdown-item" href="#">
                                <div class="d-flex align-items-center">
                                    <div class="me-3 bg-primary bg-opacity-10 p-2 rounded">
                                        <i class="fas fa-calendar-check text-primary"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted">10 min ago</small>
                                        <p class="mb-0">New appointment scheduled</p>
                                    </div>
                                </div>
                            </a>
                            <a class="dropdown-item" href="#">
                                <div class="d-flex align-items-center">
                                    <div class="me-3 bg-success bg-opacity-10 p-2 rounded">
                                        <i class="fas fa-prescription text-success"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted">1 hour ago</small>
                                        <p class="mb-0">New prescription available</p>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-center" href="#">View all notifications</a>
                        </div>
                    </div>
                    
                    <div class="dropdown">
                        <a href="#" class="dropdown-toggle d-flex align-items-center" id="profileDropdown" data-bs-toggle="dropdown">
                            <img src="assets/img/user-<?php echo $user_role; ?>.jpg" alt="User" class="rounded-circle me-2" width="40" height="40">
                            <span><?php echo htmlspecialchars($_SESSION['user_name'] ?? 'User'); ?></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="profile.php"><i class="fas fa-user me-2"></i> Profile</a>
                            <a class="dropdown-item" href="settings.php"><i class="fas fa-cog me-2"></i> Settings</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <div class="container-fluid">
            <!-- Dashboard Content Based on User Role -->
            <?php if ($user_role === 'patient'): ?>
                <!-- Patient Dashboard -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <img src="assets/img/user-patient.jpg" alt="Patient" class="user-profile-img mb-3">
                                <h4><?php echo htmlspecialchars($_SESSION['user_name']); ?></h4>
                                <span class="badge bg-primary">Patient</span>
                                <div class="mt-3">
                                    <p class="mb-1"><i class="fas fa-birthday-cake me-2"></i> Age: 32</p>
                                    <p class="mb-1"><i class="fas fa-heartbeat me-2"></i> Blood Type: O+</p>
                                    <p class="mb-1"><i class="fas fa-allergies me-2"></i> Allergies: Penicillin</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Upcoming Appointments</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Doctor</th>
                                                <th>Specialty</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Today, 3:00 PM</td>
                                                <td>Dr. Priya Patel</td>
                                                <td>Cardiology</td>
                                                <td><span class="badge bg-success">Confirmed</span></td>
                                                <td><a href="#" class="btn btn-sm btn-primary">Join</a></td>
                                            </tr>
                                            <tr>
                                                <td>Tomorrow, 11:00 AM</td>
                                                <td>Dr. Amit Sharma</td>
                                                <td>General Physician</td>
                                                <td><span class="badge bg-warning text-dark">Pending</span></td>
                                                <td><a href="#" class="btn btn-sm btn-outline-secondary">Reschedule</a></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Recent Prescriptions</h5>
                            </div>
                            <div class="card-body">
                                <div class="list-group">
                                    <a href="#" class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">Metformin 500mg</h6>
                                            <small>3 days ago</small>
                                        </div>
                                        <p class="mb-1">Take 1 tablet twice daily with meals</p>
                                        <small>Dr. Priya Patel</small>
                                    </a>
                                    <a href="#" class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">Atorvastatin 20mg</h6>
                                            <small>1 week ago</small>
                                        </div>
                                        <p class="mb-1">Take 1 tablet at bedtime</p>
                                        <small>Dr. Amit Sharma</small>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Health Summary</h5>
                            </div>
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-4">
                                        <h3 class="text-primary">72</h3>
                                        <small class="text-muted">Resting BPM</small>
                                    </div>
                                    <div class="col-4">
                                        <h3 class="text-success">120/80</h3>
                                        <small class="text-muted">Blood Pressure</small>
                                    </div>
                                    <div class="col-4">
                                        <h3 class="text-secondary">98.6°F</h3>
                                        <small class="text-muted">Temperature</small>
                                    </div>
                                </div>
                                <hr>
                                <div class="text-center">
                                    <a href="#" class="btn btn-outline-primary me-2">View Full Report</a>
                                    <a href="#" class="btn btn-primary">Share with Doctor</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <?php elseif ($user_role === 'doctor'): ?>
                <!-- Doctor Dashboard -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <img src="assets/img/user-doctor.jpg" alt="Doctor" class="user-profile-img mb-3">
                                <h4>Dr. <?php echo htmlspecialchars($_SESSION['user_name']); ?></h4>
                                <span class="badge bg-success">Cardiologist</span>
                                <div class="mt-3">
                                    <p class="mb-1"><i class="fas fa-hospital me-2"></i> Apollo Hospital</p>
                                    <p class="mb-1"><i class="fas fa-graduation-cap me-2"></i> MD, Cardiology</p>
                                    <p class="mb-1"><i class="fas fa-star me-2"></i> 4.8 (120 reviews)</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card mt-4">
                            <div class="card-header">
                                <h5 class="mb-0">Today's Schedule</h5>
                            </div>
                            <div class="card-body">
                                <div class="list-group">
                                    <a href="#" class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">9:00 AM</h6>
                                            <span class="badge bg-success">Confirmed</span>
                                        </div>
                                        <p class="mb-1">Rahul Sharma</p>
                                        <small>Follow-up consultation</small>
                                    </a>
                                    <a href="#" class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">11:30 AM</h6>
                                            <span class="badge bg-success">Confirmed</span>
                                        </div>
                                        <p class="mb-1">Priya Patel</p>
                                        <small>New patient</small>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Patient Queue</h5>
                                <a href="#" class="btn btn-sm btn-primary">Start Telemedicine</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Patient</th>
                                                <th>Appointment Time</th>
                                                <th>Reason</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Rahul Sharma</td>
                                                <td>9:00 AM (Now)</td>
                                                <td>Follow-up</td>
                                                <td><span class="badge bg-success">Waiting</span></td>
                                                <td><a href="#" class="btn btn-sm btn-primary">Start</a></td>
                                            </tr>
                                            <tr>
                                                <td>Priya Patel</td>
                                                <td>11:30 AM</td>
                                                <td>Initial Consultation</td>
                                                <td><span class="badge bg-secondary">Scheduled</span></td>
                                                <td><a href="#" class="btn btn-sm btn-outline-secondary">Details</a></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card mt-4">
                            <div class="card-header">
                                <h5 class="mb-0">Quick Actions</h5>
                            </div>
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-md-3 mb-3">
                                        <a href="e-prescribe.php" class="btn btn-outline-primary w-100 py-3">
                                            <i class="fas fa-prescription fa-2x mb-2"></i><br>
                                            E-Prescribe
                                        </a>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <a href="patients.php" class="btn btn-outline-success w-100 py-3">
                                            <i class="fas fa-procedures fa-2x mb-2"></i><br>
                                            Patients
                                        </a>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <a href="medical-records.php" class="btn btn-outline-info w-100 py-3">
                                            <i class="fas fa-file-medical fa-2x mb-2"></i><br>
                                            Records
                                        </a>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <a href="telemedicine.php" class="btn btn-outline-danger w-100 py-3">
                                            <i class="fas fa-video fa-2x mb-2"></i><br>
                                            Telemedicine
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <?php elseif ($user_role === 'admin'): ?>
                <!-- Hospital Admin Dashboard -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-4">
                                    <img src="assets/img/user-admin.jpg" alt="Admin" class="rounded-circle me-3" width="80" height="80">
                                    <div>
                                        <h4><?php echo htmlspecialchars($_SESSION['user_name']); ?></h4>
                                        <p class="mb-0"><i class="fas fa-hospital me-2"></i> Apollo Hospital, Mumbai</p>
                                    </div>
                                </div>
                                
                                <div class="row text-center mb-4">
                                    <div class="col-md-3">
                                        <div class="card bg-primary bg-opacity-10">
                                            <div class="card-body">
                                                <h2 class="text-primary">142</h2>
                                                <p class="mb-0">Today's Appointments</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card bg-success bg-opacity-10">
                                            <div class="card-body">
                                                <h2 class="text-success">28</h2>
                                                <p class="mb-0">Admitted Patients</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card bg-warning bg-opacity-10">
                                            <div class="card-body">
                                                <h2 class="text-warning">15</h2>
                                                <p class="mb-0">Available Doctors</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card bg-danger bg-opacity-10">
                                            <div class="card-body">
                                                <h2 class="text-danger">7</h2>
                                                <p class="mb-0">Critical Alerts</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="mb-0">Recent Admissions</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>Patient</th>
                                                                <th>Doctor</th>
                                                                <th>Ward</th>
                                                                <th>Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>Rahul Sharma</td>
                                                                <td>Dr. Priya Patel</td>
                                                                <td>Cardiology</td>
                                                                <td><span class="badge bg-warning text-dark">Stable</span></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Priya Desai</td>
                                                                <td>Dr. Amit Sharma</td>
                                                                <td>General</td>
                                                                <td><span class="badge bg-success">Recovering</span></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="mb-0">Quick Actions</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row text-center">
                                                    <div class="col-6 mb-3">
                                                        <a href="staff-management.php" class="btn btn-outline-primary w-100 py-3">
                                                            <i class="fas fa-users fa-2x mb-2"></i><br>
                                                            Staff
                                                        </a>
                                                    </div>
                                                    <div class="col-6 mb-3">
                                                        <a href="inventory.php" class="btn btn-outline-success w-100 py-3">
                                                            <i class="fas fa-warehouse fa-2x mb-2"></i><br>
                                                            Inventory
                                                        </a>
                                                    </div>
                                                    <div class="col-6 mb-3">
                                                        <a href="billing.php" class="btn btn-outline-info w-100 py-3">
                                                            <i class="fas fa-file-invoice-dollar fa-2x mb-2"></i><br>
                                                            Billing
                                                        </a>
                                                    </div>
                                                    <div class="col-6 mb-3">
                                                        <a href="reports.php" class="btn btn-outline-danger w-100 py-3">
                                                            <i class="fas fa-chart-bar fa-2x mb-2"></i><br>
                                                            Reports
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script>
        // Toggle sidebar on mobile
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('main-content').classList.toggle('active');
        });
        
        // Auto-close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            
            if (window.innerWidth <= 768 && 
                !sidebar.contains(event.target) && 
                !sidebarToggle.contains(event.target) && 
                sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
                document.getElementById('main-content').classList.remove('active');
            }
        });
    </script>
</body>
</html>