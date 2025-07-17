<?php
// database connection
include 'includes/config.php';

$successMsg = "";
$errorMsg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $full_name = mysqli_real_escape_string($conn, $_POST['fullname']);
  $gender = mysqli_real_escape_string($conn, $_POST['gender']);
  $dob = mysqli_real_escape_string($conn, $_POST['dob']);
  $phone = mysqli_real_escape_string($conn, $_POST['phone']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);
  $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm-password']);

  // Photo Upload
  $photoName = $_FILES['photo']['name'];
  $photoTmp = $_FILES['photo']['tmp_name'];
  $photoPath = 'uploads/' . basename($photoName);

  if (!is_dir('uploads')) {
    mkdir('uploads', 0777, true);
  }

  if ($password !== $confirm_password) {
    $errorMsg = "Passwords do not match!";
  } elseif (move_uploaded_file($photoTmp, $photoPath)) {
    // SQL Insert
    $sql = "INSERT INTO patient (full_name, gender, dob, phone, email, photo, password)
                VALUES ('$full_name', '$gender', '$dob', '$phone', '$email', '$photoPath', '$password')";

    if (mysqli_query($conn, $sql)) {
      $successMsg = "Registration successful!";
    } else {
      $errorMsg = "Error: " . mysqli_error($conn);
    }
  } else {
    $errorMsg = "Failed to upload photo.";
  }
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Patient Registration Form</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
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
    input[type="date"],
    textarea,
    select {
      width: 100%;
      padding: var(--spacing-sm);
      border: 1px solid var(--primary-blue);
      border-radius: 8px;
      box-sizing: border-box;
      font-family: var(--font-family);
      font-size: var(--font-size-base);
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

    .form-note {
      font-size: 14px;
      color: var(--text-dark);
      margin-top: var(--spacing-xs);
      opacity: 0.8;
    }
  </style>
</head>

<body>
  <div class="container">
    <h1>Patient Registration Form</h1>
    <?php if (!empty($successMsg))
      echo "<p style='color: green;'>$successMsg</p>"; ?>
    <?php if (!empty($errorMsg))
      echo "<p style='color: red;'>$errorMsg</p>"; ?>

    <form action="#" method="post" enctype="multipart/form-data">
      <!-- Photo Upload -->
      <div class="form-group photo-upload">
        <label for="photo">Profile Photo <span class="required"></span></label>
        <input type="file" id="photo" name="photo" accept="image/*" required aria-label="Upload profile photo">
        <p class="form-note">Upload a clear photo for identification.</p>
      </div>

      <!-- Personal Information -->
      <div class="two-columns">
        <div class="form-group">
          <label for="fullname">Full Name <span class="required">*</span></label>
          <input type="text" id="fullname" name="fullname" placeholder="Enter Your Full Name" required
            aria-label="Full name">
        </div>
        <div class="form-group">
          <label for="gender">Gender <span class="required">*</span></label>
          <select id="gender" name="gender" required aria-label="Select gender">
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
          <label for="dob">Date of Birth <span class="required">*</span></label>
          <input type="date" id="dob" name="dob" required aria-label="Date of birth">

        </div>
       
      </div>

      <div class="two-columns">
        <div class="form-group">
          <label for="email">Email <span class="required">*</span></label>
          <input type="email" id="email" name="email" placeholder="example@domain.com" required
            aria-label="Email address">
        </div>
        <div class="form-group">
          <label for="phone">Phone Number <span class="required">*</span></label>
          <input type="tel" id="phone" name="phone" placeholder="+1 123-456-7890" required aria-label="Phone number">
        </div>
      </div>

      <!-- Account Security -->
      <div class="two-columns">
        <div class="form-group">
          <label for="password">Password <span class="required">*</span></label>
          <input type="password" id="password" name="password" placeholder="Password must be at least 8 characters" required
            aria-label="Password">

        </div>
        <div class="form-group">
          <label for="confirm-password">Confirm Password <span class="required">*</span></label>
          <input type="password" id="confirm-password" name="confirm-password" placeholder="Re-enter password" required
            aria-label="Confirm password" placedeholder="Re-enter password">
        </div>
      </div>

      <div class="form-group">
        <button type="submit" class="btn-submit">Register</button>
      </div>
    </form>
  </div>

  <?php include 'includes/chatbot.php'; ?>
</body>

</html>