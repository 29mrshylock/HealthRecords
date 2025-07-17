<?php
include 'includes/header.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pricing - HealthSync</title>
    <link rel="icon" href="img/HealthSync.png" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Affordable pricing plans for HealthSync, your digital health partner. Choose the best plan for your needs.">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            --font-family: 'Poppins', sans-serif;
            --font-size-base: 16px;
            --spacing-xs: 8px;
            --spacing-sm: 16px;
            --spacing-md: 24px;
            --spacing-lg: 32px;
            --spacing-xl: 48px;
        }
        
        body {
            font-family: var(--font-family);
            color: var(--text-dark);
            background-color: var(--neutral-gray);
            line-height: 1.6;
        }
        
        .pricing-hero {
            background: linear-gradient(135deg, var(--primary-blue), #2A75B3);
            color: white;
            border-radius: 12px;
            padding: var(--spacing-xl);
            margin-bottom: var(--spacing-xl);
            box-shadow: var(--shadow);
            text-align: center;
        }
        
        .pricing-card {
            background: var(--bg-white);
            border-radius: 12px;
            border: none;
            transition: var(--transition);
            overflow: hidden;
            height: 100%;
            box-shadow: var(--shadow);
            position: relative;
        }
        
        .pricing-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        }
        
        .popular-tag {
            position: absolute;
            top: 0;
            right: var(--spacing-md);
            background-color: var(--highlight-gold);
            color: var(--text-dark);
            padding: var(--spacing-xs) var(--spacing-sm);
            font-size: 0.8rem;
            font-weight: 600;
            border-bottom-left-radius: 6px;
            border-bottom-right-radius: 6px;
            box-shadow: var(--shadow);
        }
        
        .pricing-card.featured {
            border: 2px solid var(--primary-blue);
            box-shadow: var(--glow);
        }
        
        .price {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-blue);
            margin: var(--spacing-md) 0;
        }
        
        .price-period {
            font-size: 1rem;
            color: var(--text-dark);
            opacity: 0.7;
        }
        
        .feature-list {
            margin: var(--spacing-lg) 0;
        }
        
        .feature-list li {
            padding: var(--spacing-xs) 0;
            display: flex;
            align-items: center;
        }
        
        .feature-list i {
            color: var(--secondary-green);
            margin-right: var(--spacing-xs);
            font-size: 1.1rem;
        }
        
        .btn-primary {
            background-color: var(--primary-blue);
            border-color: var(--primary-blue);
            padding: var(--spacing-xs) var(--spacing-lg);
            font-weight: 500;
            border-radius: 8px;
            transition: var(--transition);
        }
        
        .btn-primary:hover {
            background-color: #3A7BC8;
            border-color: #3A7BC8;
            transform: translateY(-2px);
        }
        
        .btn-outline {
            border: 2px solid var(--primary-blue);
            color: var(--primary-blue);
            background: transparent;
            font-weight: 500;
        }
        
        .btn-outline:hover {
            background-color: var(--primary-blue);
            color: white;
        }
        
        .comparison-table {
            background: var(--bg-white);
            border-radius: 12px;
            padding: var(--spacing-lg);
            margin-top: var(--spacing-xl);
            box-shadow: var(--shadow);
        }
        
        .table th {
            background-color: var(--primary-blue);
            color: white;
        }
        
        .faq-section {
            background-color: var(--bg-white);
            border-radius: 12px;
            padding: var(--spacing-xl);
            margin-top: var(--spacing-xl);
            box-shadow: var(--shadow);
        }
        
        .faq-card {
            border-left: 4px solid var(--primary-blue);
            border-radius: 0 8px 8px 0;
            margin-bottom: var(--spacing-md);
            transition: var(--transition);
        }
        
        .faq-card:hover {
            transform: translateX(5px);
        }
        
        .toggle-switch {
            background-color: #E2E8F0;
            border-radius: 50px;
            padding: 5px;
            display: inline-flex;
            margin: var(--spacing-md) 0;
        }
        
        .toggle-switch button {
            border: none;
            padding: var(--spacing-xs) var(--spacing-lg);
            border-radius: 50px;
            font-weight: 500;
            transition: var(--transition);
        }
        
        .toggle-switch button.active {
            background-color: var(--primary-blue);
            color: white;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <!-- Hero Section -->
    <div class="pricing-hero">
        <h1 class="fw-bold mb-3">Healthcare Solutions for Every Practice</h1>
        <p class="lead mb-4">Choose the perfect plan for your medical practice with our transparent pricing</p>
        
        <div class="toggle-switch">
            <button class="active">Monthly Billing</button>
            <button>Annual Billing (Save 20%)</button>
        </div>
    </div>
    
    <!-- Pricing Cards -->
    <div class="row g-4">
        <!-- Basic Plan -->
        <div class="col-lg-4">
            <div class="pricing-card p-4">
                <h4 class="fw-semibold">Starter</h4>
                <div class="price">₹499<span class="price-period">/month</span></div>
                <p class="text-muted">For individual practitioners</p>
                <ul class="feature-list list-unstyled">
                    <li><i class="fas fa-check"></i> 1 Doctor Profile</li>
                    <li><i class="fas fa-check"></i> 100 Patient Records</li>
                    <li><i class="fas fa-check"></i> Basic Analytics</li>
                    <li><i class="fas fa-check"></i> Email Support</li>
                    <li><i class="fas fa-check"></i> HealthSync Branding</li>
                </ul>
                <a href="#" class="btn btn-outline w-100">Start Free Trial</a>
            </div>
        </div>
        
        <!-- Standard Plan (Featured) -->
        <div class="col-lg-4">
            <div class="pricing-card p-4 featured">
                <div class="popular-tag">RECOMMENDED</div>
                <h4 class="fw-semibold">Professional</h4>
                <div class="price">₹1499<span class="price-period">/month</span></div>
                <p class="text-muted">For growing clinics</p>
                <ul class="feature-list list-unstyled">
                    <li><i class="fas fa-check"></i> Up to 5 Doctors</li>
                    <li><i class="fas fa-check"></i> Unlimited Patients</li>
                    <li><i class="fas fa-check"></i> Appointment Scheduling</li>
                    <li><i class="fas fa-check"></i> Telemedicine Integration</li>
                    <li><i class="fas fa-check"></i> Priority Support</li>
                    <li><i class="fas fa-check"></i> Custom Branding</li>
                </ul>
                <a href="#" class="btn btn-primary w-100">Get Started</a>
            </div>
        </div>
        
        <!-- Premium Plan -->
        <div class="col-lg-4">
            <div class="pricing-card p-4">
                <h4 class="fw-semibold">Enterprise</h4>
                <div class="price">₹2999<span class="price-period">/month</span></div>
                <p class="text-muted">For hospitals & chains</p>
                <ul class="feature-list list-unstyled">
                    <li><i class="fas fa-check"></i> Unlimited Doctors</li>
                    <li><i class="fas fa-check"></i> Advanced Analytics</li>
                    <li><i class="fas fa-check"></i> 24/7 Support</li>
                    <li><i class="fas fa-check"></i> API Access</li>
                    <li><i class="fas fa-check"></i> Dedicated Account Manager</li>
                    <li><i class="fas fa-check"></i> White-label Solution</li>
                </ul>
                <a href="#" class="btn btn-outline w-100">Contact Sales</a>
            </div>
        </div>
    </div>
    
    <!-- Feature Comparison -->
    <div class="comparison-table">
        <h3 class="text-center mb-4 fw-bold">Feature Comparison</h3>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 30%">Features</th>
                        <th class="text-center">Starter</th>
                        <th class="text-center">Professional</th>
                        <th class="text-center">Enterprise</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Doctor Profiles</td>
                        <td class="text-center">1</td>
                        <td class="text-center">5</td>
                        <td class="text-center">Unlimited</td>
                    </tr>
                    <tr>
                        <td>Patient Management</td>
                        <td class="text-center"><i class="fas fa-check text-success"></i></td>
                        <td class="text-center"><i class="fas fa-check text-success"></i></td>
                        <td class="text-center"><i class="fas fa-check text-success"></i></td>
                    </tr>
                    <tr>
                        <td>Appointment System</td>
                        <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                        <td class="text-center"><i class="fas fa-check text-success"></i></td>
                        <td class="text-center"><i class="fas fa-check text-success"></i></td>
                    </tr>
                    <tr>
                        <td>Telemedicine</td>
                        <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                        <td class="text-center"><i class="fas fa-check text-success"></i></td>
                        <td class="text-center"><i class="fas fa-check text-success"></i></td>
                    </tr>
                    <tr>
                        <td>Support</td>
                        <td class="text-center">Email</td>
                        <td class="text-center">Priority</td>
                        <td class="text-center">24/7 Dedicated</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- FAQ Section -->
    <div class="faq-section">
        <h3 class="text-center mb-5 fw-bold">Frequently Asked Questions</h3>
        <div class="row">
            <div class="col-md-6">
                <div class="faq-card card mb-3">
                    <div class="card-body">
                        <h5><i class="fas fa-question-circle text-primary-blue me-2"></i> Can I upgrade/downgrade anytime?</h5>
                        <p class="text-muted">Yes, you can change plans at any time. We'll automatically prorate your bill.</p>
                    </div>
                </div>
                
                <div class="faq-card card mb-3">
                    <div class="card-body">
                        <h5><i class="fas fa-question-circle text-primary-blue me-2"></i> Is my patient data secure?</h5>
                        <p class="text-muted">We use HIPAA-compliant encryption and regular security audits to protect all health data.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="faq-card card mb-3">
                    <div class="card-body">
                        <h5><i class="fas fa-question-circle text-primary-blue me-2"></i> Do you offer discounts?</h5>
                        <p class="text-muted">Non-profits and educational institutions receive 15% off. Annual plans save 20%.</p>
                    </div>
                </div>
                
                <div class="faq-card card mb-3">
                    <div class="card-body">
                        <h5><i class="fas fa-question-circle text-primary-blue me-2"></i> How do I cancel my subscription?</h5>
                        <p class="text-muted">You can cancel anytime from your account settings with no cancellation fees.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- CTA Section -->
    <div class="text-center mt-5">
        <h4 class="fw-bold mb-3">Still have questions?</h4>
        <p class="mb-4">Our team is ready to help you choose the right solution for your practice.</p>
        <a href="#" class="btn btn-primary btn-lg px-4 me-3"><i class="fas fa-phone-alt me-2"></i>Contact Sales</a>
        <a href="#" class="btn btn-outline btn-lg px-4"><i class="fas fa-comments me-2"></i>Live Chat</a>
    </div>
</div>

<?php
include 'includes/footer.php'; 
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Toggle switch functionality
    document.querySelectorAll('.toggle-switch button').forEach(button => {
        button.addEventListener('click', function() {
            document.querySelector('.toggle-switch button.active').classList.remove('active');
            this.classList.add('active');
            
            // Here you would add logic to toggle between monthly/annual pricing
        });
    });
    
    // Animation for cards on scroll
    const animateOnScroll = () => {
        const cards = document.querySelectorAll('.pricing-card');
        cards.forEach((card, index) => {
            const cardPosition = card.getBoundingClientRect().top;
            const screenPosition = window.innerHeight / 1.3;
            
            if(cardPosition < screenPosition) {
                card.style.transitionDelay = `${index * 0.1}s`;
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }
        });
    };
    
    // Set initial state
    window.addEventListener('load', () => {
        document.querySelectorAll('.pricing-card').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'all 0.5s ease';
        });
    });
    
    // Add scroll event listener
    window.addEventListener('scroll', animateOnScroll);
    // Trigger once on load in case cards are already visible
    animateOnScroll();
</script>

<?php include 'includes/chatbot.php'; ?>
</body>
</html>