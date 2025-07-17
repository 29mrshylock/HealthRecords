<?php
// Contact Page with PHP and SQL
// include("includes/header.php");

// Database Connection
$conn = new mysqli('localhost', 'root', '', 'healthsync'); // <-- Update database details here

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $subject = $conn->real_escape_string($_POST['subject']);
    $message = $conn->real_escape_string($_POST['message']);

    // Insert Query
    $sql = "INSERT INTO contacts (name, email, subject, message, created_at) VALUES ('$name', '$email', '$subject', '$message', NOW())";

    if ($conn->query($sql) === TRUE) {
        $success = true;
    } else {
        echo "Error: " . $conn->error;
    }
}

?>


<?php include("includes/header.php"); ?>

<div class="container">
  <h2>📞 Contact Digital Health Records</h2>

  <?php if (!empty($success)): ?>
    <div class="success">✅ Your message has been sent. We'll get back to you soon.</div>
  <?php endif; ?>

  <div class="contact-grid">
    <!-- Contact Form -->
    <div class="contact-form">
      <form method="POST" action="">
        <label for="name">Full Name</label>
        <input type="text" name="name" required>

        <label for="email">Email</label>
        <input type="email" name="email" required>

        <label for="subject">Subject</label>
        <input type="text" name="subject" required>

        <label for="message">Message</label>
        <textarea name="message" rows="5" required></textarea>

        <button type="submit"><i class="fas fa-paper-plane"></i> Send Message</button>
      </form>
    </div>

    <!-- Contact Info -->
    <div class="contact-info">
      <div class="info-box">
        <h4>🏢 Office Address</h4>
        <p>Digital Health Records</p>
        <p>Near Civil Lines, Prayagraj, Uttar Pradesh - 211001</p>

        <h4>📞 Contact</h4>
        <p><strong>Phone:</strong> +91-9876543210</p>
        <p><strong>Email:</strong> support@digitalhealth.in</p>

        <h4>🕒 Office Hours</h4>
        <p>Mon - Sat: 9:00 AM to 6:00 PM</p>
      </div>

      <!-- Google Map (Prayagraj) -->
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14306.566103802574!2d81.8381910624603!3d25.45601154198652!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x398535087408457b%3A0x17df46fa261c5c82!2sCivil%20Lines%2C%20Prayagraj%2C%20Uttar%20Pradesh!5e0!3m2!1sen!2sin!4v1713422381000!5m2!1sen!2sin" allowfullscreen="" loading="lazy"></iframe>
    </div>
  </div>
</div>

<!-- WhatsApp Floating Button -->
<a href="https://wa.me/919876543210" class="whatsapp-button" target="_blank">
  <i class="fab fa-whatsapp"></i> Chat with Us
</a>

<?php include("includes/footer.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="icon" href="img/HealthSync.png" type="image/png">

    <style>
        body {
  margin: 0;
  font-family: 'Segoe UI', sans-serif;
  background: #f7fbff;
  color: #333;
}

.container {
  max-width: 1150px;
  margin: auto;
  padding: 40px 20px;
}

h2 {
  text-align: center;
  color: #007bff;
  margin-bottom: 20px;
  font-size: 32px;
}

.contact-grid {
  display: flex;
  flex-wrap: wrap;
  gap: 30px;
}

.contact-form, .contact-info {
  flex: 1;
  min-width: 300px;
  background: white;
  padding: 30px;
  border-radius: 10px;
  box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
}

.contact-form form label {
  display: block;
  margin-top: 15px;
  font-weight: 500;
}

input, textarea {
  width: 100%;
  padding: 12px;
  margin-top: 8px;
  border: 1px solid #ccc;
  border-radius: 6px;
  font-size: 15px;
}

button {
  margin-top: 20px;
  background: #28a745;
  color: #fff;
  border: none;
  padding: 12px 20px;
  font-size: 16px;
  border-radius: 6px;
  cursor: pointer;
  transition: background 0.3s ease;
}

button:hover {
  background: #218838;
}

.success {
  background: #d4edda;
  padding: 10px;
  color: #155724;
  border-left: 5px solid #28a745;
  border-radius: 6px;
  margin-bottom: 15px;
}

.info-box h4 {
  color: #007bff;
  margin-bottom: 10px;
  font-size: 18px;
}

.info-box p {
  margin: 5px 0;
  font-size: 15px;
}

iframe {
  width: 100%;
  height: 300px;
  border: 0;
  margin-top: 20px;
  border-radius: 10px;
}

.whatsapp-button {
  position: fixed;
  bottom: 20px;
  right: 20px;
  background-color: #25d366;
  color: #fff;
  padding: 12px 16px;
  border-radius: 50px;
  display: flex;
  align-items: center;
  gap: 8px;
  font-weight: bold;
  text-decoration: none;
  box-shadow: 0 4px 10px rgba(0,0,0,0.2);
  z-index: 999;
}

.whatsapp-button:hover {
  background-color: #1ebe57;
}

@media (max-width: 768px) {
  .contact-grid {
    flex-direction: column;
  }

  h2 {
    font-size: 26px;
  }

  .whatsapp-button {
    font-size: 14px;
    padding: 10px 14px;
  }
}

    </style>
</head>
<body>
    
</body>
</html>