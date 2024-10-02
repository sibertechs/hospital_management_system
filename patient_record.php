<?php
session_start();
require "./public/include/connect.php";

// Check if patient ID is set in session
if (!isset($_SESSION['patient_id'])) {
    die("Patient ID not found in session.");
}

// Retrieve patient ID from session
$patient_id = $_SESSION['patient_id'];

// Query patient registration information
$query_patient = "SELECT * FROM patient_registration WHERE id = ?";
$stmt_patient = mysqli_prepare($connect, $query_patient);
mysqli_stmt_bind_param($stmt_patient, "i", $patient_id);
mysqli_stmt_execute($stmt_patient);
$result_patient = mysqli_stmt_get_result($stmt_patient);

// Check if patient exists
if ($result_patient->num_rows == 0) {
    die("Invalid patient ID: $patient_id");
}

// Fetch patient data
$patient_data = $result_patient->fetch_assoc();

// Query appointments for the patient, including doctor's name
$query_appointments = "
    SELECT a.*, d.name AS doctor_name 
    FROM appointments a 
    JOIN doctors d ON a.doctor_id = d.id 
    WHERE a.patient_id = ?";
$stmt_appointments = mysqli_prepare($connect, $query_appointments);
mysqli_stmt_bind_param($stmt_appointments, "i", $patient_id);
mysqli_stmt_execute($stmt_appointments);
$result_appointments = mysqli_stmt_get_result($stmt_appointments);

// Query prescriptions for the patient
$query_prescriptions = "SELECT * FROM prescriptions WHERE patient_id = ?";
$stmt_prescriptions = mysqli_prepare($connect, $query_prescriptions);
mysqli_stmt_bind_param($stmt_prescriptions, "i", $patient_id);
mysqli_stmt_execute($stmt_prescriptions);
$result_prescriptions = mysqli_stmt_get_result($stmt_prescriptions);

// Query transactions for the patient, including drug names
$query_transactions = "
    SELECT t.transaction_date, t.amount, t.type, t.description, d.drug_name AS drug_name, t.drug_price 
    FROM transactions t 
    JOIN drugs d ON t.drug_id = d.id 
    WHERE t.patient_id = ?";
$stmt_transactions = mysqli_prepare($connect, $query_transactions);
mysqli_stmt_bind_param($stmt_transactions, "i", $patient_id);
mysqli_stmt_execute($stmt_transactions);
$result_transactions = mysqli_stmt_get_result($stmt_transactions);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Records</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
</head>
<body class="bg-gray-100">
    <div class="flex">
        <?php require "./public/include/sidebar_patient.php"; // Include sidebar ?>
        
        <main class="flex-1 p-8">
            <div class="container p-4 mx-auto">
                <h1 class="mb-6 text-3xl font-bold">Patient Records</h1>

                <!-- Patient Information Card -->
                <div class="p-6 mb-8 bg-white rounded-lg shadow-md">
                    <h2 class="mb-4 text-xl font-bold">Patient Information</h2>
                    <p><strong>Patient ID:</strong> <?php echo isset($patient_data['id']) ? htmlspecialchars($patient_data['id']) : 'N/A'; ?></p>
                    <p><strong>Name:</strong> <?php echo isset($patient_data['name']) ? htmlspecialchars($patient_data['name']) : 'N/A'; ?></p>
                    <p><strong>Phone:</strong> <?php echo isset($patient_data['phone']) ? htmlspecialchars($patient_data['phone']) : 'N/A'; ?></p>
                    <p><strong>Email:</strong> <?php echo isset($patient_data['email']) ? htmlspecialchars($patient_data['email']) : 'N/A'; ?></p>
                    <p><strong>Date of Birth:</strong> <?php echo isset($patient_data['dob']) ? htmlspecialchars($patient_data['dob']) : 'N/A'; ?></p>
                    <p><strong>Country of Origin:</strong> <?php echo isset($patient_data['country_of_origin']) ? htmlspecialchars($patient_data['country_of_origin']) : 'N/A'; ?></p>
                </div>

                <!-- Appointments Card -->
                <div class="p-6 mb-8 bg-white rounded-lg shadow-md">
                    <h2 class="mb-4 text-xl font-bold">Appointments</h2>
                    <table class="min-w-full bg-white border border-gray-300">
                        <thead>
                            <tr class="text-white bg-blue-600">
                                <th class="px-4 py-2">Date</th>
                                <th class="px-4 py-2">Doctor</th>
                                <th class="px-4 py-2">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result_appointments->fetch_assoc()) : ?>
                                <tr class="border-t border-gray-300">
                                    <td class="px-4 py-2"><?php echo isset($row['appointment_date']) ? htmlspecialchars($row['appointment_date']) : 'N/A'; ?></td>
                                    <td class="px-4 py-2"><?php echo isset($row['doctor_name']) ? htmlspecialchars($row['doctor_name']) : 'N/A'; ?></td>
                                    <td class="px-4 py-2"><?php echo isset($row['status']) ? htmlspecialchars($row['status']) : 'N/A'; ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Prescriptions Card -->
                <div class="p-6 mb-8 bg-white rounded-lg shadow-md">
                    <h2 class="mb-4 text-xl font-bold">Prescriptions</h2>
                    <table class="min-w-full bg-white border border-gray-300">
                        <thead>
                            <tr class="text-white bg-blue-600">
                                <th class="px-4 py-2">Drug Name</th>
                                <th class="px-4 py-2">Dosage</th>
                                <th class="px-4 py-2">Duration</th>
                                <th class="px-4 py-2">Instructions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result_prescriptions->fetch_assoc()) : ?>
                                <tr class="border-t border-gray-300">
                                    <td class="px-4 py-2"><?php echo isset($row['drug_name']) ? htmlspecialchars($row['drug_name']) : 'N/A'; ?></td>
                                    <td class="px-4 py-2"><?php echo isset($row['dosage']) ? htmlspecialchars($row['dosage']) : 'N/A'; ?></td>
                                    <td class="px-4 py-2"><?php echo isset($row['duration']) ? htmlspecialchars($row['duration']) : 'N/A'; ?></td>
                                    <td class="px-4 py-2"><?php echo isset($row['instructions']) ? htmlspecialchars($row['instructions']) : 'N/A'; ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Transactions Card -->
                <div class="p-6 mb-8 bg-white rounded-lg shadow-md">
                    <h2 class="mb-4 text-xl font-bold">Transactions</h2>
                    <table class="min-w-full bg-white border border-gray-300">
                        <thead>
                            <tr class="text-white bg-blue-600">
                                <th class="px-4 py-2">Transaction Date</th>
                                <th class="px-4 py-2">Amount</th>
                                <th class="px-4 py-2">Type</th>
                                <th class="px-4 py-2">Description</th>
                                <th class="px-4 py-2">Drug Name</th>
                                <th class="px-4 py-2">Drug Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result_transactions->fetch_assoc()) : ?>
                                <tr class="border-t border-gray-300">
                                    <td class="px-4 py-2"><?php echo isset($row['transaction_date']) ? htmlspecialchars($row['transaction_date']) : 'N/A'; ?></td>
                                    <td class="px-4 py-2"><?php echo isset($row['amount']) ? htmlspecialchars($row['amount']) : 'N/A'; ?></td>
                                    <td class="px-4 py-2"><?php echo isset($row['type']) ? htmlspecialchars($row['type']) : 'N/A'; ?></td>
                                    <td class="px-4 py-2"><?php echo isset($row['description']) ? htmlspecialchars($row['description']) : 'N/A'; ?></td>
                                    <td class="px-4 py-2"><?php echo isset($row['drug_name']) ? htmlspecialchars($row['drug_name']) : 'N/A'; ?></td>
                                    <td class="px-4 py-2"><?php echo isset($row['drug_price']) ? htmlspecialchars($row['drug_price']) : 'N/A'; ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
