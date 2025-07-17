<?php
session_start();

// Hardcoded admin credentials
$adminUsername = "admin";
$adminPassword = "admin123";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Check credentials
    if ($username === $adminUsername && $password === $adminPassword) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_user'] = $adminUsername;
        header("Location: admin.php"); // redirect to admin home
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Digital Health Record</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #007BFF;
            --secondary-color: #28A745;
            --accent-color: #DC3545;
            --bg-gradient-start: #0052CC;
            --bg-gradient-end: #00C4B4;
            --card-bg: #FFFFFF;
            --text-dark: #1F2A44;
            --text-light: #F8F9FA;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, var(--bg-gradient-start), var(--bg-gradient-end));
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            overflow: auto;
        }

        .login-container {
            max-width: 400px;
            width: 100%;
            padding: 1.5rem;
        }

        .login-box {
            background: var(--card-bg);
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            padding: 2rem;
            animation: slideIn 0.5s ease-in-out;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .login-box h2 {
            color: var(--text-dark);
            text-align: center;
            margin-bottom: 1.5rem;
            font-weight: 600;
            font-size: 1.8rem;
        }

        .form-control {
            border-radius: 6px;
            border: 1px solid #E2E8F0;
            padding: 0.7rem 1rem;
            font-size: 0.95rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.2);
            outline: none;
        }

        .form-label {
            font-size: 0.9rem;
            color: var(--text-dark);
            margin-bottom: 0.4rem;
            font-weight: 500;
        }

        .input-group {
            position: relative;
        }

        .input-group .input-icon {
            position: absolute;
            left: 0.8rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6B7280;
            font-size: 1rem;
            z-index: 10;
        }

        .input-group input {
            padding-left: 2.5rem;
        }

        .btn-login {
            background: var(--primary-color);
            border: none;
            border-radius: 6px;
            padding: 0.7rem;
            font-size: 0.95rem;
            font-weight: 500;
            color: var(--text-light);
            transition: background 0.3s ease, transform 0.2s ease;
            width: 100%;
        }

        .btn-login:hover {
            background: #0056b3;
            transform: translateY(-2px);
        }

        .error {
            background: #FFF1F1;
            color: var(--accent-color);
            padding: 0.7rem;
            border-radius: 6px;
            text-align: center;
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 1.2rem;
            border: 1px solid #F8D7DA;
        }

        .forgot-password {
            display: block;
            text-align: center;
            margin-top: 1rem;
            color: var(--primary-color);
            font-size: 0.85rem;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .forgot-password:hover {
            color: #0056b3;
            text-decoration: underline;
        }

        @media (max-width: 576px) {
            .login-container {
                padding: 1rem;
            }

            .login-box {
                padding: 1.5rem;
            }

            .login-box h2 {
                font-size: 1.5rem;
            }

            .form-control {
                font-size: 0.9rem;
            }

            .btn-login {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h2>Admin Login</h2>

            <?php if (!empty($error)) : ?>
                <div class="error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" autocomplete="off">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <div class="input-group">
                        <i class="fas fa-user input-icon"></i>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" required value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                    </div>
                </div>
                <button type="submit" class="btn-login">Sign In</button>
                <!-- <a href="#" class="forgot-password">Forgot Password?</a> -->
            </form>
        </div>
    </div>
</body>
</html>