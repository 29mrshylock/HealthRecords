<?php
// Database connection 

include 'includes/config.php';

$successMsg = "";
$errorMsg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Collect form data
  $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
  $gender = mysqli_real_escape_string($conn, $_POST['gender']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $phone = mysqli_real_escape_string($conn, $_POST['phone']);
  $address = mysqli_real_escape_string($conn, $_POST['address']);
  $specialty = mysqli_real_escape_string($conn, $_POST['specialty']);
  $license = mysqli_real_escape_string($conn, $_POST['license']);
  $experience = mysqli_real_escape_string($conn, $_POST['experience']);
  $availability = isset($_POST['availability']) ? implode(', ', $_POST['availability']) : '';
  $available_time = mysqli_real_escape_string($conn, $_POST['available-time']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);
  $confirm_password = $_POST['confirm-password'];

  if ($password !== $confirm_password) {
    $errorMsg = "Passwords do not match!";
  } else {
    // Store password as plain text (not secure in real-world applications)
    $photoName = $_FILES['photo']['name'];
    $photoTmp = $_FILES['photo']['tmp_name'];
    $photoPath = 'uploads/' . basename($photoName);

    if (!is_dir('uploads')) {
      mkdir('uploads', 0777, true);
    }

    if (move_uploaded_file($photoTmp, $photoPath)) {
      $sql = "INSERT INTO doctors (fullname, gender, email, phone, address, specilaty, license, experience, availability_days, availability_time, photo, password)
              VALUES ('$fullname', '$gender', '$email', '$phone', '$address', '$specialty', '$license', '$experience', '$availability', '$available_time', '$photoPath', '$password')";

      if (mysqli_query($conn, $sql)) {
        $successMsg = "Doctor registered successfully!";
      } else {
        $errorMsg = "Error inserting data: " . mysqli_error($conn);
      }
    } else {
      $errorMsg = "Failed to upload photo.";
    }
  }

}
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Doctor Registration Form</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <style>
    :root {
      --primary-blue: #4A90E2;
      /* Vibrant Blue */
      --secondary-green: #50C878;
      /* Fresh Green */
      --accent-coral: #FF6F61;
      /* Coral */
      --neutral-gray: #F7F9FC;
      /* Light Gray */
      --highlight-gold: #FFD700;
      /* Gold */
      --text-dark: #2D3748;
      /* Dark Gray */
      --bg-white: #FFFFFF;
      /* White */
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
      font-size: var(--font-size-base);
      line-height: 1.6;
      margin: 0;
      padding: var(--spacing-md);
      background-color: var(--neutral-gray);
      color: var(--text-dark);
    }

    .container {
      max-width: 800px;
      margin: 0 auto;
      background: var(--bg-white);
      padding: var(--spacing-lg);
      border-radius: 12px;
      box-shadow: var(--shadow);
    }

    h1 {
      text-align: center;
      color: var(--text-dark);
      margin-bottom: var(--spacing-lg);
      font-weight: 600;
    }

    .form-group {
      margin-bottom: var(--spacing-md);
    }

    label {
      display: block;
      margin-bottom: var(--spacing-xs);
      font-weight: 500;
      color: var(--text-dark);
    }

    input[type="text"],
    input[type="email"],
    input[type="tel"],
    input[type="password"],
    input[type="number"],
    textarea,
    select {
      width: 100%;
      padding: var(--spacing-sm);
      border: 1px solid var(--primary-blue);
      border-radius: 8px;
      box-sizing: border-box;
      font-family: var(--font-family);
      transition: var(--transition);
    }

    input:focus,
    textarea:focus,
    select:focus {
      outline: none;
      border-color: var(--secondary-green);
      box-shadow: var(--glow);
    }

    .photo-upload {
      border: 2px dashed var(--primary-blue);
      padding: var(--spacing-md);
      text-align: center;
      margin-bottom: var(--spacing-md);
      border-radius: 8px;
      transition: var(--transition);
    }

    .photo-upload:hover {
      background-color: var(--neutral-gray);
    }

    .availability-days {
      display: flex;
      flex-wrap: wrap;
      gap: var(--spacing-sm);
    }

    .availability-days label {
      display: inline-flex;
      align-items: center;
      margin-right: var(--spacing-sm);
      font-weight: 400;
      color: var(--text-dark);
    }

    .availability-days input[type="checkbox"] {
      accent-color: var(--secondary-green);
      margin-right: var(--spacing-xs);
    }

    .btn-submit {
      background-color: var(--primary-blue);
      color: var(--bg-white);
      padding: var(--spacing-sm) var(--spacing-md);
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-size: var(--font-size-base);
      font-weight: 500;
      width: 100%;
      transition: var(--transition);
    }

    .btn-submit:hover {
      background-color: var(--accent-coral);
      box-shadow: var(--glow);
    }

    .required {
      color: var(--accent-coral);
    }

    .two-columns {
      display: flex;
      gap: var(--spacing-md);
      flex-wrap: wrap;
    }

    .two-columns .form-group {
      flex: 1;
      min-width: 250px;
    }
  </style>
</head>

<body>
  <?php if (!empty($successMsg)): ?>
    <div style="color: green; font-weight: bold; text-align: center; margin-bottom: 20px;">
      <?= $successMsg ?>
    </div>
  <?php elseif (!empty($errorMsg)): ?>
    <div style="color: red; font-weight: bold; text-align: center; margin-bottom: 20px;">
      <?= $errorMsg ?>
    </div>
  <?php endif; ?>

  <div class="container">
    <h1>Doctor Registration Form</h1>
    <form action="#" method="post" enctype="multipart/form-data">
      <!-- Photo Upload -->
      <div class="form-group photo-upload">
        <label for="photo">Upload Profile Photo <span class="required">*</span></label>
        <input type="file" id="photo" name="photo" accept="image/*" required>
      </div>

      <!-- Personal Information -->
      <div class="two-columns">
        <div class="form-group">
          <label for="fullname">Full Name <span class="required">*</span></label>
          <input type="text" id="fullname" name="fullname" required>
        </div>
        <div class="form-group">
          <label for="gender">Gender <span class="required">*</span></label>
          <select id="gender" name="gender" required>
            <option value="">Select Gender</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
            <option value="prefer-not-to-say">Prefer not to say</option>
          </select>
        </div>
      </div>

      <div class="two-columns">
        <div class="form-group">
          <label for="email">Email <span class="required">*</span></label>
          <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
          <label for="phone">Phone Number <span class="required">*</span></label>
          <input type="tel" id="phone" name="phone" required>
        </div>
      </div>

      <div class="form-group">
        <label for="address">Address <span class="required">*</span></label>
        <textarea id="address" name="address" rows="3" required></textarea>
      </div>

      <!-- Professional Information -->
      <div class="two-columns">
        <div class="form-group">
          <label for="specialty">Specialty <span class="required">*</span></label>
          <select id="specialty" name="specialty" required>
            <option value="">Select Specialty</option>
            <option value="cardiology">Cardiologist</option>
            <option value="oncologist">oncologist</option>
            <option value="neurology">Neurologist</option>
            <option value="pediatrician">Pediatrician</option>
            <option value="endocrinology">Endocrinologist</option>

          </select>
        </div>
        <div class="form-group">
          <label for="license">License Number <span class="required">*</span></label>
          <input type="text" id="license" name="license" required>
        </div>
      </div>

      <div class="form-group">
        <label for="experience">Years of Experience <span class="required">*</span></label>
        <input type="number" id="experience" name="experience" min="0" required>
      </div>

      <!-- Availability -->
      <div class="form-group">
        <label>Availability Days <span class="required">*</span></label>
        <div class="availability-days">
          <label><input type="checkbox" name="availability[]" value="monday"> Monday</label>
          <label><input type="checkbox" name="availability[]" value="tuesday"> Tuesday</label>
          <label><input type="checkbox" name="availability[]" value="wednesday"> Wednesday</label>
          <label><input type="checkbox" name="availability[]" value="thursday"> Thursday</label>
          <label><input type="checkbox" name="availability[]" value="friday"> Friday</label>
          <label><input type="checkbox" name="availability[]" value="saturday"> Saturday</label>
          <label><input type="checkbox" name="availability[]" value="sunday"> Sunday</label>
        </div>
      </div>

      <div class="form-group">
        <label for="available-time">Available Time (e.g., 9:00 AM - 6:00 PM) <span class="required">*</span></label>
        <input type="text" id="available-time" name="available-time" required>
      </div>

      <!-- Account Security -->
      <div class="two-columns">
        <div class="form-group">
          <label for="password">Password <span class="required">*</span></label>
          <input type="password" id="password" name="password" required>
        </div>
        <div class="form-group">
          <label for="confirm-password">Confirm Password <span class="required">*</span></label>
          <input type="password" id="confirm-password" name="confirm-password" required>
        </div>
      </div>

      <div class="form-group">
        <button type="submit" class="btn-submit">Register</button>
      </div>
    </form>
  </div>
</body>

</html>