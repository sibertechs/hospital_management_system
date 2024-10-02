<?php
// Include database connection file
require "./public/include/connect.php";
session_start();

// Check if the patient is logged in
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

// Fetch all doctors
function fetchDoctors() {
    global $connect;
    $doctors = [];
    $query = "SELECT * FROM doctors"; 
    $result = mysqli_query($connect, $query);
    while($row = mysqli_fetch_assoc($result)) {
        $doctors[] = $row;
    }
    return $doctors;
}

// Fetch all hospitals
function fetchHospitals() {
    global $connect;
    $hospitals = [];
    $query = "SELECT * FROM hospitals"; 
    $result = mysqli_query($connect, $query);
    while($row = mysqli_fetch_assoc($result)) {
        $hospitals[] = $row;
    }
    return $hospitals;
}

// Handle form submission for adding new appointments
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $doctor_id = mysqli_real_escape_string($connect, $_POST['doctor']);
    $hospital_id = mysqli_real_escape_string($connect, $_POST['hospital']);
    $appointment_date = mysqli_real_escape_string($connect, $_POST['appointment_date']);
    $status = mysqli_real_escape_string($connect, $_POST['status']);

    // Insert appointment into the database
    $query = "INSERT INTO appointments (patient_id, doctor_id, hospital_id, appointment_date, status) 
              VALUES ('$patient_id', '$doctor_id', '$hospital_id', '$appointment_date', '$status')";

    if (mysqli_query($connect, $query)) {
        // Redirect to patient details page to view the appointment
        header("Location: patient_details.php"); 
        exit();
    } else {
        echo "<script>alert('Error booking appointment. Please try again.');</script>";
    }
}

$doctors = fetchDoctors();
$hospitals = fetchHospitals();
?>

<!DOCTYPE html>
<html lang="en">
<?php require "./public/include/head.php"; ?>
<body class="bg-gray-100">

    <!-- Sidebar -->
    <div class="flex flex-col md:flex-row">
        <?php require "./public/include/sidebar_patient.php"; ?>
        
        <!-- Main Content -->
        <div class="w-full p-8 md:w-3/4">
            <div class="container max-w-2xl p-6 mx-auto bg-white rounded-lg shadow-lg">
                <h1 class="mb-6 text-3xl font-bold text-center text-gray-800">Patient Appointment Request Form</h1>

                <form action="patient_appointment.php" method="POST" class="space-y-4">
                    <!-- Patient Information (Required) -->
                    <div class="p-4 rounded-lg shadow-md bg-gray-50">
                        <h2 class="mb-2 text-xl font-semibold text-gray-800">Your Information</h2>
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div class="my-1">
                                <label for="patient_name" class="block text-gray-700">Name</label>
                                <input type="text" id="patient_name" name="patient_name" value="<?php echo htmlspecialchars($patient['name']); ?>" required class="block w-full p-2 border border-gray-300 rounded-md shadow-sm outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" readonly>
                            </div>
                            
                            <div class="my-1">
                                <label for="patient_phone" class="block text-gray-700">Phone</label>
                                <input type="text" id="patient_phone" name="patient_phone" value="<?php echo htmlspecialchars($patient['phone']); ?>" required class="block w-full p-2 border border-gray-300 rounded-md shadow-sm outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" readonly>
                            </div>
                            <div class="my-1">
                                <label for="patient_gender" class="block text-gray-700">Gender</label>
                                <select name="patient_gender" id="patient_gender" required class="block w-full p-2 border border-gray-300 rounded-md shadow-sm outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="">Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>

                            <div class="my-1">
                                <label for="appointment_date" class="block text-gray-700">Appointment Date</label>
                                <input type="date" id="appointment_date" name="appointment_date" required class="block w-full p-2 border border-gray-300 rounded-md shadow-sm outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                        </div>
                    </div>

                    <!-- Doctor Selection -->
                    <div class="p-4 rounded-lg shadow-md bg-gray-50">
                        <h2 class="mb-2 text-xl font-semibold text-gray-800">Select Doctor</h2>
                        <select id="doctor" name="doctor" required class="block w-full p-2 border border-gray-300 rounded-md shadow-sm outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">Choose a Doctor</option>
                            <?php foreach ($doctors as $doctor): ?>
                                <option value="<?= $doctor['id']; ?>"><?= $doctor['name'] . ' - ' . $doctor['phone']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Hospital Selection -->
                    <div class="p-4 rounded-lg shadow-md bg-gray-50">
                        <h2 class="mb-2 text-xl font-semibold text-gray-800">Select Hospital</h2>
                        <select id="hospital" name="hospital" required class="block w-full p-2 border border-gray-300 rounded-md shadow-sm outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">Choose a Hospital</option>
                            <?php foreach ($hospitals as $hospital): ?>
                                <option value="<?= $hospital['id']; ?>"><?= $hospital['name'] . ' - ' . $hospital['address']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="status" class="block text-gray-700">Status</label>
                        <select name="status" id="status" class="w-full p-2 border-b border-gray-300 outline-none">
                            <option value="Scheduled">Scheduled</option>
                            <option value="Completed">Completed</option>
                            <option value="Cancelled">Cancelled</option>
                        </select>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <input type="submit" value="Submit Appointment Request" class="w-full p-3 mt-6 font-bold text-white bg-indigo-600 rounded-md cursor-pointer hover:bg-indigo-700">
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>