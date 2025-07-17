<?php
$conn = new mysqli("localhost", "root", "", "healthsync");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$doctors = [];
$sql = "SELECT * FROM doctors LIMIT 6"; // Fetch first 6 doctors for the slider
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $doctors[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Digital Health - Smart Records System for secure and efficient healthcare management.">
    <meta name="keywords" content="healthcare, medical records, digital health, patient portal">
    <meta name="robots" content="index, follow">
    <title>HealthSync - Smart Records System</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/header-footer.css">
    <link rel="icon" href="img/HealthSync.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css">
    <style>
        :root {
            --primary-blue: #4A90E2;
            --secondary-green: #50C878;
            --accent-coral: #FF6F61;
            --neutral-gray: #F7F9FC;
            --text-dark: #2D3748;
            --bg-white: #FFFFFF;
            --shadow-sm: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        .section-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .section-header h2 {
            font-size: 2.5rem;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        .section-header p {
            font-size: 1.1rem;
            color: var(--text-dark);
            opacity: 0.8;
        }

        .button {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .button.primary {
            background: var(--primary-blue);
            color: var(--bg-white);
            border: none;
        }

        .button.primary:hover {
            background: #3a7bc8;
        }

        .button.secondary {
            background: var(--bg-white);
            color: var(--primary-blue);
            border: 1px solid var(--primary-blue);
        }

        .button.secondary:hover {
            background: var(--primary-blue);
            color: var(--bg-white);
        }

        .doctors {
            padding: 4rem 0;
            background: var(--neutral-gray);
        }

        .doctors .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            text-align: left;
        }

        .doctors-slider {
            margin-top: 20px;
        }

        .doctor-card {
            background: var(--bg-white);
            padding: 15px;
            border-radius: 10px;
            box-shadow: var(--shadow-sm);
            margin: 0 10px;
            text-align: center;
        }

        .doctor-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .card-content h4 {
            font-size: 1.2rem;
            margin: 0 0 5px;
            color: var(--text-dark);
        }

        .card-content .specialty {
            font-size: 0.9rem;
            color: var(--primary-blue);
            margin: 0 0 10px;
        }

        .card-content p {
            font-size: 0.85rem;
            color: var(--text-dark);
            margin: 0 0 15px;
        }

        .button-group {
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .slick-prev,
        .slick-next {
            font-size: 0;
            line-height: 0;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            display: block;
            width: 40px;
            height: 40px;
            padding: 0;
            cursor: pointer;
            color: #fff;
            background: rgba(0, 0, 0, 0.5);
            border: none;
            border-radius: 50%;
            z-index: 1;
        }

        .slick-prev:before,
        .slick-next:before {
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            font-size: 20px;
            color: #fff;
        }

        .slick-prev:before {
            content: '\f053';
        }

        .slick-next:before {
            content: '\f054';
        }

        .slick-prev {
            left: -50px;
        }

        .slick-next {
            right: -50px;
        }

        .slick-prev:focus,
        .slick-next:focus {
            outline: 2px solid var(--primary-blue);
            outline-offset: 2px;
        }

        .slick-dots {
            text-align: center;
            margin-top: 20px;
        }

        .slick-dots li {
            display: inline-block;
            margin: 0 5px;
        }

        .slick-dots li button {
            font-size: 0;
            width: 12px;
            height: 12px;
            background: #ccc;
            border: none;
            border-radius: 50%;
            cursor: pointer;
        }

        .slick-dots li.slick-active button {
            background: var(--primary-blue);
        }

        @media (max-width: 1200px) {
            .slick-prev {
                left: -30px;
            }

            .slick-next {
                right: -30px;
            }
        }

        @media (max-width: 768px) {
            .doctors .section-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .doctors .section-header a {
                align-self: flex-end;
            }

            .slick-prev {
                left: 10px;
            }

            .slick-next {
                right: 10px;
            }
        }

        /* Profile Container Styles */
        #profile-container {
            display: none;
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background: var(--bg-white);
            border-radius: 10px;
            box-shadow: var(--shadow-sm);
            text-align: center;
        }

        .profile-card img {
            width: 150px;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        .profile-card h2 {
            font-size: 1.5rem;
            color: var(--text-dark);
            margin-bottom: 10px;
        }

        .profile-card p {
            font-size: 1rem;
            color: var(--text-dark);
            margin: 5px 0;
        }
    </style>
</head>

<body>
    <!-- Header Section -->

    <?php include 'includes/header.php'; ?>

    <!-- Hero Slider (Bootstrap) -->
    <div id="mainSlider" class="carousel slide hero-slider" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#mainSlider" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#mainSlider" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#mainSlider" data-bs-slide-to="2"></button>
            <button type="button" data-bs-target="#mainSlider" data-bs-slide-to="3"></button>
            <button type="button" data-bs-target="#mainSlider" data-bs-slide-to="4"></button>
            <button type="button" data-bs-target="#mainSlider" data-bs-slide-to="5"></button>
            <button type="button" data-bs-target="#mainSlider" data-bs-slide-to="6"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://images.unsplash.com/photo-1579684385127-1ef15d508118" class="d-block w-100"
                    alt="Modern hospital facility" loading="lazy">
            </div>
            <div class="carousel-item">
                <img src="https://images.unsplash.com/photo-1576091160550-2173dba999ef" class="d-block w-100"
                    alt="Doctor reviewing patient records" loading="lazy">
            </div>
            <div class="carousel-item">
                <img src="https://images.unsplash.com/photo-1581056771107-24ca5f033842" class="d-block w-100"
                    alt="Medical professional using digital platform" loading="lazy">
            </div>
            <div class="carousel-item">
                <img src="https://img.freepik.com/free-vector/smart-healthcare-technology-template_53876-117499.jpg?t=st=1745503618~exp=1745507218~hmac=9a3cb8c5fc491f1a605b28e094251db5fa4970607dcff47cec52ca7e3dedf5f2&w=996"
                    class="d-block w-100" alt="Doctor reviewing patient records" loading="lazy">
            </div>
            <div class="carousel-item">
                <img src="https://i.pinimg.com/736x/19/96/35/19963532f6b72ffeeb7b58f1226058ca.jpg" class="d-block w-100"
                    alt="Doctor reviewing patient records" loading="lazy">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#mainSlider" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#mainSlider" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <!-- Trust Indicators -->
    <section class="trust-indicators">
        <div class="scroll-container">
            <div class="scroll-track">
                <div class="trust-item">
                    <i class="fas fa-shield-alt"></i>
                    <div>
                        <div>HIPAA Compliant</div>
                        <small>100% Secure</small>
                    </div>
                </div>
                <div class="trust-item">
                    <i class="fas fa-hospital"></i>
                    <div>
                        <div>500+ Hospitals</div>
                        <small>Trusted Partner</small>
                    </div>
                </div>
                <div class="trust-item">
                    <i class="fas fa-headset"></i>
                    <div>
                        <div>24/7 Support</div>
                        <small>Always Available</small>
                    </div>
                </div>
                <div class="trust-item">
                    <i class="fas fa-plug"></i>
                    <div>
                        <div>EHR Integration</div>
                        <small>Seamless Connection</small>
                    </div>
                </div>
                <div class="trust-item">
                    <i class="fas fa-shield-alt"></i>
                    <div>
                        <div>HIPAA Compliant</div>
                        <small>100% Secure</small>
                    </div>
                </div>
                <div class="trust-item">
                    <i class="fas fa-hospital"></i>
                    <div>
                        <div>500+ Hospitals</div>
                        <small>Trusted Partner</small>
                    </div>
                </div>
                <div class="trust-item">
                    <i class="fas fa-headset"></i>
                    <div>
                        <div>24/7 Support</div>
                        <small>Always Available</small>
                    </div>
                </div>
                <div class="trust-item">
                    <i class="fas fa-plug"></i>
                    <div>
                        <div>EHR Integration</div>
                        <small>Seamless Connection</small>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Revolutionizing Health Records -->
    <section class="health-records">
        <div class="container">
            <div class="content-wrapper">
                <div class="image-container">
                    <img src="https://images.unsplash.com/photo-1588776814546-1ffcf47267a5"
                        alt="Health Dashboard interface" loading="lazy">
                </div>
                <div class="text-content">
                    <h2>Revolutionizing Health Records Management</h2>
                    <p>Our web-based platform transforms how healthcare providers and patients interact with medical
                        data, creating a seamless, secure, and efficient experience.</p>
                    <div class="features">
                        <div class="feature-item">
                            <div class="feature-icon"><i class="fas fa-bolt"></i></div>
                            <div>
                                <h4>Instant Access</h4>
                                <p>Retrieve test results and records in seconds through our secure portal</p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon"><i class="fas fa-comments"></i></div>
                            <div>
                                <h4>Secure Messaging</h4>
                                <p>Direct communication with your care team through encrypted messages</p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon"><i class="fas fa-pills"></i></div>
                            <div>
                                <h4>Medication Tracking</h4>
                                <p>View and manage your prescriptions and medications</p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon"><i class="fas fa-users"></i></div>
                            <div>
                                <h4>Family Health</h4>
                                <p>Track health history for your entire family with one account</p>
                            </div>
                        </div>
                    </div>
                    <div class="button-group">
                        <a href="login.php" class="button primary">Explore Features</a>
                        <a href="login.php" class="button secondary">Watch Demo</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Platform Benefits -->
    <section class="platform-benefits">
        <div class="container">
            <div class="content-wrapper reverse">
                <div class="image-container">
                    <img src="https://www.appletechsoft.com/wp-content/uploads/2020/06/Hospital-Management-System.jpg"
                        alt="Web Interface for health management" loading="lazy">
                </div>
                <div class="text-content">
                    <h2>Comprehensive Health Management Platform</h2>
                    <p>We provide more than just record storage - our web system offers complete health management tools
                        for patients and providers alike.</p>
                    <div class="benefits-list">
                        <div class="benefit-item">
                            <h3><i class="fas fa-chart-line"></i> Advanced Analytics</h3>
                            <p>Our analytics dashboard provides personalized health insights, trend analysis, and
                                predictive health indicators to help you stay ahead of potential issues.</p>
                        </div>
                        <div class="benefit-item">
                            <h3><i class="fas fa-sync-alt"></i> Real-time Updates</h3>
                            <p>All your health data updates in real-time as providers add new information, ensuring you
                                always have the latest records.</p>
                        </div>
                        <div class="benefit-item">
                            <h3><i class="fas fa-user-shield"></i> Permission Controls</h3>
                            <p>Granular privacy controls let you decide exactly which providers can see which parts of
                                your health history.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Key Features -->
    <section class="key-features">
        <div class="container">
            <div class="section-header">
                <h2>Powerful Features for Better Healthcare</h2>
                <p>Discover how our platform can transform your healthcare experience</p>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-lock"></i></div>
                    <h4>Military-Grade Security</h4>
                    <p>End-to-end encryption, multi-factor authentication, and regular security audits ensure your data
                        remains protected.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-desktop"></i></div>
                    <h4>Responsive Web Access</h4>
                    <p>Access your records from any device with our responsive web interface that works on all browsers.
                    </p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-share-alt"></i></div>
                    <h4>Controlled Sharing</h4>
                    <p>Securely share records with providers or family members with customizable permission levels.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-chart-line"></i></div>
                    <h4>Health Analytics</h4>
                    <p>Visualize trends, track progress, and receive personalized health recommendations.</p>
                </div>
            </div>
            <div class="section-footer">
                <a href="login.php" class="button primary">View All Features</a>
            </div>
        </div>
    </section>

    <!-- Platform Demo -->
    <section class="platform-demo">
        <div class="container">
            <div class="section-header">
                <h2>See Our Platform in Action</h2>
                <p>Explore the intuitive web interface designed for both patients and providers</p>
            </div>
            <div class="demo-slider">
                <div class="demo-slide">
                    <div class="slide-content">
                        <div class="image-container">
                            <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71"
                                alt="Patient Health Portal interface" loading="lazy">
                        </div>
                        <div class="text-content">
                            <h3>Patient Health Portal</h3>
                            <p>Our comprehensive web portal gives you complete access to your health information with an
                                easy-to-use interface.</p>
                            <ul>
                                <li><i class="fas fa-check-circle"></i> View test results and reports</li>
                                <li><i class="fas fa-check-circle"></i> Manage appointments</li>
                                <li><i class="fas fa-check-circle"></i> Access health education materials</li>
                            </ul>
                            <a href="patient-register.php" class="button primary">Try Demo</a>
                        </div>
                    </div>
                </div>
                <div class="demo-slide">
                    <div class="slide-content">
                        <div class="image-container">
                            <img src="https://images.unsplash.com/photo-1581094271901-8022df4466f9"
                                alt="Health Analytics Dashboard" loading="lazy">
                        </div>
                        <div class="text-content">
                            <h3>Health Analytics Dashboard</h3>
                            <p>Track your health metrics over time with our comprehensive analytics tools that help
                                identify trends and potential concerns.</p>
                            <ul>
                                <li><i class="fas fa-check-circle"></i> Customizable health metrics</li>
                                <li><i class="fas fa-check-circle"></i> Provider benchmarking</li>
                                <li><i class="fas fa-check-circle"></i> Exportable reports</li>
                            </ul>
                            <a href="login.php" class="button primary">Try Demo</a>
                        </div>
                    </div>
                </div>
                <div class="demo-slide">
                    <div class="slide-content">
                        <div class="image-container">
                            <img src="https://images.unsplash.com/photo-1588776814546-1ffcf47267a5"
                                alt="Provider Dashboard interface" loading="lazy">
                        </div>
                        <div class="text-content">
                            <h3>Provider Dashboard</h3>
                            <p>Healthcare professionals get a comprehensive view of patient health with tools for
                                documentation, ordering, and communication.</p>
                            <ul>
                                <li><i class="fas fa-check-circle"></i> Integrated charting</li>
                                <li><i class="fas fa-check-circle"></i> e-Prescribing</li>
                                <li><i class="fas fa-check-circle"></i> Telehealth integration</li>
                            </ul>
                            <a href="admin/admin_login.php" class="button primary">Provider Login</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <button class="slider-prev" aria-label="Previous slide"><i class="fas fa-chevron-left"></i></button>
            <button class="slider-next" aria-label="Next slide"><i class="fas fa-chevron-right"></i></button> -->
        </div>
    </section>

    <!-- Medical Records -->
    <section class="medical-records">
        <div class="container">
            <div class="section-header">
                <h2>Comprehensive Medical Records Solution</h2>
                <p>Our system consolidates all your health information in one secure place, making it easier to manage
                    your care and share information with providers.</p>
            </div>
            <div class="records-grid">
                <div class="record-card">
                    <div class="icon-container"><i class="fas fa-file-medical"></i></div>
                    <h4>Medical History</h4>
                    <p>Complete record of diagnoses, treatments, and procedures with timeline view.</p>
                </div>
                <div class="record-card">
                    <div class="icon-container"><i class="fas fa-prescription-bottle-alt"></i></div>
                    <h4>Medications</h4>
                    <p>Current and past prescriptions with dosage instructions and refill tracking.</p>
                </div>
                <div class="record-card">
                    <div class="icon-container"><i class="fas fa-allergies"></i></div>
                    <h4>Allergies</h4>
                    <p>Detailed allergy and adverse reaction information with severity levels.</p>
                </div>
                <div class="record-card">
                    <div class="icon-container"><i class="fas fa-vial"></i></div>
                    <h4>Lab Results</h4>
                    <p>Secure storage of test results with trend analysis and normal ranges.</p>
                </div>
            </div>
            <div class="section-footer">
                <a href="dashboard.php" class="button secondary">See Sample Record</a>
                <a href="patient-register.php" class="button primary">Create Account</a>
            </div>
        </div>
    </section>

    <!-- Doctors -->
    <section class="doctors">
        <div class="container">
            <div class="section-header">
                <div>
                    <h2>Our Expert Medical Team</h2>
                    <p>Board-certified specialists dedicated to your care</p>
                </div>
                <a href="doctors.php" class="button secondary">View All Doctors <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="doctors-slider" role="region" aria-label="Doctors carousel">
                <?php foreach ($doctors as $doctor): ?>
                    <div class="doctor-card">
                        <?php if (!empty($doctor['photo'])): ?>
                            <img src="<?php echo htmlspecialchars($doctor['photo']); ?>"
                                alt="Dr. <?php echo htmlspecialchars($doctor['fullname']); ?>" class="profile-image">
                            <div class="card-content">
                                <h4><?php echo htmlspecialchars($doctor['fullname']); ?></h4>
                                <p class="specialty"><?php echo htmlspecialchars($doctor['specilaty'] ?? ''); ?></p>
                                <p>Specializing in <?php echo htmlspecialchars($doctor['specilaty'] ?? ''); ?> with over
                                    <?php echo htmlspecialchars($doctor['experience'] ?? '0'); ?> years of experience.
                                </p>
                                <div class="button-group">
                                    <a href="login.php" class="button secondary"><i class="fas fa-calendar-alt"></i> Book</a>
                                    <a href="login.php" class="button primary">Profile</a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="testimonials">
        <div class="container">
            <div class="section-header">
                <h2>What Our Patients Say</h2>
                <p>Hear from people who have transformed their healthcare experience</p>
            </div>
            <div class="testimonials-grid">
                <div class="testimonial-card">
                    <div class="patient-info">
                        <img src="https://randomuser.me/api/portraits/women/32.jpg" alt="Portrait of Sarah Thompson"
                            loading="lazy">
                        <div>
                            <h4>Sarah Thompson</h4>
                            <div class="rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <p>"Managing my chronic condition became so much easier with this platform. Having all my test
                        results and medication history in one place has been life-changing."</p>
                </div>
                <div class="testimonial-card">
                    <div class="patient-info">
                        <img src="https://randomuser.me/api/portraits/men/45.jpg" alt="Portrait of Robert Johnson"
                            loading="lazy">
                        <div>
                            <h4>Robert Johnson</h4>
                            <div class="rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                        </div>
                    </div>
                    <p>"As someone who sees multiple specialists, having a centralized health record that all my doctors
                        can access has eliminated so much redundancy and confusion."</p>
                </div>
                <div class="testimonial-card">
                    <div class="patient-info">
                        <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Portrait of Maria Garcia"
                            loading="lazy">
                        <div>
                            <h4>Maria Garcia</h4>
                            <div class="rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <p>"The ability to access my records online and share them with my daughter who helps manage my care
                        has given me peace of mind in my golden years."</p>
                </div>
            </div>
            <div class="section-footer">
                <a href="login.php" class="button primary">Read More Stories</a>
            </div>
        </div>
    </section>

    <!-- Stats -->
    <section class="stats">
        <div class="stats-marquee">
            <div class="stat-item">
                <div class="stat-counter">250K+</div>
                <p>Patients Served</p>
            </div>
            <div class="stat-item">
                <div class="stat-counter">5K+</div>
                <p>Healthcare Providers</p>
            </div>
            <div class="stat-item">
                <div class="stat-counter">99.9%</div>
                <p>Platform Uptime</p>
            </div>
            <div class="stat-item">
                <div class="stat-counter">24/7</div>
                <p>Support Availability</p>
            </div>
            <div class="stat-item">
                <div class="stat-counter">250K+</div>
                <p>Patients Served</p>
            </div>
            <div class="stat-item">
                <div class="stat-counter">5K+</div>
                <p>Healthcare Providers</p>
            </div>
            <div class="stat-item">
                <div class="stat-counter">99.9%</div>
                <p>Platform Uptime</p>
            </div>
            <div class="stat-item">
                <div class="stat-counter">24/7</div>
                <p>Support Availability</p>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="why-choose-us">
        <div class="container">
            <div class="content-wrapper">
                <div class="text-content">
                    <h2>Why Healthcare Providers Choose Our Platform</h2>
                    <p>We understand the challenges of modern healthcare and have built solutions to address them.</p>
                    <div class="reasons">
                        <div class="reason-item">
                            <div class="icon-container"><i class="fas fa-check"></i></div>
                            <div>
                                <h4>Reduce Medical Errors</h4>
                                <p>Comprehensive patient data at your fingertips helps prevent mistakes and improve
                                    diagnosis accuracy.</p>
                            </div>
                        </div>
                        <div class="reason-item">
                            <div class="icon-container"><i class="fas fa-check"></i></div>
                            <div>
                                <h4>Improve Care Coordination</h4>
                                <p>Seamless sharing between specialists, primary care, and hospitals enhances continuity
                                    of care.</p>
                            </div>
                        </div>
                        <div class="reason-item">
                            <div class="icon-container"><i class="fas fa-check"></i></div>
                            <div>
                                <h4>Enhance Patient Engagement</h4>
                                <p>Empowered patients with access to their records become active partners in their
                                    healthcare.</p>
                            </div>
                        </div>
                        <div class="reason-item">
                            <div class="icon-container"><i class="fas fa-check"></i></div>
                            <div>
                                <h4>Streamline Administrative Tasks</h4>
                                <p>Automated workflows and integrated billing reduce paperwork and improve efficiency.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="image-container">
                    <img src="https://images.unsplash.com/photo-1581094271901-8022df4466f9"
                        alt="Healthcare Providers collaborating" loading="lazy">
                </div>
            </div>
        </div>
    </section>

    <!-- Integrated Health -->
    <section class="integrated-health">
        <div class="container">
            <div class="content-wrapper">
                <div class="text-content">
                    <h2>Seamless Integration Across Your Healthcare Ecosystem</h2>
                    <p>Our platform connects all aspects of your healthcare journey into one unified experience.</p>
                    <div class="integration-items">
                        <div class="integration-item">
                            <div class="icon-container"><i class="fas fa-link"></i></div>
                            <div>
                                <h4>Hospital System Integration</h4>
                                <p>Direct connection with major EHR systems including Epic, Cerner, and Meditech for
                                    real-time data synchronization.</p>
                            </div>
                        </div>
                        <div class="integration-item">
                            <div class="icon-container"><i class="fas fa-clinic-medical"></i></div>
                            <div>
                                <h4>Clinic & Pharmacy Network</h4>
                                <p>Access to over 10,000 affiliated clinics and 25,000 pharmacies nationwide for
                                    coordinated care.</p>
                            </div>
                        </div>
                        <div class="integration-item">
                            <div class="icon-container"><i class="fas fa-heartbeat"></i></div>
                            <div>
                                <h4>Diagnostic Center Links</h4>
                                <p>Automated results delivery from labs and imaging centers directly to your health
                                    record.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="image-container position-relative">
                    <img src="https://images.unsplash.com/photo-1581092918056-0c4c3acd3789"
                        alt="Healthcare Integration network" loading="lazy">
                    <div class="callout">
                        <h4>24/7 Virtual Care</h4>
                        <p>Connect with board-certified physicians anytime through our integrated telehealth platform.
                        </p>
                    </div>
                </div>
            </div>
            <div class="cta-section">
                <div class="cta-content">
                    <h3>Ready to experience connected healthcare?</h3>
                    <a href="login.php" class="button primary">Request Demo</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Data Security -->
    <section class="data-security">
        <div class="container">
            <div class="content-wrapper">
                <div class="image-container">
                    <img src="https://images.unsplash.com/photo-1550751827-4bd374c3f58b"
                        alt="Data Security infrastructure" loading="lazy">
                </div>
                <div class="text-content">
                    <h2>Enterprise-Grade Security & Compliance</h2>
                    <p>Your health data deserves the highest level of protection.</p>
                    <div class="security-items">
                        <div class="security-item">
                            <div class="icon-container"><i class="fas fa-shield-alt"></i></div>
                            <div>
                                <h4>Military-Grade Encryption</h4>
                                <p>All data is encrypted both in transit and at rest using AES-256 standards, the same
                                    level used by financial institutions.</p>
                            </div>
                        </div>
                        <div class="security-item">
                            <div class="icon-container"><i class="fas fa-certificate"></i></div>
                            <div>
                                <h4>HIPAA Compliant</h4>
                                <p>Fully compliant with all HIPAA regulations and regularly audited by third-party
                                    security firms.</p>
                            </div>
                        </div>
                        <div class="security-item">
                            <div class="icon-container"><i class="fas fa-user-shield"></i></div>
                            <div>
                                <h4>Granular Access Controls</h4>
                                <p>Detailed permission settings let you control exactly who can see each part of your
                                    health record.</p>
                            </div>
                        </div>
                    </div>
                    <div class="button-group">
                        <a href="login.php" class="button secondary">View Security Whitepaper</a>
                        <a href="login.php" class="button primary">Compliance Details</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Web Experience -->
    <section class="web-experience">
        <div class="container">
            <div class="content-wrapper">
                <div class="text-content">
                    <h2>Your Health at Your Fingertips</h2>
                    <p>Our responsive web portal puts the power of your health records in your hands through any
                        browser.</p>
                    <div class="features-grid">
                        <div class="feature-card">
                            <div class="feature-icon"><i class="fas fa-bell"></i></div>
                            <h4>Email Alerts</h4>
                            <p>Get notified about appointments, test results, and important health updates.</p>
                        </div>
                        <div class="feature-card">
                            <div class="feature-icon"><i class="fas fa-file-upload"></i></div>
                            <h4>Document Upload</h4>
                            <p>Easily upload insurance cards, lab results, or other medical documents.</p>
                        </div>
                        <div class="feature-card">
                            <div class="feature-icon"><i class="fas fa-comment-medical"></i></div>
                            <h4>Secure Messaging</h4>
                            <p>Communicate directly with your care team through encrypted messages.</p>
                        </div>
                        <div class="feature-card">
                            <div class="feature-icon"><i class="fas fa-map-marker-alt"></i></div>
                            <h4>Provider Locator</h4>
                            <p>Find nearby in-network providers with detailed profiles and ratings.</p>
                        </div>
                    </div>
                    <div class="button-group">
                        <a href="login.php" class="button primary">Patient Login</a>
                        <a href="admin/admin_login.php" class="button secondary">Provider Login</a>
                    </div>
                </div>
                <div class="image-container position-relative">
                    <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71" alt="Web Portal interface"
                        loading="lazy">
                    <div class="award-badge">
                        <div class="award-content">
                            <i class="fas fa-award"></i>
                            <div>
                                <div>Best Health Portal</div>
                                <small>2023 Medical Tech Awards</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Profile Container -->
    <div id="profile-container"></div>

    <!-- Footer Section -->
    <?php include 'includes/footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script>
        $(document).ready(function () {
            // Initialize doctor carousel
            $('.doctors-slider').slick({
                dots: true,
                arrows: true,
                infinite: true,
                speed: 500,
                slidesToShow: 4,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 3000,
                pauseOnHover: true,
                pauseOnFocus: true,
                pauseOnDotsHover: true,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            slidesToShow: 3
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            slidesToShow: 2
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 1
                        }
                    }
                ],
                accessibility: true,
                prevArrow: '<button type="button" class="slick-prev" aria-label="Previous doctor"><i class="fas fa-chevron-left"></i></button>',
                nextArrow: '<button type="button" class="slick-next" aria-label="Next doctor"><i class="fas fa-chevron-right"></i></button>'
            });

            // Initialize demo slider
            $('.demo-slider').slick({
                dots: false,
                arrows: true,
                infinite: true,
                speed: 500,
                slidesToShow: 1,
                slidesToScroll: 1,
                responsive: [
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                ],
                accessibility: true,
                prevArrow: $('.slider-prev'),
                nextArrow: $('.slider-next')
            });
        });

        function viewProfile(doctorId) {
            fetch('get_doctor.php?id=' + doctorId)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                        return;
                    }
                    document.getElementById("profile-container").innerHTML = `
                        <div class="profile-card">
                            <img src="${data.photo}" alt="Doctor Photo" style="width:150px; border-radius: 10px;">
                            <h2>${data.name}</h2>
                            <p><strong>Specialization:</strong> ${data.specialization}</p>
                            <p><strong>Email:</strong> ${data.email}</p>
                            <p><strong>Phone:</strong> ${data.phone}</p>
                            <p><strong>Experience:</strong> ${data.experience}</p>
                            <p><strong>About:</strong> ${data.about}</p>
                            <button onclick="document.getElementById('profile-container').style.display='none'">Close</button>
                        </div>
                    `;
                    document.getElementById("profile-container").style.display = 'block';
                    document.getElementById("profile-container").scrollIntoView({ behavior: 'smooth' });
                })
                .catch(error => {
                    console.error('Error fetching profile:', error);
                    alert('Failed to load doctor profile. Please try again.');
                });
        }

        function viewProfile(doctorId) {
            window.location.href = 'doctor-profile.php?id=' + doctorId;
        }

        function viewProfile(doctorId) {
            alert("Profile view for doctor ID " + doctorId + " is not implemented. Please check doctor-profile.php.");
        }

        // OR replace it with:
        function viewProfile(doctorId) {
            window.location.href = 'doctor-profile.php?id=' + doctorId;
        }
    </script>
    <?php $conn->close(); ?>

    <?php include 'includes/chatbot.php'; ?>


</body>

</html>