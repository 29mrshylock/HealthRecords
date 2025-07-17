<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Profile | HealthSync</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4361ee;
            --primary-light: #e0e7ff;
            --secondary: #3a0ca3;
            --accent: #f72585;
            --success: #4cc9f0;
            --warning: #f8961e;
            --danger: #ef233c;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
            --border-radius: 12px;
            --box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f5f7ff;
            color: var(--dark);
            line-height: 1.6;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* ===== Profile Header ===== */
        .profile-header {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 2rem;
            margin-bottom: 1.5rem;
            text-align: center;
            position: relative;
        }

        .profile-pic {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid var(--primary-light);
            margin-bottom: 1rem;
        }

        .profile-title {
            font-size: 1.8rem;
            color: var(--secondary);
            margin-bottom: 0.5rem;
        }

        .patient-id {
            background: var(--primary-light);
            color: var(--primary);
            padding: 0.3rem 1rem;
            border-radius: 50px;
            display: inline-block;
            font-weight: 500;
            margin-bottom: 1rem;
        }

        .medical-tags {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 0.8rem;
            margin-top: 1rem;
        }

        .medical-tag {
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .tag-allergy {
            background: rgba(239, 35, 60, 0.1);
            color: var(--danger);
        }

        .tag-condition {
            background: rgba(248, 150, 30, 0.1);
            color: var(--warning);
        }

        /* ===== Main Content ===== */
        .profile-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        @media (max-width: 768px) {
            .profile-content {
                grid-template-columns: 1fr;
            }
        }

        /* ===== Cards ===== */
        .card {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .card-title {
            font-size: 1.25rem;
            color: var(--secondary);
            margin-bottom: 1.2rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .card-title i {
            color: var(--primary);
        }

        /* ===== Personal Details ===== */
        .detail-item {
            margin-bottom: 1rem;
            display: flex;
        }

        .detail-label {
            font-weight: 600;
            color: var(--primary);
            min-width: 150px;
        }

        /* ===== Emergency Contacts ===== */
        .contact-card {
            background: var(--primary-light);
            border-radius: var(--border-radius);
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .contact-name {
            font-weight: 600;
            margin-bottom: 0.3rem;
        }

        /* ===== Medical History ===== */
        .history-item {
            margin-bottom: 1.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px dashed var(--light-gray);
        }

        .history-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .history-title {
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--secondary);
        }

        /* ===== Appointments ===== */
        .appointment-card {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: white;
            border-radius: var(--border-radius);
            padding: 1rem;
            margin-bottom: 1rem;
            border-left: 4px solid var(--primary);
        }

        .appointment-info {
            flex: 1;
        }

        .appointment-doctor {
            font-weight: 600;
            margin-bottom: 0.3rem;
        }

        .appointment-specialty {
            color: var(--gray);
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .appointment-time {
            display: flex;
            gap: 1rem;
        }

        .appointment-date {
            font-weight: 500;
        }

        .appointment-action {
            margin-left: 1rem;
        }

        .btn {
            padding: 0.5rem 1rem;
            border-radius: 50px;
            border: none;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--secondary);
            transform: translateY(-2px);
        }

        /* ===== Responsive Adjustments ===== */
        @media (max-width: 576px) {
            .detail-item {
                flex-direction: column;
                gap: 0.3rem;
            }
            
            .appointment-card {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
            
            .appointment-action {
                margin-left: 0;
                width: 100%;
            }
            
            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Profile Header -->
        <div class="profile-header">
            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Patient" class="profile-pic">
            <h1 class="profile-title">Rahul Sharma</h1>
            <div class="patient-id">ID: PAT-789456</div>
            
            <div class="medical-tags">
                <span class="medical-tag tag-allergy">
                    <i class="fas fa-allergy"></i> Peanut Allergy
                </span>
                <span class="medical-tag tag-condition">
                    <i class="fas fa-heartbeat"></i> Type 2 Diabetes
                </span>
                <span class="medical-tag" style="background: rgba(67, 97, 238, 0.1); color: var(--primary);">
                    <i class="fas fa-tint"></i> Blood Group: B+
                </span>
            </div>
        </div>

        <!-- Main Content -->
        <div class="profile-content">
            <!-- Left Column -->
            <div class="left-column">
                <!-- Personal Details -->
                <div class="card">
                    <h3 class="card-title">
                        <i class="fas fa-user"></i> Personal Details
                    </h3>
                    <div class="detail-item">
                        <span class="detail-label">Age:</span>
                        <span>35 years (15 Jan 1989)</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Gender:</span>
                        <span>Male</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Phone:</span>
                        <span>+91 98765 43210</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Email:</span>
                        <span>rahul.sharma@example.com</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Address:</span>
                        <span>123 Health Street, Mumbai - 400001, Maharashtra</span>
                    </div>
                </div>

                <!-- Emergency Contacts -->
                <div class="card">
                    <h3 class="card-title">
                        <i class="fas fa-phone-alt"></i> Emergency Contacts
                    </h3>
                    <div class="contact-card">
                        <div class="contact-name">Priya Sharma (Wife)</div>
                        <div>+91 98765 12340</div>
                        <div>priya.sharma@example.com</div>
                    </div>
                    <div class="contact-card">
                        <div class="contact-name">Dr. Amit Patel (Physician)</div>
                        <div>+91 98765 67890</div>
                        <div>clinic@amitpatel.com</div>
                    </div>
                </div>

                <!-- Insurance Information -->
                <div class="card">
                    <h3 class="card-title">
                        <i class="fas fa-shield-alt"></i> Insurance
                    </h3>
                    <div class="detail-item">
                        <span class="detail-label">Provider:</span>
                        <span>Star Health Insurance</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Policy No:</span>
                        <span>STAR-789456123</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Valid Until:</span>
                        <span>31 Dec 2025</span>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="right-column">
                <!-- Upcoming Appointments -->
                <div class="card">
                    <h3 class="card-title">
                        <i class="fas fa-calendar-check"></i> Upcoming Appointments
                    </h3>
                    <div class="appointment-card">
                        <div class="appointment-info">
                            <div class="appointment-doctor">Dr. Amit Patel</div>
                            <div class="appointment-specialty">Cardiologist</div>
                            <div class="appointment-time">
                                <span class="appointment-date">25 May 2024</span>
                                <span>10:30 AM</span>
                            </div>
                        </div>
                        <div class="appointment-action">
                            <button class="btn btn-primary">
                                <i class="fas fa-edit"></i> Reschedule
                            </button>
                        </div>
                    </div>
                    <div class="appointment-card">
                        <div class="appointment-info">
                            <div class="appointment-doctor">Dr. Neha Gupta</div>
                            <div class="appointment-specialty">Endocrinologist</div>
                            <div class="appointment-time">
                                <span class="appointment-date">5 June 2024</span>
                                <span>2:15 PM</span>
                            </div>
                        </div>
                        <div class="appointment-action">
                            <button class="btn btn-primary">
                                <i class="fas fa-edit"></i> Reschedule
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Medical History -->
                <div class="card">
                    <h3 class="card-title">
                        <i class="fas fa-history"></i> Medical History
                    </h3>
                    <div class="history-item">
                        <div class="history-title">Diabetes Management</div>
                        <p>Diagnosed in 2018. Currently on Metformin 500mg twice daily.</p>
                    </div>
                    <div class="history-item">
                        <div class="history-title">Appendectomy</div>
                        <p>Underwent laparoscopic appendectomy in 2015 at City Hospital.</p>
                    </div>
                    <div class="history-item">
                        <div class="history-title">Allergies</div>
                        <p>Peanut allergy (Anaphylaxis risk), Penicillin allergy (rash).</p>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card">
                    <h3 class="card-title">
                        <i class="fas fa-bolt"></i> Quick Actions
                    </h3>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <button class="btn btn-primary">
                            <i class="fas fa-file-prescription"></i> Request Prescription
                        </button>
                        <button class="btn btn-primary">
                            <i class="fas fa-video"></i> Start Teleconsult
                        </button>
                        <button class="btn btn-primary">
                            <i class="fas fa-file-medical"></i> View Reports
                        </button>
                        <button class="btn btn-primary">
                            <i class="fas fa-pills"></i> Medicine Refill
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>