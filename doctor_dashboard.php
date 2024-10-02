<?php
session_start();
require "./public/include/connect.php";

// Check if the user is logged in and has admin role
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'doctor') {
    header("Location: doctor_login.php");
    exit();
}

// Fetch doctor's details
$doctor_query = "SELECT name, phone, email, country_of_origin, profile_picture FROM doctors WHERE id = ?";
$doctor_stmt = mysqli_prepare($connect, $doctor_query);
mysqli_stmt_bind_param($doctor_stmt, 'i', $_SESSION['doctor_id']);
mysqli_stmt_execute($doctor_stmt);
$doctor_result = mysqli_stmt_get_result($doctor_stmt);

if (!$doctor_result) {
    die("Query failed: " . mysqli_error($connect));
}

$doctor_details = mysqli_fetch_assoc($doctor_result);

// Prepare SQL query for appointments
$appointment_query = "SELECT a.id AS appointment_id, p.name AS patient_name, p.phone AS patient_phone, a.appointment_date AS appointment_date, a.status 
                      FROM appointments a 
                      JOIN patient_registration p ON a.patient_id = p.id 
                      WHERE a.doctor_id = ?";

$appointment_stmt = mysqli_prepare($connect, $appointment_query);
mysqli_stmt_bind_param($appointment_stmt, 'i', $_SESSION['doctor_id']);
mysqli_stmt_execute($appointment_stmt);
$appointment_result = mysqli_stmt_get_result($appointment_stmt);

if (!$appointment_result) {
    die("Query failed: " . mysqli_error($connect));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex">
        <?php require "./public/include/sidebar_doctor.php"; ?>
        
        <main class="w-4/5 p-8">
            <div class="container p-4 mx-auto bg-white rounded-lg shadow-lg">
                <h1 class="mb-6 text-3xl font-bold">Doctor Dashboard</h1>

                <!-- Doctor Details -->
                <div class="mb-6">
                    <h2 class="mb-2 text-lg font-semibold">Doctor Details</h2>
                    <div class="flex items-center space-x-4">
                        <!-- Profile Picture -->
                        <img src="<?php echo htmlspecialchars($doctor_details['profile_picture']); ?>" alt="Profile Picture" class="w-24 h-24 border border-gray-300 rounded-full">
                        <div>
                            <p><strong>Name:</strong> <?php echo htmlspecialchars($doctor_details['name']); ?></p>
                            <p><strong>Phone:</strong> <?php echo htmlspecialchars($doctor_details['phone']); ?></p>
                            <p><strong>Email:</strong> <?php echo htmlspecialchars($doctor_details['email']); ?></p>
                            <p><strong>Country of Origin:</strong> <?php echo htmlspecialchars($doctor_details['country_of_origin']); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Appointments Table -->
                <h2 class="mb-2 text-lg font-semibold">Appointments</h2>
                <?php if (mysqli_num_rows($appointment_result) > 0): ?>
                    <table class="w-full border border-collapse border-gray-300 table-auto">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 border border-gray-300">Appointment ID</th>
                                <th class="px-4 py-2 border border-gray-300">Patient Name</th>
                                <th class="px-4 py-2 border border-gray-300">Patient Phone</th>
                                <th class="px-4 py-2 border border-gray-300">Appointment Date</th>
                                <th class="px-4 py-2 border border-gray-300">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($appointment_result)): ?>
                                <tr>
                                    <td class="px-4 py-2 border border-gray-300"><?php echo htmlspecialchars($row['appointment_id']); ?></td>
                                    <td class="px-4 py-2 border border-gray-300"><?php echo htmlspecialchars($row['patient_name']); ?></td>
                                    <td class="px-4 py-2 border border-gray-300"><?php echo htmlspecialchars($row['patient_phone']); ?></td>
                                    <td class="px-4 py-2 border border-gray-300"><?php echo htmlspecialchars($row['appointment_date']); ?></td>
                                    <td class="px-4 py-2 border border-gray-300"><?php echo htmlspecialchars($row['status']); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="text-gray-600">No appointments found.</p>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>
