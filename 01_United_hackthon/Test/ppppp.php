<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "healthsync");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch all doctors and group by specialty
$result = mysqli_query($con, "SELECT * FROM doctors ORDER BY specilaty");

$doctors_by_specialty = [];

while ($row = mysqli_fetch_assoc($result)) {
    $specialty = $row['specilaty'];
    $doctors_by_specialty[$specialty][] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Doctor Profiles by Specialty</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f0f2f5;
      padding: 20px;
    }

    h2.specialty-title {
      margin-top: 40px;
      color: #333;
      border-bottom: 2px solid #4A90E2;
      padding-bottom: 5px;
    }

    .card-container {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      margin-top: 15px;
    }

    .card {
      background-color: #fff;
      width: 280px;
      padding: 20px;
      border-radius: 15px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      text-align: center;
    }

    .card img {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      object-fit: cover;
      border: 3px solid #4A90E2;
    }

    .name-section {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 8px;
      margin-top: 10px;
    }

    .name-section h3 {
      font-size: 18px;
      margin: 0;
      color: #333;
    }

    .verified-badge {
      font-size: 12px;
      padding: 3px 6px;
      background-color: #e0ffe0;
      color: green;
      border-radius: 5px;
    }

    .verified-badge::before {
      content: "✔";
      margin-right: 4px;
    }

    .info {
      margin-top: 10px;
      font-size: 14px;
      color: #555;
    }
  </style>
</head>
<body>

<?php foreach ($doctors_by_specialty as $specialty => $doctors): ?>
  <h2 class="specialty-title"><?= htmlspecialchars($specialty) ?></h2>
  <div class="card-container">
    <?php foreach ($doctors as $row): ?>
      <div class="card">
        <img src="<?= $row['photo'] ?>" alt="Doctor Photo">
        <div class="name-section">
          <h3><?= htmlspecialchars($row['fullname']) ?></h3>
          <?php if ($row['verified']): ?>
            <span class="verified-badge">Verified</span>
          <?php endif; ?>
        </div>
        <div class="info">
          <p><strong>Phone:</strong> <?= htmlspecialchars($row['phone']) ?></p>
          <p><strong>Email:</strong> <?= htmlspecialchars($row['email']) ?></p>
          <p><strong>Experience:</strong> <?= htmlspecialchars($row['experience']) ?> years</p>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php endforeach; ?>

</body>
</html>

<?php mysqli_close($con); ?>