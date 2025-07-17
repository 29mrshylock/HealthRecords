<?php
session_start();

// Redirect if admin is not logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit;
}

// Database connection
$con = mysqli_connect("localhost", "root", "", "healthsync");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch all doctors
$result = mysqli_query($con, "SELECT * FROM doctors");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel - Doctor Management | HealthSync</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --primary: #4361ee;
      --secondary: #3f37c9;
      --success: #4cc9f0;
      --danger: #f72585;
      --warning: #f8961e;
      --light: #f8f9fa;
      --dark: #212529;
      --gray: #6c757d;
    }
    
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f8fafc;
      color: #334155;
      line-height: 1.6;
    }
    
    .container {
      max-width: 1400px;
      margin: 0 auto;
      padding: 2rem;
    }
    
    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 2rem;
      padding-bottom: 1rem;
      border-bottom: 1px solid #e2e8f0;
    }
    
    .header-title {
      display: flex;
      flex-direction: column;
    }
    
    h1 {
      font-size: 1.8rem;
      color: var(--dark);
      font-weight: 600;
    }
    
    h2 {
      font-size: 1rem;
      color: var(--gray);
      font-weight: 400;
    }
    
    .admin-info {
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }
    
    .admin-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background-color: var(--primary);
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 600;
    }
    
    .card {
      background: white;
      border-radius: 12px;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
      overflow: hidden;
    }
    
    .table-responsive {
      overflow-x: auto;
    }
    
    table {
      width: 100%;
      border-collapse: collapse;
    }
    
    th, td {
      padding: 1rem;
      text-align: left;
      border-bottom: 1px solid #e2e8f0;
    }
    
    th {
      background-color: #f1f5f9;
      color: #64748b;
      font-weight: 600;
      text-transform: uppercase;
      font-size: 0.75rem;
      letter-spacing: 0.05em;
    }
    
    tr:hover {
      background-color: #f8fafc;
    }
    
    .doctor-avatar {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid #e2e8f0;
    }
    
    .status {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      padding: 0.35rem 0.75rem;
      border-radius: 9999px;
      font-size: 0.75rem;
      font-weight: 500;
    }
    
    .status-verified {
      background-color: #ecfdf5;
      color: #059669;
    }
    
    .status-pending {
      background-color: #fef3c7;
      color: #d97706;
    }
    
    .action-btns {
      display: flex;
      gap: 0.5rem;
    }
    
    .btn {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      padding: 0.5rem 1rem;
      border-radius: 8px;
      font-size: 0.875rem;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.2s ease;
      text-decoration: none;
      border: none;
    }
    
    .btn-sm {
      padding: 0.375rem 0.75rem;
      font-size: 0.75rem;
    }
    
    .btn-primary {
      background-color: var(--primary);
      color: white;
    }
    
    .btn-primary:hover {
      background-color: var(--secondary);
    }
    
    .btn-success {
      background-color: #10b981;
      color: white;
    }
    
    .btn-success:hover {
      background-color: #059669;
    }
    
    .btn-danger {
      background-color: var(--danger);
      color: white;
    }
    
    .btn-danger:hover {
      background-color: #d1146a;
    }
    
    .btn-outline {
      background-color: transparent;
      border: 1px solid #cbd5e1;
      color: #64748b;
    }
    
    .btn-outline:hover {
      background-color: #f1f5f9;
    }
    
    .footer-actions {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-top: 2rem;
      padding-top: 1rem;
      border-top: 1px solid #e2e8f0;
    }
    
    @media (max-width: 768px) {
      .container {
        padding: 1rem;
      }
      
      .action-btns {
        flex-direction: column;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <header>
      <div class="header-title">
        <h1>Doctor Management</h1>
        <h2>Manage all registered doctors in the system</h2>
      </div>
      <div class="admin-info">
        <div class="admin-avatar">
          <?= strtoupper(substr($_SESSION['admin_user'], 0, 1)) ?>
        </div>
        <span><?= $_SESSION['admin_user'] ?></span>
      </div>
    </header>
    
    <div class="card">
      <div class="table-responsive">
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>Doctor</th>
              <th>Contact</th>
              <th>Specialty</th>
              <th>Details</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
              <td>#<?= $row['id'] ?></td>
              <td>
                <div style="display: flex; align-items: center; gap: 1rem;">
                  <img src="<?= !empty($row['photo']) ? $row['photo'] : 'https://ui-avatars.com/api/?name='.urlencode($row['fullname']).'&background=random' ?>" 
                       alt="<?= $row['fullname'] ?>" 
                       class="doctor-avatar"
                       onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($row['fullname']) ?>&background=random'">
                  <div>
                    <div style="font-weight: 600;"><?= $row['fullname'] ?></div>
                    <div style="font-size: 0.75rem; color: var(--gray);"><?= $row['gender'] ?></div>
                  </div>
                </div>
              </td>
              <td>
                <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                  <a href="mailto:<?= $row['email'] ?>" style="color: var(--primary); text-decoration: none;">
                    <i class="fas fa-envelope"></i> <?= $row['email'] ?>
                  </a>
                  <a href="tel:<?= $row['phone'] ?>" style="color: var(--gray); text-decoration: none;">
                    <i class="fas fa-phone"></i> <?= $row['phone'] ?>
                  </a>
                </div>
              </td>
              <td><?= $row['specilaty'] ?></td>
              <td>
                <div style="display: flex; flex-direction: column; gap: 0.25rem; font-size: 0.875rem;">
                  <div><strong>License:</strong> <?= $row['license'] ?></div>
                  <div><strong>Exp:</strong> <?= $row['experience'] ?> years</div>
                  <div><strong>Address:</strong> <?= substr($row['address'], 0, 20) ?>...</div>
                </div>
              </td>
              <td>
                <span class="status <?= $row['verified'] ? 'status-verified' : 'status-pending' ?>">
                  <i class="fas <?= $row['verified'] ? 'fa-check-circle' : 'fa-clock' ?>"></i>
                  <?= $row['verified'] ? 'Verified' : 'Pending' ?>
                </span>
              </td>
              <td>
                <div class="action-btns">
                  <form method="post" action="verify.php" style="display: inline;">
                    <input type="hidden" name="doctor_id" value="<?= $row['id'] ?>">
                    <button type="submit" name="verify" class="btn btn-sm <?= $row['verified'] ? 'btn-danger' : 'btn-success' ?>">
                      <i class="fas <?= $row['verified'] ? 'fa-times' : 'fa-check' ?>"></i>
                      <?= $row['verified'] ? 'Unverify' : 'Verify' ?>
                    </button>
                  </form>
                  <a href="doctor_patients.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">
                    <i class="fas fa-users"></i> Patients
                  </a>
                </div>
              </td>
            </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
    
    <div class="footer-actions">
      <a href="admin-home.php" class="btn btn-outline">
        <i class="fas fa-arrow-left"></i> Back to Dashboard
      </a>
      <a href="logout.php" class="btn btn-outline">
        <i class="fas fa-sign-out-alt"></i> Logout
      </a>
    </div>
  </div>
</body>
</html>

<?php
mysqli_close($con);
?>