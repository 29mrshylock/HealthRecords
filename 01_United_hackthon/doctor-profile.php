<?php
$conn = new mysqli("localhost", "root", "", "healthsync");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$doctor = null;

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM doctors WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        $doctor = $row;
    } else {
        $error = "Doctor not found.";
    }
    $stmt->close();
} else {
    $error = "No doctor selected.";
}
$conn->close();


session_start();

if (!isset($_SESSION['doctor_id']) && !isset($_GET['id'])) {
    header('Location: login.php');
    exit();
}

$doctor_id = isset($_GET['id']) ? $_GET['id'] : $_SESSION['doctor_id'];

// Database connection and fetch doctor data
$conn = new mysqli('localhost', 'root', '', 'healthsync');
$sql = "SELECT * FROM doctors WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$result = $stmt->get_result();
$doctor = $result->fetch_assoc();
$stmt->close();
$conn->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo ($doctor ? 'Dr. ' . $doctor['fullname'] . ' | Digital Health' : 'Doctor Profile'); ?></title>
    <link rel="icon" href="img/HealthSync.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/header-footer.css">
    <style>
        :root {
            --primary-blue: #4A90E2;
            --secondary-green: #50C878;
            --accent-coral: #FF6F61;
            --neutral-gray: #F7F9FC;
            --highlight-gold: #FFD700;
            --text-dark: #2D3748;
            --bg-white: #FFFFFF;
            --shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            --glow: 0 0 8px rgba(74, 144, 226, 0.5);
            --transition: all 0.3s ease;
            --border-radius: 12px;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--neutral-gray);
            color: var(--text-dark);
            line-height: 1.6;
        }
        
        .doctor-profile-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        
        .profile-card {
            background: var(--bg-white);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            overflow: hidden;
        }
        
        .profile-header {
            background: linear-gradient(135deg, var(--primary-blue), var(--secondary-green));
            color: var(--bg-white);
            padding: 3rem 2rem;
            text-align: center;
            position: relative;
        }
        
        .profile-image {
            width: 340px;
            height: 340px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--bg-white);
            margin: 0 auto 1rem;
            box-shadow: var(--shadow);
        }
        
        .doctor-name {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .specialty-badge {
            display: inline-block;
            background-color: var(--secondary-green);
            color: var(--bg-white);
            padding: 0.5rem 1.5rem;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        
        .rating-badge {
            background: var(--highlight-gold);
            color: var(--text-dark);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            margin-bottom: 1rem;
        }
        
        .rating-badge i {
            margin-right: 5px;
        }
        
        .availability-badge {
            display: inline-flex;
            align-items: center;
            background-color: rgba(80, 200, 120, 0.2);
            color: #166534;
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            font-size: 0.95rem;
            font-weight: 500;
        }
        
        .availability-badge i {
            margin-right: 0.75rem;
        }
        
        .profile-content {
            padding: 2.5rem;
        }
        
        .section-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary-blue);
            margin: 2rem 0 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid var(--neutral-gray);
        }
        
        .detail-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.75rem;
            margin-bottom: 2.5rem;
        }
        
        .detail-card {
            background: var(--neutral-gray);
            border-radius: var(--border-radius);
            padding: 1.5rem;
            transition: var(--transition);
        }
        
        .detail-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow);
        }
        
        .detail-title {
            font-size: 0.85rem;
            text-transform: uppercase;
            color: var(--text-dark);
            margin-bottom: 0.75rem;
            letter-spacing: 0.5px;
            font-weight: 600;
        }
        
        .detail-value {
            font-size: 1.1rem;
            font-weight: 500;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }
        
        .detail-value i {
            margin-right: 0.75rem;
            color: var(--primary-blue);
            width: 20px;
            text-align: center;
        }
        
        .btn-appointment {
            background-color: var(--primary-blue);
            color: var(--bg-white);
            padding: 0.75rem 1.75rem;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            margin-right: 1rem;
            margin-bottom: 1rem;
            border: none;
        }
        
        .btn-appointment:hover {
            background-color: #3a78c2;
            color: var(--bg-white);
            transform: translateY(-2px);
            box-shadow: var(--glow);
        }
        
        .btn-appointment i {
            margin-right: 0.75rem;
            transition: transform 0.3s ease;
        }
        
        .btn-appointment:hover i {
            transform: translateX(3px);
        }
        
        .error-message {
            background-color: #fee2e2;
            color: #b91c1c;
            padding: 2rem;
            border-radius: var(--border-radius);
            text-align: center;
            margin: 3rem auto;
            max-width: 600px;
        }
        
        .error-message i {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: #b91c1c;
        }
        
        @media (max-width: 768px) {
            .profile-header {
                padding: 2rem 1rem;
            }
            
            .profile-image {
                width: 150px;
                height: 150px;
            }
            
            .doctor-name {
                font-size: 1.75rem;
            }
            
            .detail-grid {
                grid-template-columns: 1fr;
            }
            
            .btn-appointment {
                width: 100%;
                margin-right: 0;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <!-- Header/Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top digital-health-header">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-heartbeat me-2"></i>HealthSync
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="dashbord.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="doctors.php">Doctors</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact</a>
                    </li>
                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-outline-light" href="login.php">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="doctor-profile-container">
        <?php if ($doctor): ?>
            <div class="profile-card">
                <div class="profile-header">
                    <?php if (!empty($doctor['photo'])): ?>
                        <img src="<?php echo htmlspecialchars($doctor['photo']); ?>" alt="Dr. <?php echo htmlspecialchars($doctor['fullname']); ?>" class="profile-image">
                    <?php else: ?>
                        <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($doctor['fullname']); ?>&background=random&size=200" alt="Dr. <?php echo htmlspecialchars($doctor['fullname']); ?>" class="profile-image">
                    <?php endif; ?>
                    
                    <h1 class="doctor-name">Dr. <?php echo htmlspecialchars($doctor['fullname']); ?></h1>
                    <span class="specialty-badge"><?php echo htmlspecialchars($doctor['specilaty']); ?></span>
                    
                    <div class="rating-badge">
                        <i class="fas fa-star"></i> 4.7 (128 reviews)
                    </div>
                    
                    <div class="availability-badge">
                        <i class="fas fa-calendar-check"></i>
                        <?php echo htmlspecialchars($doctor['availability_days']); ?> • <?php echo htmlspecialchars($doctor['availability_time']); ?>
                    </div>
                </div>
                
                <div class="profile-content">
                    <h2 class="section-title">About Dr. <?php echo htmlspecialchars(explode(' ', $doctor['fullname'])[0]); ?></h2>
                    <p class="mb-4">Board-certified <?php echo htmlspecialchars($doctor['specilaty']); ?> with <?php echo htmlspecialchars($doctor['experience']); ?> years of experience. Dr. <?php echo htmlspecialchars(explode(' ', $doctor['fullname'])[0]); ?> specializes in providing comprehensive care with a patient-centered approach.</p>
                    
                    <div class="detail-grid">
                        <div class="detail-card">
                            <div class="detail-title">Contact Information</div>
                            <div class="detail-value"><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($doctor['email']); ?></div>
                            <div class="detail-value"><i class="fas fa-phone"></i> <?php echo htmlspecialchars($doctor['phone']); ?></div>
                        </div>
                        
                        <div class="detail-card">
                            <div class="detail-title">Location</div>
                            <div class="detail-value"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($doctor['address']); ?></div>
                        </div>
                        
                        <div class="detail-card">
                            <div class="detail-title">Professional Details</div>
                            <div class="detail-value"><i class="fas fa-id-card"></i> License: <?php echo htmlspecialchars($doctor['license']); ?></div>
                            <div class="detail-value"><i class="fas fa-briefcase"></i> <?php echo htmlspecialchars($doctor['experience']); ?> years experience</div>
                        </div>
                        
                        <div class="detail-card">
                            <div class="detail-title">Gender</div>
                            <div class="detail-value"><i class="fas fa-<?php echo strtolower($doctor['gender']) === 'male' ? 'male' : 'female'; ?>"></i> <?php echo ucfirst(htmlspecialchars($doctor['gender'])); ?></div>
                        </div>
                    </div>
                    
                    <h2 class="section-title">Book an Appointment</h2>
                    <p class="mb-4">Schedule your consultation with Dr. <?php echo htmlspecialchars(explode(' ', $doctor['fullname'])[0]); ?> today.</p>
                    
                    <div class="d-flex flex-wrap">
                    <a href="appointments.php?doctor=<?= urlencode($row['fullname']) ?>" class="btn btn-appointment" style="background-color: var(--primary-blue);">Book Appointment</a>
                        <a href="tel:<?php echo htmlspecialchars($doctor['phone']); ?>" class="btn btn-appointment" style="background-color: var(--secondary-green);">
                            <i class="fas fa-phone"></i> Call Now
                        </a>
                        <a href="mailto:<?php echo htmlspecialchars($doctor['email']); ?>" class="btn btn-appointment" style="background-color: var(--accent-coral);">
                            <i class="fas fa-envelope"></i> Email
                        </a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="error-message">
                <i class="fas fa-exclamation-circle"></i>
                <h3><?php echo htmlspecialchars($error); ?></h3>
                <p class="mt-3">Please return to our <a href="doctors.php" class="text-danger">doctors directory</a> to select a healthcare provider.</p>
            </div>
        <?php endif; ?>
    </div>
    <?php include 'includes/chatbot.php'; ?>

    <!-- Footer -->
    <footer class="digital-health-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5><i class="fas fa-heartbeat me-2"></i>Digital Health</h5>
                    <p>Revolutionizing healthcare through technology and innovation for better patient outcomes.</p>
                    <div class="social-links mt-3">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="index.php">Home</a></li>
                        <li class="mb-2"><a href="about.php">About Us</a></li>
                        <li class="mb-2"><a href="#">Services</a></li>
                        <li class="mb-2"><a href="pricing.php">Pricing</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5>Services</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#">EHR</a></li>
                        <li class="mb-2"><a href="#">Telemedicine</a></li>
                        <li class="mb-2"><a href="#">Appointments</a></li>
                        <li class="mb-2"><a href="#">Analytics</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 mb-4">
                    <h5>Contact Us</h5>
                    <p><i class="fas fa-map-marker-alt me-2"></i> 123 Health St, Medical City</p>
                    <p><i class="fas fa-phone me-2"></i> +91 9876543210</p>
                    <p><i class="fas fa-envelope me-2"></i> info@digitalhealth.com</p>
                </div>
            </div>
            <hr class="my-4 footer-divider">
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <p class="small mb-0">© 2025 Digital Health. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <p class="small mb-0">
                        <a href="#">Privacy Policy</a> |
                        <a href="#">Terms of Service</a>
                    </p>
                </div>
            </div>
        </div>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>