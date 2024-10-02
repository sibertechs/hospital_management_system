<?php
session_start();
require "./public/include/connect.php";

$patient_id = isset($_GET['patient_id']) ? intval($_GET['patient_id']) : 0;
$biodata = $medical_history = $bills = $appointments = [];

if ($patient_id) {
    // Fetch biodata
    $patient_query = "SELECT * FROM patient_registration WHERE id = ?";
    $stmt = mysqli_prepare($connect, $patient_query);
    mysqli_stmt_bind_param($stmt, "i", $patient_id);
    mysqli_stmt_execute($stmt);
    $patient_result = mysqli_stmt_get_result($stmt);

    // Check if patient exists
    if (mysqli_num_rows($patient_result) == 0) {
        echo "<script>alert('Patient not found.'); window.location.href='patient_dashboard.php';</script>";
        exit;
    }

    $biodata = mysqli_fetch_assoc($patient_result);

    // Fetch medical history
    $medical_history_query = "
        SELECT mh.visit_date, mh.diagnosis, mh.treatment, mh.visit_notes, d.name AS doctor_name 
        FROM medical_history mh
        JOIN doctors d ON mh.doctor_id = d.id
        WHERE mh.patient_id = ?
        ORDER BY mh.visit_date DESC";
    $stmt = mysqli_prepare($connect, $medical_history_query);
    mysqli_stmt_bind_param($stmt, "i", $patient_id);
    mysqli_stmt_execute($stmt);
    $medical_history_result = mysqli_stmt_get_result($stmt);
    $medical_history = mysqli_fetch_all($medical_history_result, MYSQLI_ASSOC);
    
    // Fetch bills from the database for the patient
    $bills_query = "SELECT b.*, p.name as patient_name FROM bills b
                    JOIN patient_registration p ON b.patient_id = p.id
                    WHERE b.patient_id = ?";
    $stmt = mysqli_prepare($connect, $bills_query);
    mysqli_stmt_bind_param($stmt, "i", $patient_id);
    mysqli_stmt_execute($stmt);
    $bills_result = mysqli_stmt_get_result($stmt);
    $bills = mysqli_fetch_all($bills_result, MYSQLI_ASSOC);

    // Fetch booked appointments for the patient
    $appointments_query = "SELECT a.*, d.name AS doctor_name FROM appointments a
                           JOIN doctors d ON a.doctor_id = d.id
                           WHERE a.patient_id = ?";
    $stmt = mysqli_prepare($connect, $appointments_query);
    mysqli_stmt_bind_param($stmt, "i", $patient_id);
    mysqli_stmt_execute($stmt);
    $appointments_result = mysqli_stmt_get_result($stmt);
    $appointments = mysqli_fetch_all($appointments_result, MYSQLI_ASSOC);
} else {
    echo "<script>alert('Patient ID is not set.'); window.location.href='patient_dashboard.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Details</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
    <script>
        function cancelAppointment(appointmentId) {
            if (confirm('Are you sure you want to cancel this appointment?')) {
                window.location.href = 'cancel_appointment.php?appointment_id=' + appointmentId;
            }
        }
    </script>
</head>
<body class="bg-gray-100">
    <div class="flex">
        <!-- Sidebar -->
        <?php require "./public/include/sidebar1.php"; ?>

        <!-- Main Content -->
        <div class="ml-64 w-full p-8">
            <h1 class="text-3xl font-bold mb-6">Patient Details</h1>

            <!-- Personal Details Section -->
            <div class="bg-white  shadow-md rounded-lg p-6 mb-6">
                <h2 class="text-2xl font-semibold text-center mb-4">Personal Information</h2>
              <div class="flex justify-between">
              <?php
                // Define the path to the profile picture
                $profile_picture_path = 'uploads/' . htmlspecialchars($biodata['profile_picture'] ?? 'default-profile.png');
                
                // Check if the file exists
                if (!file_exists($profile_picture_path)) {
                    $profile_picture_path = 'uploads/default-profile.png'; // Use default image if file not found
                }
                ?>

                <img src="<?php echo $profile_picture_path; ?>" alt="Profile Picture" class="w-32 h-32 rounded-full border-2 border-gray-300 mt-">
              <div class="flex flex-col">
               <p><strong>Name:</strong> <?php echo htmlspecialchars($biodata['name'] ?? 'N/A'); ?></p>
                <p><strong>Phone:</strong> <?php echo htmlspecialchars($biodata['phone'] ?? 'N/A'); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($biodata['email'] ?? 'N/A'); ?></p>
                <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($biodata['dob'] ?? 'N/A'); ?></p>
                <p><strong>Country of Origin:</strong> <?php echo htmlspecialchars($biodata['country_of_origin'] ?? 'N/A'); ?></p>
               </div>
              </div>
            </div>

            <!-- Bills Section -->
            <div>
                <h2 class="text-2xl font-semibold mb-2">Bills</h2>
                <?php if ($bills): ?>
                    <table class="min-w-full bg-white border-collapse">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="px-4 py-2 border">Consultation Fees</th>
                                <th class="px-4 py-2 border">Drugs Fees</th>
                                <th class="px-4 py-2 border">Lab Fees</th>
                                <th class="px-4 py-2 border">Ward Fees</th>
                                <th class="px-4 py-2 border">Total Fees</th>
                                <th class="px-4 py-2 border">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($bills as $bill): ?>
                                <tr>
                                    <td class="px-4 py-2 border"><?php echo htmlspecialchars($bill['consultation_fees']); ?></td>
                                    <td class="px-4 py-2 border"><?php echo htmlspecialchars($bill['drugs_fees']); ?></td>
                                    <td class="px-4 py-2 border"><?php echo htmlspecialchars($bill['lab_fees']); ?></td>
                                    <td class="px-4 py-2 border"><?php echo htmlspecialchars($bill['ward_fees']); ?></td>
                                    <td class="px-4 py-2 border"><?php echo htmlspecialchars($bill['total_fees']); ?></td>
                                    <td class="px-4 py-2 border"><?php echo htmlspecialchars($bill['date']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No bills found for this patient.</p>
                <?php endif; ?>
            </div>

            <!-- Appointments Section -->
            <div>
                <h2 class="text-2xl font-semibold mb-2">Appointments</h2>
                <?php if ($appointments): ?>
                    <table class="min-w-full bg-white border-collapse">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="px-4 py-2 border">Appointment ID</th>
                                <th class="px-4 py-2 border">Doctor</th>
                                <th class="px-4 py-2 border">Date</th>
                                <th class="px-4 py-2 border">Status</th>
                                <th class="px-4 py-2 border">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($appointments as $appointment): ?>
                                <tr>
                                    <td class="px-4 py-2 border"><?php echo htmlspecialchars($appointment['id']); ?></td>
                                    <td class="px-4 py-2 border"><?php echo htmlspecialchars($appointment['doctor_name']); ?></td>
                                    <td class="px-4 py-2 border"><?php echo htmlspecialchars($appointment['appointment_date']); ?></td>
                                    <td class="px-4 py-2 border"><?php echo htmlspecialchars($appointment['status']); ?></td>
                                    <td class="px-4 py-2 border">
                                        <button onclick="cancelAppointment(<?php echo htmlspecialchars($appointment['id']); ?>)" class="text-red-500 hover:underline">Cancel</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No appointments found for this patient.</p>
                <?php endif; ?>
            </div>

          
        </div>
    </div>

    <!-- Cancel Appointment Confirmation -->
    <script>
        function cancelAppointment(appointmentId) {
            if (confirm('Are you sure you want to cancel this appointment?')) {
                window.location.href = 'cancel_appointment.php?appointment_id=' + appointmentId;
            }
        }
    </script>
</body>
</html>

<?php
// Close database connection
mysqli_close($connect);
?>