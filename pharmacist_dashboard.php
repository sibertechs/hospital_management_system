<?php 
session_start();
require "./public/include/connect.php"; // Include database connection

// Ensure the pharmacist is logged in
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'pharmacist') {
    header("Location: pharmacist_login.php");
    exit();
}

// Fetch statistics for the dashboard
// Total Drugs
$query_total_drugs = "SELECT COUNT(*) AS total FROM drugs";
$result_total_drugs = mysqli_query($connect, $query_total_drugs);
$total_drugs = mysqli_fetch_assoc($result_total_drugs)['total'];

// Total Prescriptions
$query_total_prescriptions = "SELECT COUNT(*) AS total FROM prescriptions";
$result_total_prescriptions = mysqli_query($connect, $query_total_prescriptions);
$total_prescriptions = mysqli_fetch_assoc($result_total_prescriptions)['total'];

// Pending Prescriptions
$query_pending_prescriptions = "SELECT COUNT(*) AS total FROM prescriptions WHERE status = 'Pending'";
$result_pending_prescriptions = mysqli_query($connect, $query_pending_prescriptions);
$total_pending_prescriptions = mysqli_fetch_assoc($result_pending_prescriptions)['total'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pharmacist Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
</head>
<body class="flex bg-gray-100">

    <!-- Sidebar -->
    <?php require "./public/include/sidebar_pharmacist.php"; // Include sidebar ?>
    
    <!-- Main Content -->
    <div class="flex-1 p-8">
        <div class="container mx-auto">
            <h1 class="mb-6 text-3xl font-bold text-gray-800">Welcome, Pharmacist!</h1>
            
            <!-- Dashboard Statistics Section -->
            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                <div class="p-6 bg-white border-t-4 border-blue-500 rounded-lg shadow-lg">
                    <h2 class="text-lg font-semibold text-gray-800">Total Drugs</h2>
                    <p class="mt-2 text-2xl font-bold text-blue-600"><?php echo htmlspecialchars($total_drugs); ?></p>
                </div>
                <div class="p-6 bg-white border-t-4 border-green-500 rounded-lg shadow-lg">
                    <h2 class="text-lg font-semibold text-gray-800">Total Prescriptions</h2>
                    <p class="mt-2 text-2xl font-bold text-green-600"><?php echo htmlspecialchars($total_prescriptions); ?></p>
                </div>
                <div class="p-6 bg-white border-t-4 border-red-500 rounded-lg shadow-lg">
                    <h2 class="text-lg font-semibold text-gray-800">Pending Prescriptions</h2>
                    <p class="mt-2 text-2xl font-bold text-red-600"><?php echo htmlspecialchars($total_pending_prescriptions); ?></p>
                </div>
            </div>

            <!-- Additional content here -->
            <div class="mt-8">
                <p class="text-lg text-gray-700">Use the sidebar to manage drugs, view prescriptions, or check pending orders.</p>
            </div>
        </div>
    </div>
</body>
</html>
