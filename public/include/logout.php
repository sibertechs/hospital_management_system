<?php
session_start();

// Store the role before destroying the session
$role = $_SESSION['role'] ?? '';

// Destroy the session and all its data
session_destroy();

// Redirect the user to the appropriate login form based on their role
if ($role == 'admin') {
    header("Location: admin_login.php");
} elseif ($role == 'patient') {
    header("Location: patient_login.php");
} else {
    header("Location: login.php"); // Default redirect if role is not set
}
exit();
?>