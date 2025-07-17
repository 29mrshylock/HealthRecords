<?php
session_start(); // Session start

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $conn = new mysqli('localhost', 'root', '', 'healthsync');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // --- Patient Table Check ---
    $sql_patient = "SELECT * FROM patient WHERE email = ?";
    $stmt_patient = $conn->prepare($sql_patient);
    $stmt_patient->bind_param("s", $email);
    $stmt_patient->execute();
    $result_patient = $stmt_patient->get_result();

    if ($result_patient->num_rows > 0) {
        $row = $result_patient->fetch_assoc();
        
        if ($password === $row['password']) {
            $_SESSION['email'] = $row['email'];
            $_SESSION['patient_id'] = $row['id']; 
            header('Location: Main.php');
            exit();
        } else {
            echo "Invalid credentials.";
            exit();
        }
    }
    $stmt_patient->close();

    // --- Doctors Table Check ---
    $sql_doctor = "SELECT * FROM doctors WHERE email = ?";
    $stmt_doctor = $conn->prepare($sql_doctor);
    $stmt_doctor->bind_param("s", $email);
    $stmt_doctor->execute();
    $result_doctor = $stmt_doctor->get_result();

    if ($result_doctor->num_rows > 0) {
        $row = $result_doctor->fetch_assoc();

        // Plain text password comparison
        if ($password === $row['password']) {
            $_SESSION['doctor_id'] = $row['id'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['fullname'] = $row['fullname'];

            header('Location: profile.php?id=' . $row['id']);
            exit();
        } else {
            echo "Invalid credentials.";
            exit();
        }
    }
    $stmt_doctor->close();

    // --- If neither patient nor doctor found ---
    echo "Invalid credentials.";
    $conn->close();
}
?>





<!-- Login Form -->
<!-- <form method="POST" action="login.php">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
</form> -->


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Healthcare Portal - Login</title>
  <!-- Favicon properly placed in head section -->
  <link rel="icon" href="img/HealthSync.png" type="image/png">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="css/header-footer.css">
  <style>
    :root {
      --doctor-color: #3498db;
      --patient-color: #2ecc71;
      --error-color: #e74c3c;
      --success-color: #2ecc71;
      --text-color: #2c3e50;
      --light-gray: #ecf0f1;
      --white: #ffffff;
      --primary-bg: #f5f7fa;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: var(--primary-bg);
      min-height: 100vh;
      color: var(--text-color);
      background-image: url('https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80');
      background-size: cover;
      background-position: center;
      background-blend-mode: overlay;
      background-color: rgba(0, 0, 0, 0.5);
      display: flex;
      flex-direction: column;
    }

    /* Login Container */
    .login-container {
      width: 100%;
      max-width: 450px;
      background-color: var(--white);
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
      margin: 100px auto 50px;
      overflow: hidden;
    }

    .login-header {
      padding: 30px;
      text-align: center;
      background: linear-gradient(135deg, var(--doctor-color), var(--patient-color));
      color: var(--white);
    }

    .login-header h1 {
      font-size: 1.75rem;
      margin-bottom: 10px;
    }

    .login-header p {
      font-size: 0.875rem;
      opacity: 0.9;
    }

    .tabs {
      display: flex;
      border-bottom: 1px solid var(--light-gray);
    }

    .tab {
      flex: 1;
      padding: 15px;
      text-align: center;
      cursor: pointer;
      transition: all 0.3s ease;
      font-weight: 600;
      position: relative;
    }

    .tab.doctor-tab {
      color: var(--doctor-color);
    }

    .tab.patient-tab {
      color: var(--patient-color);
    }

    .tab.active {
      background-color: rgba(0, 0, 0, 0.05);
    }

    .tab.active.doctor-tab::after {
      content: '';
      position: absolute;
      bottom: -1px;
      left: 0;
      width: 100%;
      height: 3px;
      background-color: var(--doctor-color);
    }

    .tab.active.patient-tab::after {
      content: '';
      position: absolute;
      bottom: -1px;
      left: 0;
      width: 100%;
      height: 3px;
      background-color: var(--patient-color);
    }

    .form-container {
      padding: 30px;
    }

    .login-form {
      display: none;
    }

    .login-form.active {
      display: block;
      animation: fadeIn 0.5s ease;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .input-group {
      margin-bottom: 20px;
      position: relative;
    }

    .input-group label {
      display: block;
      margin-bottom: 8px;
      font-weight: 600;
      font-size: 0.875rem;
    }

    .input-group input {
      width: 100%;
      padding: 12px 45px 12px 45px;
      border: 1px solid var(--light-gray);
      border-radius: 8px;
      font-size: 1rem;
      transition: all 0.3s ease;
    }

    .input-group input:focus {
      border-color: var(--doctor-color);
      box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
      outline: none;
    }

    .input-group i {
      position: absolute;
      left: 15px;
      top: 70%;
      transform: translateY(-50%);
      color: #7f8c8d;
      font-size: 1rem;
    }

    .password-toggle {
      position: absolute;
      right: 15px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      color: #7f8c8d;
      font-size: 1rem;
    }

    .options {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
      font-size: 0.875rem;
    }

    .remember-me {
      display: flex;
      align-items: center;
    }

    .remember-me input {
      margin-right: 8px;
    }

    .forgot-password a {
      color: var(--doctor-color);
      text-decoration: none;
      transition: color 0.3s ease;
    }

    .forgot-password a:hover {
      text-decoration: underline;
    }

    .login-btn {
      width: 100%;
      padding: 14px;
      border: none;
      border-radius: 8px;
      background-color: var(--doctor-color);
      color: var(--white);
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      margin-bottom: 20px;
    }

    .login-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
    }

    .patient-form .login-btn {
      background-color: var(--patient-color);
    }

    .patient-form .login-btn:hover {
      box-shadow: 0 5px 15px rgba(46, 204, 113, 0.3);
    }

    .patient-form .input-group input:focus {
      border-color: var(--patient-color);
      box-shadow: 0 0 0 3px rgba(46, 204, 113, 0.2);
    }

    .divider {
      display: flex;
      align-items: center;
      margin: 20px 0;
    }

    .divider::before,
    .divider::after {
      content: '';
      flex: 1;
      border-bottom: 1px solid var(--light-gray);
    }

    .divider span {
      padding: 0 15px;
      color: #7f8c8d;
      font-size: 0.875rem;
    }

    .social-login {
      display: flex;
      justify-content: center;
      gap: 15px;
      margin-bottom: 20px;
    }

    .social-btn {
      width: 45px;
      height: 45px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--white);
      font-size: 1.125rem;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .social-btn.google {
      background-color: #db4437;
    }

    .social-btn.facebook {
      background-color: #4267b2;
    }

    .social-btn.apple {
      background-color: #000000;
    }

    .social-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .register-link {
      text-align: center;
      font-size: 0.875rem;
    }

    .register-link a {
      color: var(--doctor-color);
      text-decoration: none;
      font-weight: 600;
    }

    .register-link a:hover {
      text-decoration: underline;
    }

    .error-message {
      color: var(--error-color);
      font-size: 0.8125rem;
      margin-top: 5px;
      display: none;
    }

    /* Ensure footer sticks to bottom */
    .digital-health-footer {
      margin-top: auto;
    }

    /* Responsive Design */
    @media (max-width: 480px) {
      .login-container {
        margin: 80px 10px 20px;
        border-radius: 10px;
      }

      .login-header {
        padding: 20px;
      }

      .form-container {
        padding: 20px;
      }

      .tab {
        padding: 12px;
        font-size: 0.875rem;
      }
    }
  </style>
</head>

<body>
  <!-- Header/Navbar -->

  <?php include 'includes/header.php'; ?>

  <!-- Login Container -->
  <div class="login-container">
    <div class="login-header">
      <h1>Welcome Back!</h1>
      <p>Access your Digital Health portal</p>
    </div>

    <div class="tabs">
      <div class="tab doctor-tab active" onclick="switchTab('doctor')">
        <i class="fas fa-user-md"></i> Doctor
      </div>
      <div class="tab patient-tab" onclick="switchTab('patient')">
        <i class="fas fa-user-injured"></i> Patient
      </div>
    </div>

    <div class="form-container">
      <!-- Doctor Login Form -->
      <form id="doctorForm" class="login-form active" action="#" method="POST">
        <div class="input-group">
          <label for="doctorEmail">Email Address</label>
          <i class="fas fa-envelope"></i>
          <input type="email" id="doctorEmail" name="email" placeholder="doctor@example.com" required>
          <div class="error-message" id="doctorEmailError">Please enter a valid email address</div>
        </div>

        <div class="input-group">
          <label for="doctorPassword">Password</label>
          <i class="fas fa-lock"></i>
          <input type="password" id="doctorPassword" name="password" placeholder="Enter your password" required>
          <i class="fas fa-eye password-toggle" onclick="togglePassword('doctorPassword')"></i>
          <div class="error-message" id="doctorPasswordError">Password must be at least 8 characters</div>
        </div>

        <div class="options">
          <div class="remember-me">
            <input type="checkbox" id="rememberDoctor" name="remember">
            <label for="rememberDoctor">Remember me</label>
          </div>
          <div class="forgot-password">
            <a href="forgot-password.php?type=doctor">Forgot Password?</a>
          </div>
        </div>

        <button type="submit" class="login-btn">Login as Doctor</button>

        <div class="divider"><span>OR</span></div>

        <div class="social-login">
          <div class="social-btn google" title="Login with Google" data-bs-toggle="tooltip">
            <i class="fab fa-google"></i>
          </div>
          <div class="social-btn facebook" title="Login with Facebook" data-bs-toggle="tooltip">
            <i class="fab fa-facebook-f"></i>
          </div>
          <div class="social-btn apple" title="Login with Apple" data-bs-toggle="tooltip">
            <i class="fab fa-apple"></i>
          </div>
        </div>

        <div class="register-link">
          New to Digital Health? <a href="doctor_register.php">Register as Doctor</a>
        </div>
      </form>

      <!-- Patient Login Form -->
      <form id="patientForm" class="login-form patient-form" action="#" method="POST">
        <div class="input-group">
          <label for="patientEmail">Email Address</label>
          <i class="fas fa-envelope"></i>
          <input type="email" id="patientEmail" name="email" placeholder="patient@example.com" required>
          <div class="error-message" id="patientEmailError">Please enter a valid email address</div>
        </div>

        <div class="input-group">
          <label for="patientPassword">Password</label>
          <i class="fas fa-lock"></i>
          <input type="password" id="patientPassword" name="password" placeholder="Enter your password" required>
          <i class="fas fa-eye password-toggle" onclick="togglePassword('patientPassword')"></i>
          <div class="error-message" id="patientPasswordError">Password must be at least 8 characters</div>
        </div>

        <div class="options">
          <div class="remember-me">
            <input type="checkbox" id="rememberPatient" name="remember">
            <label for="rememberPatient">Remember me</label>
          </div>
          <div class="forgot-password">
            <a href="forgot-password.php?type=patient">Forgot Password?</a>
          </div>
        </div>

        <button type="submit" class="login-btn">Login as Patient</button>

        <div class="divider"><span>OR</span></div>

        <div class="social-login">
          <div class="social-btn google" title="Login with Google" data-bs-toggle="tooltip">
            <i class="fab fa-google"></i>
          </div>
          <div class="social-btn facebook" title="Login with Facebook" data-bs-toggle="tooltip">
            <i class="fab fa-facebook-f"></i>
          </div>
          <div class="social-btn apple" title="Login with Apple" data-bs-toggle="tooltip">
            <i class="fab fa-apple"></i>
          </div>
        </div>

        <div class="register-link">
          New to Digital Health? <a href="patient-register.php">Register as Patient</a>
        </div>
      </form>
    </div>
  </div>

  <!-- Footer -->
  
  <?php include 'includes/footer.php'; ?>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
      // Initialize Bootstrap tooltips
      var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
      var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
      });

      // Tab switching functionality
      function switchTab(tab) {
        const doctorTab = document.querySelector('.doctor-tab');
        const patientTab = document.querySelector('.patient-tab');
        const doctorForm = document.getElementById('doctorForm');
        const patientForm = document.getElementById('patientForm');

        if (tab === 'doctor') {
          doctorTab.classList.add('active');
          patientTab.classList.remove('active');
          doctorForm.classList.add('active');
          patientForm.classList.remove('active');
        } else {
          patientTab.classList.add('active');
          doctorTab.classList.remove('active');
          patientForm.classList.add('active');
          doctorForm.classList.remove('active');
        }
      }

      // Password toggle functionality
      function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        const icon = document.querySelector(`#${inputId} ~ .password-toggle`);
        if (input.type === 'password') {
          input.type = 'text';
          icon.classList.remove('fa-eye');
        } else {
          input.type = 'password';
          icon.classList.add('fa-eye');
        }
      }

      // Form validation
      const forms = document.querySelectorAll('.login-form');
      forms.forEach(form => {
        form.addEventListener('submit', function(e) {
          let isValid = true;
          const emailInput = form.querySelector('input[type="email"]');
          const passwordInput = form.querySelector('input[type="password"]');
          const emailError = form.querySelector('.error-message[id$="EmailError"]');
          const passwordError = form.querySelector('.error-message[id$="PasswordError"]');

          // Reset errors
          emailError.style.display = 'none';
          passwordError.style.display = 'none';
          emailInput.style.borderColor = '';
          passwordInput.style.borderColor = '';

          // Email validation
          if (!emailInput.value || !/^\S+@\S+\.\S+$/.test(emailInput.value)) {
            emailError.style.display = 'block';
            emailInput.style.borderColor = 'var(--error-color)';
            isValid = false;
          }

          // Password validation
          if (!passwordInput.value) {
            passwordError.style.display = 'block';
            passwordInput.style.borderColor = 'var(--error-color)';
            isValid = false;
          }

          if (!isValid) {
            e.preventDefault();
          }
        });
      });

      // Social buttons functionality
      const socialButtons = document.querySelectorAll('.social-btn');
      socialButtons.forEach(button => {
        button.addEventListener('click', function() {
          const type = button.classList.contains('google') ? 'Google' :
            button.classList.contains('facebook') ? 'Facebook' : 'Apple';
          alert(`Redirecting to ${type} login...`);
        });
      });

      // Make tab switching and password toggle functions global
      window.switchTab = switchTab;
      window.togglePassword = togglePassword;
    });
  </script>


<?php include 'includes/chatbot.php'; ?>
</body>

</html>