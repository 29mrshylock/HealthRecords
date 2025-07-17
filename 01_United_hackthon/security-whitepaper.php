<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HealthSync - Security Whitepaper</title>
    <meta name="description" content="HealthSync's comprehensive security whitepaper detailing HIPAA-compliant healthcare data protection measures.">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-blue: #2563eb;
            --secondary-teal: #0d9488;
            --accent-red: #dc2626;
            --dark-gray: #1f2937;
            --light-gray: #f3f4f6;
            --white: #ffffff;
        }
        
        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            line-height: 1.6;
            color: var(--dark-gray);
            overflow-x: hidden;
        }
        
        .security-hero {
            background: linear-gradient(135deg, var(--primary-blue), #1e40af);
            color: var(--white);
            padding: 5rem 0;
            position: relative;
            overflow: hidden;
        }
        
        .security-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80') no-repeat center center/cover;
            opacity: 0.15;
            z-index: 0;
        }
        
        .security-hero .container {
            position: relative;
            z-index: 1;
        }
        
        .security-badge {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border-radius: 50px;
            padding: 0.5rem 1.25rem;
            display: inline-block;
            margin-bottom: 1rem;
            border: 1px solid rgba(255,255,255,0.2);
        }
        
        .feature-icon {
            width: 60px;
            height: 60px;
            background: var(--light-gray);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            color: var(--primary-blue);
            font-size: 1.75rem;
            transition: all 0.3s ease;
        }
        
        .feature-card:hover .feature-icon {
            background: var(--primary-blue);
            color: white;
            transform: scale(1.1);
        }
        
        .feature-card {
            transition: all 0.3s ease;
            border-radius: 12px;
            overflow: hidden;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04);
        }
        
        .compliance-card {
            border-left: 4px solid var(--primary-blue);
            transition: all 0.3s ease;
            border-radius: 8px;
            overflow: hidden;
            position: relative;
        }
        
        .compliance-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(37,99,235,0.03), rgba(13,148,136,0.03));
            z-index: 0;
            opacity: 0;
            transition: all 0.3s ease;
        }
        
        .compliance-card:hover::before {
            opacity: 1;
        }
        
        .compliance-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        
        .compliance-card .card-content {
            position: relative;
            z-index: 1;
        }
        
        .architecture-diagram {
            border-radius: 12px;
            box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);
            border: 1px solid #e5e7eb;
            transition: all 0.3s ease;
        }
        
        .architecture-diagram:hover {
            transform: scale(1.02);
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
        }
        
        .timeline {
            position: relative;
            padding-left: 3rem;
        }
        
        .timeline::before {
            content: '';
            position: absolute;
            left: 1rem;
            top: 0;
            bottom: 0;
            width: 2px;
            background: var(--primary-blue);
        }
        
        .timeline-item {
            position: relative;
            margin-bottom: 2.5rem;
        }
        
        .timeline-item::before {
            content: '';
            position: absolute;
            left: -3rem;
            top: 0.25rem;
            width: 1.5rem;
            height: 1.5rem;
            border-radius: 50%;
            background: var(--white);
            border: 3px solid var(--primary-blue);
        }
        
        .download-cta {
            background: linear-gradient(135deg, var(--secondary-teal), #0f766e);
            border-radius: 12px;
            overflow: hidden;
            position: relative;
        }
        
        .download-cta::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: url('https://images.unsplash.com/photo-1635070041078-e363dbe005cb?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80') no-repeat center center/cover;
            opacity: 0.1;
            z-index: 0;
        }
        
        .download-cta .row {
            position: relative;
            z-index: 1;
        }
        
        .audit-card {
            transition: all 0.3s ease;
            border-radius: 12px;
            overflow: hidden;
            position: relative;
        }
        
        .audit-card::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: var(--primary-blue);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
        }
        
        .audit-card:hover {
            transform: translateY(-5px);
        }
        
        .audit-card:hover::after {
            transform: scaleX(1);
        }
        
        .form-control {
            border-radius: 8px;
            padding: 0.75rem 1.25rem;
            border: 2px solid #e5e7eb;
        }
        
        .form-control:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(37,99,235,0.2);
        }
        
        .btn-light {
            transition: all 0.3s ease;
        }
        
        .btn-light:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
        }
        
        .floating-shape {
            position: absolute;
            border-radius: 50%;
            opacity: 0.1;
            z-index: 0;
        }
        
        .shape-1 {
            width: 300px;
            height: 300px;
            background: var(--primary-blue);
            top: -150px;
            right: -150px;
        }
        
        .shape-2 {
            width: 200px;
            height: 200px;
            background: var(--accent-red);
            bottom: -100px;
            left: -100px;
        }
        
        @media (max-width: 768px) {
            .security-hero {
                padding: 3rem 0;
            }
            
            .timeline {
                padding-left: 2rem;
            }
            
            .timeline::before {
                left: 0.5rem;
            }
            
            .timeline-item::before {
                left: -2rem;
            }
            
            .download-cta .row {
                flex-direction: column;
                text-align: center;
            }
            
            .download-cta .text-lg-end {
                text-align: center !important;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <?php include 'includes/header.php'; ?>

    <!-- Hero Section -->
    <section class="security-hero">
        <div class="floating-shape shape-1"></div>
        <div class="floating-shape shape-2"></div>
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-8 mx-auto text-center">
                    <span class="security-badge">
                        <i class="fas fa-shield-alt me-2"></i>SECURITY WHITEPAPER
                    </span>
                    <h1 class="display-4 fw-bold mb-4">HealthSync Security Framework</h1>
                    <p class="lead mb-5">Comprehensive protection for healthcare data with military-grade encryption and compliance with global standards.</p>
                    <!-- <div class="d-flex gap-3 justify-content-center flex-wrap">
                        <a href="#download" class="btn btn-light btn-lg px-4 py-3">
                            <i class="fas fa-download me-2"></i>Download PDF
                        </a> 
                        <a href="#overview" class="btn btn-outline-light btn-lg px-4 py-3">
                            <i class="fas fa-book-open me-2"></i>Read Online
                        </a>
                    </div> -->
                </div>
            </div>
        </div>
    </section>

    <!-- Security Overview -->
    <section id="overview" class="py-5 bg-white position-relative">
        <div class="container py-5">
            <div class="row mb-5">
                <div class="col-lg-10 mx-auto text-center">
                    <h2 class="fw-bold mb-3">Healthcare Data Protection Redefined</h2>
                    <p class="lead text-muted">HealthSync implements a multi-layered security approach to safeguard sensitive patient information across all touchpoints.</p>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="h-100 p-4 feature-card bg-white">
                        <div class="feature-icon">
                            <i class="fas fa-lock"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Encryption</h4>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>AES-256 encryption</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>TLS 1.3 for data in transit</li>
                            <li><i class="fas fa-check-circle text-success me-2"></i>FIPS 140-2 validated modules</li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-3">
                    <div class="h-100 p-4 feature-card bg-white">
                        <div class="feature-icon">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Access Control</h4>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Role-based permissions</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Biometric authentication</li>
                            <li><i class="fas fa-check-circle text-success me-2"></i>Just-in-time access provisioning</li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-3">
                    <div class="h-100 p-4 feature-card bg-white">
                        <div class="feature-icon">
                            <i class="fas fa-cloud-shield-alt"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Infrastructure</h4>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>SOC 2 Type II certified</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Zero-trust architecture</li>
                            <li><i class="fas fa-check-circle text-success me-2"></i>Geographically redundant backups</li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-3">
                    <div class="h-100 p-4 feature-card bg-white">
                        <div class="feature-icon">
                            <i class="fas fa-search-plus"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Monitoring</h4>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>24/7 security operations</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Real-time anomaly detection</li>
                            <li><i class="fas fa-check-circle text-success me-2"></i>Automated threat response</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Compliance Standards -->
    <section class="py-5 bg-light position-relative">
        <div class="container py-5">
            <div class="row mb-5">
                <div class="col-lg-8 mx-auto text-center">
                    <img src="https://cdn-icons-png.flaticon.com/512/1570/1570887.png" alt="Certification Icon" width="80" class="mb-4">
                    <h2 class="fw-bold mb-3">Certifications & Compliance</h2>
                    <p class="lead text-muted">Meeting the highest standards for healthcare data protection and privacy regulations worldwide.</p>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="compliance-card p-4 bg-white h-100">
                        <div class="card-content">
                            <div class="d-flex align-items-center mb-3">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a2/HIPAA_Logo.svg/1200px-HIPAA_Logo.svg.png" alt="HIPAA" class="me-3" width="60">
                                <h4 class="fw-bold mb-0">HIPAA</h4>
                            </div>
                            <p>Full compliance with the Health Insurance Portability and Accountability Act requirements for protected health information (PHI).</p>
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="fas fa-check text-primary me-2"></i>Business Associate Agreement</li>
                                <li class="mb-2"><i class="fas fa-check text-primary me-2"></i>Audit controls</li>
                                <li><i class="fas fa-check text-primary me-2"></i>Breach notification</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="compliance-card p-4 bg-white h-100">
                        <div class="card-content">
                            <div class="d-flex align-items-center mb-3">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5e/GDPR_Logo.svg/2560px-GDPR_Logo.svg.png" alt="GDPR" class="me-3" width="60">
                                <h4 class="fw-bold mb-0">GDPR</h4>
                            </div>
                            <p>Adherence to the General Data Protection Regulation for EU patient data with strict privacy controls.</p>
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="fas fa-check text-primary me-2"></i>Data protection impact assessments</li>
                                <li class="mb-2"><i class="fas fa-check text-primary me-2"></i>Right to erasure</li>
                                <li><i class="fas fa-check text-primary me-2"></i>Data portability</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4 mx-auto">
                    <div class="compliance-card p-4 bg-white h-100">
                        <div class="card-content">
                            <div class="d-flex align-items-center mb-3">
                                <img src="https://www.hitrustalliance.net/content/uploads/2021/03/HITRUST_Logo_Blue-1.png" alt="HITRUST" class="me-3" width="60">
                                <h4 class="fw-bold mb-0">HITRUST CSF</h4>
                            </div>
                            <p>Certified against the HITRUST Common Security Framework for comprehensive healthcare security.</p>
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="fas fa-check text-primary me-2"></i>Risk management</li>
                                <li class="mb-2"><i class="fas fa-check text-primary me-2"></i>Information protection</li>
                                <li><i class="fas fa-check text-primary me-2"></i>Third-party assurance</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Technical Architecture -->
    <section class="py-5 bg-white">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <h2 class="fw-bold mb-4">Secure Architecture Design</h2>
                    <p class="mb-4">HealthSync's infrastructure is built with security as the foundation, not an afterthought.</p>
                    
                    <div class="timeline">
                        <div class="timeline-item mb-4">
                            <h5 class="fw-bold">Data Encryption Layer</h5>
                            <p>All data encrypted at rest using AES-256 with regularly rotated keys managed through AWS KMS.</p>
                        </div>
                        
                        <div class="timeline-item mb-4">
                            <h5 class="fw-bold">Network Protection</h5>
                            <p>VPC isolation, WAF protection, and DDoS mitigation with Cloudflare enterprise protection.</p>
                        </div>
                        
                        <div class="timeline-item">
                            <h5 class="fw-bold">Application Security</h5>
                            <p>OWASP Top 10 protections, automated vulnerability scanning, and code reviews.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" alt="HealthSync Security Architecture" class="img-fluid architecture-diagram">
                </div>
            </div>
        </div>
    </section>

    <!-- Audit & Testing -->
    <section class="py-5 bg-dark text-white position-relative">
        <div class="container py-5">
            <div class="row mb-5">
                <div class="col-lg-8 mx-auto text-center">
                    <img src="https://cdn-icons-png.flaticon.com/512/1570/1570887.png" alt="Audit Icon" width="80" class="mb-4 filter-invert">
                    <h2 class="fw-bold mb-3">Third-Party Validation</h2>
                    <p class="lead opacity-75">Regular independent audits verify our security controls and processes.</p>
                </div>
            </div>
            
            <div class="row g-4 text-center">
                <div class="col-md-4">
                    <div class="p-4 bg-gray-800 rounded audit-card h-100">
                        <i class="fas fa-search-dollar display-4 text-primary mb-3"></i>
                        <h4 class="fw-bold mb-3">Penetration Testing</h4>
                        <p>Quarterly tests by CREST-certified ethical hackers simulate real-world attacks.</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="p-4 bg-gray-800 rounded audit-card h-100">
                        <i class="fas fa-clipboard-check display-4 text-primary mb-3"></i>
                        <h4 class="fw-bold mb-3">SOC 2 Audits</h4>
                        <p>Annual Type II examinations covering security, availability, and confidentiality.</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="p-4 bg-gray-800 rounded audit-card h-100">
                        <i class="fas fa-bug display-4 text-primary mb-3"></i>
                        <h4 class="fw-bold mb-3">Bug Bounty</h4>
                        <p>Public program paying researchers for identifying vulnerabilities.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            });
        });
        
        // Form validation
        document.querySelector('.whitepaper-form').addEventListener('submit', function(e) {
            const email = this.querySelector('input[type="email"]').value;
            if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                e.preventDefault();
                alert('Please enter a valid email address.');
            } else {
                // Here you would typically submit the form or send the data to your server
                alert('Thank you! Your whitepaper download will begin shortly.');
            }
        });
        
        // Animation on scroll
        document.addEventListener('DOMContentLoaded', function() {
            const animateOnScroll = function() {
                const elements = document.querySelectorAll('.feature-card, .compliance-card, .audit-card');
                
                elements.forEach(element => {
                    const elementPosition = element.getBoundingClientRect().top;
                    const windowHeight = window.innerHeight;
                    
                    if (elementPosition < windowHeight - 100) {
                        element.style.opacity = '1';
                        element.style.transform = 'translateY(0)';
                    }
                });
            };
            
            // Initialize elements with opacity 0 and slightly translated
            const cards = document.querySelectorAll('.feature-card, .compliance-card, .audit-card');
            cards.forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'all 0.6s ease';
            });
            
            window.addEventListener('scroll', animateOnScroll);
            animateOnScroll(); // Run once on load
        });
    </script>

<?php include 'includes/chatbot.php'; ?>
</body>
</html>