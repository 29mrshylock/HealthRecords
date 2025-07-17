<?php
// Start session if needed
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Optional: You can also check if appointment was really successful
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Appointment Successful</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f0f2f5;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .success-card {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
            text-align: center;
            max-width: 500px;
        }
        .success-card h1 {
            font-size: 2.5rem;
            color: #28a745;
        }
        .success-card p {
            font-size: 1.2rem;
            margin-top: 15px;
            color: #555;
        }
        .success-card .btn {
            margin-top: 25px;
        }
    </style>
</head>
<body>

<div class="success-card">
    <h1>🎉 Appointment Booked!</h1>
    <p>Thank you! Your appointment has been successfully scheduled.</p>
    <a href="index.php" class="btn btn-success">Back to Home</a>
</div>

</body>
</html>
