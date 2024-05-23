<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$role = $_SESSION['role'];
if ($role == 'admin') {
    header("Location: admin_dashboard.php");
} elseif ($role == 'staff') {
    header("Location: staff_dashboard.php");
} elseif ($role == 'passenger') {
    header("Location: passenger_dashboard.php");
} else {
    echo "Unknown role";
}
?>
