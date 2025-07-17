

<?php
$conn = new mysqli("localhost", "root", "", "healthsync");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$doctor = null;

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM doctors WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    
    if ($row = mysqli_fetch_assoc($result)) {
        $doctor = $row;
    } else {
        $error = "Doctor not found.";
    }
} else {
    $error = "No doctor selected.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo ($doctor ? 'Dr. ' . $doctor['fullname'] . ' | HealthSync' : 'Doctor Profile'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-blue: #2563eb;
            --secondary-teal: #0d9488;
            --accent-coral: #f97316;
            --light-bg: #f8fafc;
            --text-dark: #1e293b;
            --text-light: #64748b;
            --white: #ffffff;
            --border-radius: 12px;
            --shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s ease;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-bg);
            color: var(--text-dark);
            line-height: 1.6;
        }
        
        .doctor-profile-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        
        .profile-card {
            background: var(--white);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            overflow: hidden;
        }
        
        .profile-header {
            background: linear-gradient(135deg, var(--primary-blue), var(--secondary-teal));
            color: var(--white);
            padding: 2rem;
            text-align: center;
        }
        
        .profile-image {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--white);
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
            background-color: var(--secondary-teal);
            color: var(--white);
            padding: 0.25rem 1rem;
            border-radius: 50px;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }
        
        .rating {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }
        
        .stars {
            color: var(--accent-coral);
            margin-right: 0.5rem;
        }
        
        .availability-badge {
            display: inline-flex;
            align-items: center;
            background-color: #dcfce7;
            color: #166534;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.9rem;
        }
        
        .availability-badge i {
            margin-right: 0.5rem;
        }
        
        .profile-content {
            padding: 2rem;
        }
        
        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--primary-blue);
            margin: 1.5rem 0 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--light-bg);
        }
        
        .detail-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .detail-card {
            background: var(--light-bg);
            border-radius: var(--border-radius);
            padding: 1.25rem;
            transition: var(--transition);
        }
        
        .detail-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow);
        }
        
        .detail-title {
            font-size: 0.8rem;
            text-transform: uppercase;
            color: var(--text-light);
            margin-bottom: 0.5rem;
            letter-spacing: 0.5px;
        }
        
        .detail-value {
            font-size: 1.1rem;
            font-weight: 500;
            color: var(--text-dark);
        }
        
        .detail-value i {
            margin-right: 0.5rem;
            color: var(--primary-blue);
        }
        
        .btn-appointment {
            background-color: var(--primary-blue);
            color: var(--white);
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            font-weight: 500;
            text-decoration: none;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            margin-right: 1rem;
            margin-bottom: 1rem;
        }
        
        .btn-appointment:hover {
            background-color: #1d4ed8;
            color: var(--white);
            transform: translateY(-2px);
        }
        
        .btn-appointment i {
            margin-right: 0.5rem;
        }
        
        .error-message {
            background-color: #fee2e2;
            color: #b91c1c;
            padding: 1.5rem;
            border-radius: var(--border-radius);
            text-align: center;
            margin: 2rem auto;
            max-width: 600px;
        }
        
        @media (max-width: 768px) {
            .doctor-name {
                font-size: 1.5rem;
            }
            
            .detail-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="doctor-profile-container">
        <?php if ($doctor): ?>
            <div class="profile-card">
                <div class="profile-header">
                    <?php if (!empty($doctor['photo'])): ?>
                        <img src="uploads/<?php echo $doctor['photo']; ?>" alt="Dr. <?php echo $doctor['fullname']; ?>" class="profile-image">
                    <?php else: ?>
                        <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($doctor['fullname']); ?>&background=random&size=200" alt="Dr. <?php echo $doctor['fullname']; ?>" class="profile-image">
                    <?php endif; ?>
                    
                    <h1 class="doctor-name">Dr. <?php echo $doctor['fullname']; ?></h1>
                    <span class="specialty-badge"><?php echo $doctor['specilaty']; ?></span>
                    
                    <div class="rating">
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <span>4.7 (128 reviews)</span>
                    </div>
                    
                    <div class="availability-badge">
                        <i class="fas fa-calendar-check"></i>
                        <?php echo $doctor['availability_days']; ?> • <?php echo $doctor['availability_time']; ?>
                    </div>
                </div>
                
                <div class="profile-content">
                    <h2 class="section-title">About Dr. <?php echo explode(' ', $doctor['fullname'])[0]; ?></h2>
                    <p>Board-certified <?php echo $doctor['specilaty']; ?> with <?php echo $doctor['experience']; ?> years of experience. Dr. <?php echo explode(' ', $doctor['fullname'])[0]; ?> specializes in providing comprehensive care with a patient-centered approach.</p>
                    
                    <div class="detail-grid">
                        <div class="detail-card">
                            <div class="detail-title">Contact Information</div>
                            <div class="detail-value"><i class="fas fa-envelope"></i> <?php echo $doctor['email']; ?></div>
                            <div class="detail-value"><i class="fas fa-phone"></i> <?php echo $doctor['phone']; ?></div>
                        </div>
                        
                        <div class="detail-card">
                            <div class="detail-title">Location</div>
                            <div class="detail-value"><i class="fas fa-map-marker-alt"></i> <?php echo $doctor['address']; ?></div>
                        </div>
                        
                        <div class="detail-card">
                            <div class="detail-title">Professional Details</div>
                            <div class="detail-value"><i class="fas fa-id-card"></i> License: <?php echo $doctor['license']; ?></div>
                            <div class="detail-value"><i class="fas fa-briefcase-medical"></i> <?php echo $doctor['experience']; ?> years experience</div>
                        </div>
                        
                        <div class="detail-card">
                            <div class="detail-title">Gender</div>
                            <div class="detail-value"><i class="fas fa-<?php echo strtolower($doctor['gender']) === 'male' ? 'male' : 'female'; ?>"></i> <?php echo ucfirst($doctor['gender']); ?></div>
                        </div>
                    </div>
                    
                    <h2 class="section-title">Book an Appointment</h2>
                    <p>Schedule your consultation with Dr. <?php echo explode(' ', $doctor['fullname'])[0]; ?> today.</p>
                    
                    <div class="d-flex flex-wrap">
                        <a href="appointment.php?doctor_id=<?php echo $doctor['id']; ?>" class="btn-appointment">
                            <i class="fas fa-calendar-plus"></i> Book Appointment
                        </a>
                        <a href="tel:<?php echo $doctor['phone']; ?>" class="btn-appointment" style="background-color: var(--secondary-teal);">
                            <i class="fas fa-phone"></i> Call Now
                        </a>
                        <a href="mailto:<?php echo $doctor['email']; ?>" class="btn-appointment" style="background-color: var(--accent-coral);">
                            <i class="fas fa-envelope"></i> Email
                        </a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="error-message">
                <i class="fas fa-exclamation-circle fa-2x mb-3"></i>
                <h3><?php echo $error; ?></h3>
                <p>Please return to our <a href="doctors.php">doctors directory</a> to select a healthcare provider.</p>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>