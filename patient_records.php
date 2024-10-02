<?php
// Include database connection
require "./public/include/connect.php";

// Ensure database connection
if (!$connect) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Get patient ID from URL parameter
$patient_id = isset($_GET['id']) ? mysqli_real_escape_string($connect, $_GET['id']) : '';

if (!$patient_id) {
    die("Invalid patient ID.");
}

// Fetch comprehensive patient data
$query = "
    SELECT
        pr.id AS patient_id,
        pr.name AS full_name,
        pr.dob AS date_of_birth,
        mr.record_id AS record_id,
        mr.date AS record_date,
        mr.details AS record_details,
        b.bill_id AS bill_id,
        b.date AS bill_date,
        b.amount AS bill_amount,
        a.appointment_id AS appointment_id,
        a.date AS appointment_date,
        a.details AS appointment_details
    FROM patient_registration pr
    LEFT JOIN medical_records mr ON pr.id = mr.patient_id
    LEFT JOIN finance b ON pr.id = b.patient_id
    LEFT JOIN appointments a ON pr.id = a.patient_id
    WHERE pr.id = '$patient_id'
    ORDER BY mr.date DESC, b.date DESC, a.date DESC
";

$result = mysqli_query($connect, $query);

if (!$result) {
    die("Error fetching patient data: " . mysqli_error($connect));
}

// Fetch patient information for header
$patient_query = "
    SELECT name, dob
    FROM patient_registration
    WHERE id = '$patient_id'
";

$patient_result = mysqli_query($connect, $patient_query);
$patient = mysqli_fetch_assoc($patient_result);

if (!$patient) {
    die("Patient not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Records</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Mobile Navigation Button -->
    <div id="navButton" class="fixed top-0 left-[-7rem] z-50 p-4 ml-0 lg:hidden">
        <button onclick="toggleSidebar()" class="p-2 text-white bg-blue-600 rounded-md shadow-md focus:outline-none">
            <i class="text-2xl fas fa-bars"></i> <!-- Open Button -->
        </button>
    </div>
    <div class="flex">
        <!-- Sidebar (Initially hidden on mobile) -->
        <?php require "./public/include/sidebar_doctor.php"; ?>
        <!-- Overlay for mobile when sidebar is open -->
        <div id="overlay" class="fixed inset-0 z-30 hidden bg-black opacity-50 md:hidden" onclick="toggleSidebar()"></div>

        <main class="flex-1 p-8 ml-4">
            <div class="container mx-auto">
                <div class="max-w-6xl p-6 mx-auto bg-white rounded-lg shadow-md">
                    <h1 class="mb-4 text-2xl font-bold">Patient Records for <?php echo htmlspecialchars($patient['name']); ?></h1>

                    <!-- Medical Records -->
                    <h2 class="text-xl font-semibold">Medical Records</h2>
                    <table class="w-full mb-6 text-left bg-white border border-gray-300 rounded">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="px-4 py-2 border-b">Record ID</th>
                                <th class="px-4 py-2 border-b">Date</th>
                                <th class="px-4 py-2 border-b">Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <?php if ($row['record_id']): ?>
                            <tr>
                                <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['record_id']); ?></td>
                                <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['record_date']); ?></td>
                                <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['record_details']); ?></td>
                            </tr>
                            <?php endif; ?>
                            <?php endwhile; ?>
                        </tbody>
                    </table>

                    <!-- Billing Information -->
                    <h2 class="text-xl font-semibold">Billing Information</h2>
                    <table class="w-full mb-6 text-left bg-white border border-gray-300 rounded">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="px-4 py-2 border-b">Bill ID</th>
                                <th class="px-4 py-2 border-b">Date</th>
                                <th class="px-4 py-2 border-b">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <?php if ($row['bill_id']): ?>
                            <tr>
                                <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['bill_id']); ?></td>
                                <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['bill_date']); ?></td>
                                <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['bill_amount']); ?></td>
                            </tr>
                            <?php endif; ?>
                            <?php endwhile; ?>
                        </tbody>
                    </table>

                    <!-- Appointments -->
                    <h2 class="text-xl font-semibold">Appointments</h2>
                    <table class="w-full mb-6 text-left bg-white border border-gray-300 rounded">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="px-4 py-2 border-b">Appointment ID</th>
                                <th class="px-4 py-2 border-b">Date</th>
                                <th class="px-4 py-2 border-b">Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <?php if ($row['appointment_id']): ?>
                            <tr>
                                <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['appointment_id']); ?></td>
                                <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['appointment_date']); ?></td>
                                <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['appointment_details']); ?></td>
                            </tr>
                            <?php endif; ?>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <script>
    function toggleDropdown(dropdownId) {
        var dropdown = document.getElementById(dropdownId);
        dropdown.classList.toggle('hidden');
    }

    function toggleSidebar() {
        var sidebar = document.getElementById('sidebar');
        var overlay = document.getElementById('overlay');
        var navButton = document.getElementById('navButton');

        // Toggle sidebar visibility and overlay
        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');

        // Change button icon
        var buttonIcon = navButton.querySelector('i');
        buttonIcon.classList.toggle('fa-bars');
        buttonIcon.classList.toggle('fa-times');
    }
    </script>
</body>
</html>
