<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Digital Health</title>
    <link rel="icon" href="img/HealthSync.png" type="image/png">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/dashboard.css">
   
</head>
<body>
    <!-- Header/Navbar -->
    <?php include 'includes/header.php'; ?>
    <!-- Header/Navbar End -->

    <!-- Dashboard Content -->
    <section class="dashboard-section py-5">
        <div class="container">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-lg-3 mb-4">
                    <div class="sidebar card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-user-circle me-2"></i>Admin Panel</h5>
                            <ul class="list-unstyled">
                                <li class="mb-3"><a href="admin_login.php" class="active"><i class="fas fa-tachometer-alt me-2"></i>Admin</a></li>
                                <!-- <li class="mb-3"><a href="admin/appointments.php"><i class="fas fa-calendar-check me-2"></i>Appointments</a></li> 
                                <li class="mb-3"><a href="admin.php"><i class="fas fa-users me-2"></i>Patients</a></li>
                                <li class="mb-3"><a href="admin/admin.php"><i class="fas fa-user-md me-2"></i>Doctors</a></li>
                                <li class="mb-3"><a href="admin/reports.php"><i class="fas fa-file-medical me-2"></i>Reports</a></li> -->
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="col-lg-9">
                    <h2 class="mb-4">Healthcare Dashboard</h2>

                    <!-- Stats Cards -->
                    <div class="row mb-4">
                        <div class="col-md-4 mb-3">
                            <div class="card stat-card shadow-sm">
                                <div class="card-body">
                                    <h5><i class="fas fa-calendar-check me-2"></i>Appointments</h5>
                                    <p class="display-6">24</p>
                                    <small class="text-success">+10% from last week</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card stat-card shadow-sm">
                                <div class="card-body">
                                    <h5><i class="fas fa-users me-2"></i>Patients</h5>
                                    <p class="display-6">1,245</p>
                                    <small class="text-success">+5% from last month</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card stat-card shadow-sm">
                                <div class="card-body">
                                    <h5><i class="fas fa-hospital me-2"></i>Admissions</h5>
                                    <p class="display-6">12</p>
                                    <small class="text-danger">-2% from last week</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Charts -->
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <h5>Patient Visits (Monthly)</h5>
                                    <canvas id="patientVisitsChart"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <h5>Appointment Status</h5>
                                    <canvas id="appointmentStatusChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Patients -->
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5>Recent Patients</h5>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>ID</th>
                                            <th>Last Visit</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Anil Sharma</td>
                                            <td>PAT001</td>
                                            <td>2025-04-15</td>
                                            <td><span class="badge bg-success">Stable</span></td>
                                            <td><a href="#" class="btn btn-sm btn-primary">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>Priya Patel</td>
                                            <td>PAT002</td>
                                            <td>2025-04-14</td>
                                            <td><span class="badge bg-warning">Follow-up</span></td>
                                            <td><a href="#" class="btn btn-sm btn-primary">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>Neha Gupta</td>
                                            <td>PAT003</td>
                                            <td>2025-04-13</td>
                                            <td><span class="badge bg-success">Stable</span></td>
                                            <td><a href="#" class="btn btn-sm btn-primary">View</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
   <?php include 'includes/footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Chart.js Scripts -->
    <script>
        // Patient Visits Chart (Line Chart)
        const patientVisitsChart = document.getElementById('patientVisitsChart').getContext('2d');
        new Chart(patientVisitsChart, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Patient Visits',
                    data: [120, 150, 180, 200, 170, 210],
                    borderColor: '#4A90E2',
                    backgroundColor: 'rgba(74, 144, 226, 0.2)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Appointment Status Chart (Doughnut Chart)
        const appointmentStatusChart = document.getElementById('appointmentStatusChart').getContext('2d');
        new Chart(appointmentStatusChart, {
            type: 'doughnut',
            data: {
                labels: ['Completed', 'Pending', 'Cancelled'],
                datasets: [{
                    data: [60, 30, 10],
                    backgroundColor: ['#50C878', '#FFD700', '#FF6F61']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>

<?php include 'includes/chatbot.php'; ?>
</body>
</html> 