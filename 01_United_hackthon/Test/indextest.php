<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="HealthSync - Your personalized health management platform">
    <meta name="keywords" content="healthcare, medical records, digital health, patient portal">
    <meta name="robots" content="index, follow">
    <title>HealthSync - Your Health Dashboard</title>
    <link rel="icon" href="img/HealthSync.png" type="image/png">
    <link rel="apple-touch-icon" href="img/HealthSync.png" type="image/png">
    <link rel="stylesheet" href="../css/header-footer.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css">
    <style>
        :root {
            --primary-blue: #3B82F6;
            --secondary-teal: #2DD4BF;
            --accent-coral: #F472B6;
            --neutral-gray: #F1F5F9;
            --text-dark: #1E293B;
            --bg-white: #FFFFFF;
            --shadow-neu: 8px 8px 16px rgba(0, 0, 0, 0.05), -8px -8px 16px rgba(255, 255, 255, 0.8);
            --gradient-bg: linear-gradient(135deg, #3B82F6, #2DD4BF);
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--neutral-gray);
            color: var(--text-dark);
            margin: 0;
            overflow-x: hidden;
        }

        /* Navbar */
        .navbar {
            background: var(--bg-white);
            box-shadow: var(--shadow-neu);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-brand {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-blue) !important;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-link {
            color: var(--text-dark) !important;
            font-weight: 500;
            position: relative;
            transition: color 0.3s ease;
        }

        .nav-link:hover, .nav-link.active {
            color: var(--primary-blue) !important;
        }

        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            height: 2px;
            background: var(--gradient-bg);
        }

        .nav-item .tooltip {
            position: absolute;
            background: var(--primary-blue);
            color: var(--bg-white);
            padding: 0.3rem 0.8rem;
            border-radius: 4px;
            font-size: 0.8rem;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            display: none;
        }

        .nav-item:hover .tooltip {
            display: block;
        }

        /* Profile Dropdown */
        .profile-menu {
            position: fixed;
            top: 0;
            right: -320px;
            width: 320px;
            height: 100vh;
            background: var(--bg-white);
            box-shadow: -4px 0 12px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            transition: right 0.3s ease-in-out;
            z-index: 2000;
            overflow-y: auto;
        }

        .profile-menu.active {
            right: 0;
        }

        .profile-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            z-index: 1999;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease;
        }

        .profile-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .profile-menu .close-btn {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--text-dark);
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .profile-menu .close-btn:hover {
            color: var(--accent-coral);
        }

        .profile-menu .user-info {
            text-align: center;
            margin-bottom: 2rem;
        }

        .profile-menu img {
            border: 3px solid var(--primary-blue);
            border-radius: 50%;
            margin-bottom: 1rem;
            transition: transform 0.3s ease;
        }

        .profile-menu img:hover {
            transform: scale(1.05);
        }

        .profile-menu .user-info h4 {
            margin: 0.5rem 0;
            font-size: 1.4rem;
            font-weight: 600;
        }

        .profile-menu .user-info p {
            color: var(--text-dark);
            opacity: 0.7;
            font-size: 0.9rem;
        }

        .profile-menu .progress-bar {
            height: 6px;
            background: var(--neutral-gray);
            border-radius: 3px;
            margin: 1rem 0;
        }

        .profile-menu .progress-bar div {
            height: 100%;
            background: var(--gradient-bg);
            border-radius: 3px;
            width: 80%;
        }

        .profile-menu ul {
            list-style: none;
            padding: 0;
        }

        .profile-menu ul li a {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            padding: 0.8rem 1rem;
            color: var(--text-dark);
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .profile-menu ul li a:hover, .profile-menu ul li a.active {
            background: var(--neutral-gray);
            color: var(--primary-blue);
            transform: translateX(5px);
        }

        .profile-menu .logout {
            color: var(--accent-coral);
        }

        /* Dashboard Section */
        .dashboard-section {
            padding: 4rem 0;
            background: var(--bg-white);
            border-radius: 16px;
            margin: 2rem auto;
            max-width: 1280px;
            box-shadow: var(--shadow-neu);
            position: relative;
            overflow: hidden;
        }

        .dashboard-hero {
            background: var(--gradient-bg);
            color: var(--bg-white);
            padding: 2rem;
            border-radius: 12px 12px 0 0;
            text-align: center;
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 2rem 0;
            padding: 0 1rem;
        }

        .dashboard-header h2 {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        .search-bar {
            display: flex;
            gap: 0.5rem;
            max-width: 300px;
        }

        .search-bar input {
            border-radius: 8px;
            border: 1px solid var(--neutral-gray);
            padding: 0.8rem;
            transition: box-shadow 0.3s ease;
        }

        .search-bar input:focus {
            box-shadow: 0 0 8px rgba(59, 130, 246, 0.3);
            border-color: var(--primary-blue);
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            padding: 0 1rem;
        }

        .dashboard-card {
            background: var(--bg-white);
            padding: 2rem;
            border-radius: 12px;
            box-shadow: var(--shadow-neu);
            text-align: center;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .dashboard-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
        }

        .dashboard-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--gradient-bg);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .dashboard-card:hover::before {
            opacity: 1;
        }

        .dashboard-card i {
            font-size: 2.5rem;
            color: var(--primary-blue);
            margin-bottom: 1rem;
        }

        .notification-badge {
            background: var(--accent-coral);
            color: var(--bg-white);
            border-radius: 50%;
            padding: 0.4rem 0.7rem;
            font-size: 0.9rem;
            position: absolute;
            top: -10px;
            right: -10px;
        }

        /* Doctors Section */
        .doctors {
            padding: 4rem 0;
            background: var(--neutral-gray);
        }

        .doctor-card {
            background: var(--bg-white);
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: var(--shadow-neu);
            transition: all 0.3s ease;
            position: relative;
        }

        .doctor-card:hover {
            transform: scale(1.03);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
        }

        .doctor-card img {
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .favorite-btn {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: none;
            border: none;
            font-size: 1.2rem;
            color: var(--text-dark);
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .favorite-btn:hover, .favorite-btn.active {
            color: var(--accent-coral);
        }

        /* Buttons */
        .button {
            padding: 0.8rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .button.primary {
            background: var(--primary-blue);
            color: var(--bg-white);
        }

        .button.primary:hover {
            background: #2563EB;
            transform: translateY(-2px);
        }

        .button.secondary {
            background: var(--bg-white);
            color: var(--primary-blue);
            border: 1px solid var(--primary-blue);
        }

        .button.secondary:hover {
            background: var(--primary-blue);
            color: var(--bg-white);
            transform: translateY(-2px);
        }

        /* Modal */
        .modal-content {
            border-radius: 12px;
            box-shadow: var(--shadow-neu);
        }

        .modal-header {
            background: var(--gradient-bg);
            color: var(--bg-white);
            border-radius: 12px 12px 0 0;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }

            .profile-menu {
                width: 100%;
                right: -100%;
            }

            .profile-menu.active {
                right: 0;
            }
        }

        @media (max-width: 768px) {
            .dashboard-header {
                flex-direction: column;
                gap: 1rem;
            }

            .search-bar {
                max-width: 100%;
            }

            .slick-prev, .slick-next {
                width: 30px;
                height: 30px;
            }

            .slick-prev {
                left: 10px;
            }

            .slick-next {
                right: 10px;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="fas fa-heartbeat"></i> HealthSync</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="dashboard.php">Dashboard <span class="tooltip">Home</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="records.php">My Records <span class="tooltip">Health Data</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="appointments.php">Appointments <span class="tooltip">Schedule</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="messages.php">Messages <span class="notification-badge" id="msg-count">3</span> <span class="tooltip">Chat</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="doctors.php">Doctors <span class="tooltip">Care Team</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" id="profileToggle" aria-label="User Profile">
                            <i class="fas fa-user-circle fa-lg"></i> <span id="userName">John Doe</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Profile Dropdown -->
    <div class="profile-overlay"></div>
    <div id="profileMenu" class="profile-menu">
        <button class="close-btn" id="closeProfileMenu" aria-label="Close profile menu"><i class="fas fa-times"></i></button>
        <div class="user-info">
            <img src="img/user-profile.jpg" class="rounded-circle" width="120" height="120" alt="User Profile">
            <h4>John Doe</h4>
            <p>john.doe@example.com</p>
            <div class="progress-bar"><div></div></div>
            <small>Profile 80% Complete</small>
        </div>
        <hr>
        <ul>
            <li><a href="dashboard.php" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="records.php"><i class="fas fa-file-medical"></i> My Records</a></li>
            <li><a href="appointments.php"><i class="fas fa-calendar-alt"></i> Appointments</a></li>
            <li><a href="messages.php"><i class="fas fa-comments"></i> Messages <span class="notification-badge">3</span></a></li>
            <li><a href="profile.php"><i class="fas fa-user-edit"></i> Profile Settings</a></li>
            <li><a href="security.php"><i class="fas fa-shield-alt"></i> Security</a></li>
            <li><a href="#" id="highContrastToggle"><i class="fas fa-adjust"></i> High Contrast Mode</a></li>
            <li><a href="logout.php" class="logout"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>

    <!-- Dashboard Section -->
    <section class="dashboard-section">
        <div class="dashboard-hero">
            <h1>Welcome back, <span id="welcomeName">John</span>!</h1>
            <p>Your health, simplified and secure.</p>
        </div>
        <div class="container">
            <div class="dashboard-header">
                <h2>Your Health Overview</h2>
                <div class="search-bar">
                    <input type="text" class="form-control" placeholder="Search records..." aria-label="Search health records">
                    <button class="button primary"><i class="fas fa-search"></i></button>
                </div>
            </div>
            <div class="dashboard-grid">
                <div class="dashboard-card">
                    <i class="fas fa-calendar-alt"></i>
                    <h4>Upcoming Appointments</h4>
                    <p>Next: Dr. Smith, Cardiologist - Apr 25, 2025</p>
                    <a href="appointments.php" class="button primary">View All</a>
                </div>
                <div class="dashboard-card">
                    <i class="fas fa-file-medical"></i>
                    <h4>Recent Test Results</h4>
                    <p>Blood Test - Apr 20, 2025</p>
                    <a href="records.php" class="button primary">View Results</a>
                </div>
                <div class="dashboard-card">
                    <i class="fas fa-pills"></i>
                    <h4>Medications</h4>
                    <p>2 active prescriptions</p>
                    <a href="medications.php" class="button primary">Manage</a>
                </div>
                <div class="dashboard-card">
                    <i class="fas fa-comments"></i>
                    <h4>Messages</h4>
                    <p>3 unread messages</p>
                    <a href="messages.php" class="button primary">Read Now</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Doctors Section -->
    <section class="doctors">
        <div class="container">
            <div class="section-header">
                <div>
                    <h2>Your Care Team</h2>
                    <p>Connect with your trusted doctors</p>
                </div>
                <div class="doctor-filter">
                    <select class="form-select" aria-label="Filter by specialty">
                        <option value="">All Specialties</option>
                        <option value="cardiology">Cardiology</option>
                        <option value="pediatrics">Pediatrics</option>
                        <option value="neurology">Neurology</option>
                    </select>
                </div>
            </div>
            <div class="doctors-slider" role="region" aria-label="Doctors carousel">
                <div class="doctor-card" data-specialty="cardiology">
                    <button class="favorite-btn" aria-label="Favorite Dr. John Smith"><i class="fas fa-heart"></i></button>
                    <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Dr. John Smith, Cardiologist" loading="lazy">
                    <div class="card-content">
                        <h4>Dr. John Smith</h4>
                        <p class="specialty">Cardiologist</p>
                        <p>Specializing in heart health with 15+ years of experience.</p>
                        <div class="button-group">
                            <a href="#" class="button secondary" data-bs-toggle="modal" data-bs-target="#bookingModal"><i class="fas fa-calendar-alt"></i> Book</a>
                            <a href="doctor-profile.php?id=1" class="button primary">Profile</a>
                        </div>
                    </div>
                </div>
                <div class="doctor-card" data-specialty="pediatrics">
                    <button class="favorite-btn" aria-label="Favorite Dr. Sarah Johnson"><i class="fas fa-heart"></i></button>
                    <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Dr. Sarah Johnson, Pediatrician" loading="lazy">
                    <div class="card-content">
                        <h4>Dr. Sarah Johnson</h4>
                        <p class="specialty">Pediatrician</p>
                        <p>Expert in child healthcare and development.</p>
                        <div class="button-group">
                            <a href="#" class="button secondary" data-bs-toggle="modal" data-bs-target="#bookingModal"><i class="fas fa-calendar-alt"></i> Book</a>
                            <a href="doctor-profile.php?id=2" class="button primary">Profile</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Booking Modal -->
    <div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bookingModalLabel">Book Appointment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="doctorName" class="form-label">Doctor</label>
                            <input type="text" class="form-control" id="doctorName" value="Dr. John Smith" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="appointmentDate" class="form-label">Date</label>
                            <input type="date" class="form-control" id="appointmentDate" required>
                        </div>
                        <div class="mb-3">
                            <label for="appointmentTime" class="form-label">Time</label>
                            <select class="form-select" id="appointmentTime" required>
                                <option value="">Select Time</option>
                                <option value="09:00">9:00 AM</option>
                                <option value="10:00">10:00 AM</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="button secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="button primary">Confirm Booking</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include '../includes/footer.php'; ?>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script>
        $(document).ready(function () {
            // Profile Toggle
            $('#profileToggle').click(function (e) {
                e.preventDefault();
                $('#profileMenu').addClass('active');
                $('.profile-overlay').addClass('active');
            });

            $('#closeProfileMenu, .profile-overlay').click(function () {
                $('#profileMenu').removeClass('active');
                $('.profile-overlay').removeClass('active');
            });

            // High Contrast Mode
            $('#highContrastToggle').click(function (e) {
                e.preventDefault();
                $('body').toggleClass('high-contrast');
            });

            // Favorite Doctor Toggle
            $('.favorite-btn').click(function () {
                $(this).toggleClass('active');
                $(this).find('i').toggleClass('fas far');
            });

            // Initialize Doctors Slider
            $('.doctors-slider').slick({
                dots: true,
                arrows: true,
                infinite: true,
                speed: 500,
                slidesToShow: 4,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 3000,
                responsive: [
                    { breakpoint: 1200, settings: { slidesToShow: 3 } },
                    { breakpoint: 992, settings: { slidesToShow: 2 } },
                    { breakpoint: 768, settings: { slidesToShow: 1 } }
                ],
                prevArrow: '<button type="button" class="slick-prev" aria-label="Previous doctor"><i class="fas fa-chevron-left"></i></button>',
                nextArrow: '<button type="button" class="slick-next" aria-label="Next doctor"><i class="fas fa-chevron-right"></i></button>'
            });

            // Doctor Filter
            $('.doctor-filter select').change(function () {
                const specialty = $(this).val();
                $('.doctors-slider').slick('slickFilter', specialty ? `[data-specialty="${specialty}"]` : '');
            });

            // Mock API for User Data
            const fetchUserData = () => {
                return new Promise((resolve) => {
                    setTimeout(() => {
                        resolve({
                            name: "John Doe",
                            email: "john.doe@example.com",
                            profilePic: "img/user-profile.jpg",
                            upcomingAppointments: [{ doctor: "Dr. Smith", date: "Apr 25, 2025" }],
                            unreadMessages: 3
                        });
                    }, 1000);
                });
            };

            // Load User Data
            fetchUserData().then(data => {
                $('#msg-count').text(data.unreadMessages);
                $('#welcomeName').text(data.name);
                $('.profile-menu .user-info h4').text(data.name);
                $('.profile-menu .user-info p').text(data.email);
                $('.profile-menu .user-info img').attr('src', data.profilePic);
                $('#userName').text(data.name);
            });
        });

        // High Contrast Mode CSS
        const highContrastStyles = `
            body.high-contrast {
                background: #000 !important;
                color: #fff !important;
            }
            body.high-contrast .navbar, body.high-contrast .dashboard-section, body.high-contrast .doctors, body.high-contrast .doctor-card, body.high-contrast .dashboard-card {
                background: #111 !important;
                color: #fff !important;
                border: 1px solid #fff !important;
            }
            body.high-contrast .nav-link, body.high-contrast .button, body.high-contrast a {
                color: #fff !important;
                border-color: #fff !important;
            }
            body.high-contrast .button.primary {
                background: #fff !important;
                color: #000 !important;
            }
            body.high-contrast .notification-badge {
                background: #f00 !important;
            }
        `;
        const styleSheet = document.createElement('style');
        styleSheet.innerText = highContrastStyles;
        document.head.appendChild(styleSheet);
    </script>
</body>
</html>