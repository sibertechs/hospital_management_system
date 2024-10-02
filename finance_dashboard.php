<?php
session_start();

// Ensure the finance user is logged in
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'finance') {
    header("Location: finance_login.php");
    exit();
}

// Include your database connection
require "./public/include/connect.php";

// Fetch financial data
$total_transactions_query = "SELECT COUNT(*) as total_transactions FROM transactions";
$total_amount_query = "SELECT SUM(amount) as total_amount FROM transactions";
$total_drugs_query = "SELECT COUNT(*) as total_drugs FROM drugs";

$total_transactions_result = mysqli_fetch_assoc(mysqli_query($connect, $total_transactions_query));
$total_amount_result = mysqli_fetch_assoc(mysqli_query($connect, $total_amount_query));
$total_drugs_result = mysqli_fetch_assoc(mysqli_query($connect, $total_drugs_query));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finance Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
</head>
<body class="flex bg-gray-100">

    <!-- Sidebar -->
    <?php
        require "./public/include/sidebar_finance.php";
    ?>

    <!-- Main Content -->
    <div class="flex-1 p-6">
        <h1 class="text-3xl font-bold text-gray-800">Finance Dashboard</h1>

        <!-- Dashboard Statistics Section -->
        <div class="grid grid-cols-1 gap-6 mt-6 md:grid-cols-3">
            <div class="p-6 bg-white border-t-4 border-blue-500 rounded-lg shadow-lg">
                <h2 class="text-lg font-semibold text-gray-800">Total Transactions</h2>
                <p class="mt-2 text-2xl font-bold text-blue-600"><?php echo htmlspecialchars($total_transactions_result['total_transactions']); ?></p>
            </div>
            <div class="p-6 bg-white border-t-4 border-green-500 rounded-lg shadow-lg">
                <h2 class="text-lg font-semibold text-gray-800">Total Amount</h2>
                <p class="mt-2 text-2xl font-bold text-green-600"><?php echo htmlspecialchars(number_format($total_amount_result['total_amount'], 2)); ?> GHS</p>
            </div>
            <div class="p-6 bg-white border-t-4 border-red-500 rounded-lg shadow-lg">
                <h2 class="text-lg font-semibold text-gray-800">Total Drugs</h2>
                <p class="mt-2 text-2xl font-bold text-red-600"><?php echo htmlspecialchars($total_drugs_result['total_drugs']); ?></p>
            </div>
        </div>

       
    </div>
</body>
</html>
