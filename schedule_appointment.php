<?php
// Include database connection file
require "./public/include/connect.php";

// Check if the patient is logged in
session_start();
$patient_id = $_SESSION['patient_id'] ?? null;

if (!$patient_id) {
    echo "<script>alert('You must be logged in to manage appointments.'); window.location.href='patient_login.php';</script>";
    exit;
}

// Fetch patient details
$patient_query = "SELECT name, phone FROM patient_registration WHERE id = ?";
$stmt = mysqli_prepare($connect, $patient_query);
mysqli_stmt_bind_param($stmt, "i", $patient_id);
mysqli_stmt_execute($stmt);
$patient_result = mysqli_stmt_get_result($stmt);
$patient = mysqli_fetch_assoc($patient_result);

// Fetch all appointments with patient and doctor details
$query = "
    SELECT appointments.id, appointments.appointment_date, appointments.status, appointments.created_at, 
           patient_registration.name AS patient_name, patient_registration.phone AS patient_phone, 
           doctors.name AS doctor_name, doctors.phone AS doctor_contact
    FROM appointments
    JOIN patient_registration ON appointments.patient_id = patient_registration.id
    JOIN doctors ON appointments.doctor_id = doctors.id
";
$result = mysqli_query($connect, $query);

// Handle form submission for adding new appointments
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $doctor_id = mysqli_real_escape_string($connect, $_POST['doctor_id']);
    $hospital_id = mysqli_real_escape_string($connect, $_POST['hospital_id']); // Get hospital ID from the form
    $appointment_date = mysqli_real_escape_string($connect, $_POST['appointment_date']);
    $status = mysqli_real_escape_string($connect, $_POST['status']);

    $insertQuery = "INSERT INTO appointments (patient_id, doctor_id, hospital_id, appointment_date, status) 
                    VALUES ('$patient_id', '$doctor_id', '$hospital_id', '$appointment_date', '$status')";
    $insertResult = mysqli_query($connect, $insertQuery);

    if ($insertResult) {
        echo "<script>alert('Appointment Scheduled Successfully');</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($connect) . "');</script>";
    }
}

// Fetch hospitals from the database
$hospitalsQuery = "SELECT id, name FROM hospitals";
$hospitalsResult = mysqli_query($connect, $hospitalsQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Management</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="flex">
        <!-- Sidebar -->
        <?php require "./public/include/sidebar_admin.php"; ?>

        <!-- Main Content -->
        <div class="flex-1 p-8">
            <h1 class="mb-8 text-3xl font-bold">Manage Appointments</h1>

            <!-- Form to Add New Appointment -->
            <div class="mb-8">
                <h2 class="mb-4 text-2xl">Add New Appointment</h2>
                <form action="" method="POST" class="p-6 bg-white rounded shadow-md">
                    <div class="mb-4">
                        <label class="block text-gray-700">Patient Name</label>
                        <input type="text" value="<?php echo htmlspecialchars($patient['name']); ?>" class="w-full p-2 border-b border-gray-300 outline-none" readonly>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Patient Phone</label>
                        <input type="text" value="<?php echo htmlspecialchars($patient['phone']); ?>" class="w-full p-2 border-b border-gray-300 outline-none" readonly>
                    </div>
                    <div class="mb-4">
                        <label for="doctor_id" class="block text-gray-700">Doctor</label>
                        <select name="doctor_id" id="doctor_id" class="w-full p-2 border-b border-gray-300 outline-none" required>
                            <?php
                            // Fetch doctors from doctors table
                            $doctorsQuery = "SELECT id, name FROM doctors";
                            $doctorsResult = mysqli_query($connect, $doctorsQuery);
                            while ($doctor = mysqli_fetch_assoc($doctorsResult)) {
                                echo "<option value='" . $doctor['id'] . "'>" . $doctor['name'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="hospital_id" class="block text-gray-700">Hospital</label>
                        <select name="hospital_id" id="hospital_id" class="w-full p-2 border-b border-gray-300 outline-none" required>
                            <?php
                            // Fetch hospitals from hospitals table
                            while ($hospital = mysqli_fetch_assoc($hospitalsResult)) {
                                echo "<option value='" . $hospital['id'] . "'>" . $hospital['name'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="appointment_date" class="block text-gray-700">Appointment Date</label>
                        <input type="date" name="appointment_date" id="appointment_date" class="w-full p-2 border-b border-gray-300 outline-none" required>
                    </div>
                    <div class="mb-4">
                        <label for="status" class="block text-gray-700">Status</label>
                        <select name="status" id="status" class="w-full p-2 border-b border-gray-300 outline-none">
                            <option value="Scheduled">Scheduled</option>
                            <option value="Completed">Completed</option>
                            <option value="Cancelled">Cancelled</option>
                        </select>
                    </div>
                    <button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded">Add Appointment</button>
                </form>
            </div>

            <!-- Appointment Table -->
            <h2 class="mb-4 text-2xl">Appointments List</h2>
            <table class="w-full bg-white rounded shadow-md table-auto">
                <thead>
                    <tr class="text-left bg-gray-200">
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Patient Name</th>
                        <th class="px-4 py-2">Patient Phone</th>
                        <th class="px-4 py-2">Doctor Name</th>
                        <th class="px-4 py-2">Doctor Contact</th>
                        <th class="px-4 py-2">Appointment Date</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Created At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                        <tr>
                            <td class="px-4 py-2 border"><?php echo htmlspecialchars($row['id']); ?></td>
                            <td class="px-4 py-2 border"><?php echo htmlspecialchars($row['patient_name']); ?></td>
                            <td class="px-4 py-2 border"><?php echo htmlspecialchars($row['patient_phone']); ?></td>
                            <td class="px-4 py-2 border"><?php echo htmlspecialchars($row['doctor_name']); ?></td>
                            <td class="px-4 py-2 border"><?php echo htmlspecialchars($row['doctor_contact']); ?></td>
                            <td class="px-4 py-2 border"><?php echo htmlspecialchars($row['appointment_date']); ?></td>
                            <td class="px-4 py-2 border"><?php echo htmlspecialchars($row['status']); ?></td>
                            <td class="px-4 py-2 border"><?php echo htmlspecialchars($row['created_at']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

<?php
// Close database connection
mysqli_close($connect);
?>