<?php
session_start();
session_destroy();
header("Location: admin_login.php");  // Admin login page pe redirect karte hain
header('Location: login.php');  // Login page pe redirect karte hain
exit();
?>
