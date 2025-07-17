<?php 
// Database Connection
$conn = new mysqli("localhost", "root", "", "healthsync");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch doctors
$doctors = [];
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT * FROM doctors WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $doctors[] = $row;
    }
    $stmt->close();
} else {
    $result = $conn->query("SELECT * FROM doctors ORDER BY fullname ASC");
    while ($row = $result->fetch_assoc()) {
        $doctors[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctors - HealthSync</title>
    <link rel="icon" href="img/HealthSync.png" type="image/png">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/header-footer.css">
    <link rel="stylesheet" href="css/doctors.css">
</head>

<body>
<!-- Navbar -->
<?php include 'includes/header.php'; ?>

<!-- Hero Section -->
<section class="hero-section position-relative">
    <img src="https://images.unsplash.com/photo-1550831107-1553da8c8464" class="w-100" alt="Doctors Team" style="height: 60vh; object-fit: cover; filter: brightness(60%);">
    <div class="position-absolute top-50 start-50 translate-middle text-center text-white">
        <h1 class="display-4 fw-bold">Our Expert Doctors</h1>
        <p class="lead">Caring for your health with excellence</p>
    </div>
</section>

<!-- Search & Filter -->
<section class="bg-light py-4">
    <div class="container">
        <div class="row g-3">
            <div class="col-md-6">
                <input type="text" id="searchInput" class="form-control" placeholder="Search by name or specialty">
            </div>
            <div class="col-md-3">
                <select id="specialtySelect" class="form-select">
                    <option value="">All Specialties</option>
                    <option value="Cardiologist">Cardiologist</option>
                    <option value="Pediatrician">Pediatrician</option>
                    <option value="Neurologist">Neurologist</option>
                    <option value="Orthopedic">Orthopedic</option>
                    <option value="Endocrinologist">Endocrinologist</option>
                    <option value="Oncologist">Oncologist</option>
                    <option value="Gastroenterologist">Gastroenterologist</option>
                    <option value="Psychiatrist">Psychiatrist</option>
                </select>
            </div>
            <div class="col-md-3">
                <button class="btn btn-primary w-100" onclick="filterDoctors()">Filter</button>
            </div>
        </div>
    </div>
</section>

<!-- Doctors List -->
<section class="py-5">
    <div class="container">
        <div class="row" id="doctorsList">
            <?php if (!empty($doctors)) : ?>
                <?php foreach ($doctors as $doctor) : ?>
                    <div class="col-md-4 mb-4 doctor-card" data-name="<?= htmlspecialchars($doctor['fullname']) ?>" data-specialty="<?= htmlspecialchars($doctor['specilaty']) ?>">
                        <div class="card shadow-sm h-100">
                            <img src="<?= htmlspecialchars($doctor['photo']) ?>" class="card-img-top" style="height: 280px; object-fit: cover;" alt="<?= htmlspecialchars($doctor['fullname']) ?>">
                            <div class="card-body">
                                <h5 class="card-title">Dr. <?= htmlspecialchars($doctor['fullname']) ?></h5>
                                <p class="text-primary fw-semibold"><?= htmlspecialchars($doctor['specilaty']) ?></p>
                                <p><i class="fas fa-phone-alt me-2"></i> <?= htmlspecialchars($doctor['phone']) ?></p>
                                <p><i class="fas fa-envelope me-2"></i> <?= htmlspecialchars($doctor['email']) ?></p>
                                <p><i class="fas fa-briefcase me-2"></i> <?= htmlspecialchars($doctor['experience']) ?> Years</p>
                                <div class="d-flex gap-2 mt-3">
                                    <a href="appointments.php?doctor_id=<?= $doctor['id'] ?>" class="btn btn-outline-primary flex-grow-1">
                                        <i class="fas fa-calendar-alt me-1"></i> Book Now
                                    </a>
                                    <a href="doctor-profile.php?id=<?= $doctor['id'] ?>" class="btn btn-primary flex-grow-1">
                                        <i class="fas fa-user-md me-1"></i> Profile
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="text-center text-danger">No doctors found.</div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Footer -->
<?php include 'includes/footer.php'; ?>

<!-- JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function filterDoctors() {
    const search = document.getElementById('searchInput').value.toLowerCase();
    const specialty = document.getElementById('specialtySelect').value.toLowerCase();
    const doctors = document.querySelectorAll('.doctor-card');

    doctors.forEach(doc => {
        const name = doc.getAttribute('data-name').toLowerCase();
        const spec = doc.getAttribute('data-specialty').toLowerCase();
        
        const matchesSearch = name.includes(search) || spec.includes(search);
        const matchesSpecialty = !specialty || spec === specialty;

        if (matchesSearch && matchesSpecialty) {
            doc.style.display = '';
        } else {
            doc.style.display = 'none';
        }
    });
}
</script>
</body>
</html>