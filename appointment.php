<?php
require "./public/include/connect.php";
session_start(); 

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

$doctors = fetchDoctors();
$hospitals = fetchHospitals();
?>

<!DOCTYPE html>
<html lang="en">
<?php require "./public/include/head.php"; ?>
<body class="bg-gray-100">

    <!-- Sidebar -->
    <div class="flex">
       
    <?php require "./public/include/sidebar.php"; ?>
        <!-- Main Content -->
        <div class="w-4/5 p-8">
            <div class="container mx-auto bg-white p-8 rounded-lg shadow-lg max-w-2xl">
                <h1 class="text-3xl font-bold text-center mb-8 text-gray-800">Patient Appointment Request Form</h1>

                <form action="submit_appointment.php" method="POST" class="space-y-6">
                    <!-- Patient Information (Required) -->
                    <div>
                        <h2 class="text-xl font-semibold mb-4 text-gray-700">Patient Information (Required)</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="my-3">
                                <input type="text" id="patient_name" name="patient_name" required class="mt-1 p-2 block w-full border border-gray-300 outline-none rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Patient Name">
                            </div>
                            
                            <div class="my-3">
                                <input type="text" id="patient_phone" name="patient_phone" required class="mt-1 p-2 block w-full border border-gray-300 outline-none rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Patient's Phone Number">
                            </div>
                            <div class="my-3">
                                <select name="patient_gender" id="patient_gender" required class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="">Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>

                            <div class="my-3">
                                <input type="date" id="appointment_date" name="appointment_date" required class="mt-1 p-2 block w-full border border-gray-300 outline-none rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Date of Appointment">
                            </div>
                        </div>
                    </div>

                    <!-- Doctor Selection -->
                    <div>
                        <select id="doctor" name="doctor" required class="mt-1 p-2 block w-full border border-gray-300 rounded-md outline-none shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">Choose a Doctor</option>
                            <?php foreach ($doctors as $doctor): ?>
                                <option value="<?= $doctor['id']; ?>"><?= $doctor['doctor_name'] . ' - ' . $doctor['doctor_phone']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Hospital Selection -->
                    <div>
                        <select id="hospital" name="hospital" required class="mt-1 p-2 block w-full border border-gray-300 rounded-md outline-none shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">Choose a Hospital</option>
                            <?php foreach ($hospitals as $hospital): ?>
                                <option value="<?= $hospital['id']; ?>"><?= $hospital['hospital_name'] . ' - ' . $hospital['hospital_location']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <input type="submit" value="Submit Appointment Request" class="w-full p-3 mt-6 bg-indigo-600 text-white font-bold rounded-md hover:bg-indigo-700 cursor-pointer">
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
