<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid email address']);
        exit;
    }

    // Store email in database (example)
    // $pdo = new PDO('mysql:host=localhost;dbname=healthsync', 'username', 'password');
    // $stmt = $pdo->prepare('INSERT INTO whitepaper_requests (email) VALUES (?)');
    // $stmt->execute([$email]);

    // Redirect to PDF
    header('Location: security-whitepaper.pdf');
    exit;
}
?>