<?php
require "./public/include/connect.php";
session_start();

// Check if the user is logged in and has admin role
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: admin_login.php");
    exit();
}

// Fetch total counts from various tables
$totalPatients = mysqli_fetch_assoc(mysqli_query($connect, "SELECT COUNT(*) AS total FROM patient_registration"))['total'];
$totalTransactions = mysqli_fetch_assoc(mysqli_query($connect, "SELECT COUNT(*) AS total FROM transactions"))['total'];
$totalAppointments = mysqli_fetch_assoc(mysqli_query($connect, "SELECT COUNT(*) AS total FROM appointments"))['total'];
$totalDoctors = mysqli_fetch_assoc(mysqli_query($connect, "SELECT COUNT(*) AS total FROM doctors"))['total'];
$totalDrugs = mysqli_fetch_assoc(mysqli_query($connect, "SELECT COUNT(*) AS total FROM drugs"))['total'];

// Close the database connection
mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
    <style>
        .sidebar { height: 100vh; }
        .active { background-color: #4a5568; }
    </style>
</head>
<body class="flex">
    <?php require "./public/include/sidebar_admin.php"; ?>
    
    <div class="flex-1 p-6">
        <header class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold">Dashboard</h1>
            <a href="admin_login.php" class="text-blue-500 hover:underline">Logout</a>
        </header>
        <main>
            <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-2 lg:grid-cols-3">
                <div class="p-4 bg-white rounded shadow-md">
                    <h2 class="text-xl font-semibold">Total Patients</h2>
                    <p class="text-2xl font-bold"><?php echo $totalPatients; ?></p>
                </div>
                <div class="p-4 bg-white rounded shadow-md">
                    <h2 class="text-xl font-semibold">Total Transactions</h2>
                    <p class="text-2xl font-bold"><?php echo $totalTransactions; ?></p>
                </div>
                <div class="p-4 bg-white rounded shadow-md">
                    <h2 class="text-xl font-semibold">Total Appointments</h2>
                    <p class="text-2xl font-bold"><?php echo $totalAppointments; ?></p>
                </div>
                <div class="p-4 bg-white rounded shadow-md">
                    <h2 class="text-xl font-semibold">Total Doctors</h2>
                    <p class="text-2xl font-bold"><?php echo $totalDoctors; ?></p>
                </div>
                <div class="p-4 bg-white rounded shadow-md">
                    <h2 class="text-xl font-semibold">Total Drugs</h2>
                    <p class="text-2xl font-bold"><?php echo $totalDrugs; ?></p>
                </div>
            </div>
            
        </main>
    </div>
</body>
</html>
