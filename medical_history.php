<?php
// Include database connection file
require "./public/include/connect.php";

// Check if 'patient_id' is passed in the URL
if (!isset($_GET['patient_id']) || empty($_GET['patient_id'])) {
    die("Invalid patient ID.");
}

$patient_id = intval($_GET['patient_id']); // Ensure patient_id is an integer

// Fetch patient details
$query = "SELECT name FROM patients WHERE id = ?";
$stmt = $connect->prepare($query);
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$result = $stmt->get_result();
$patient = $result->fetch_assoc();
$stmt->close();

if (!$patient) {
    die("Patient not found.");
}

// Fetch medical history records for the specified patient
$query = "
    SELECT mh.id, mh.visit_date, mh.diagnosis, mh.treatment, mh.visit_notes, d.name AS doctor_name
    FROM medical_history mh
    JOIN doctors d ON mh.doctor_id = d.id
    WHERE mh.patient_id = ?
    ORDER BY mh.visit_date DESC
";

$stmt = $connect->prepare($query);
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$result = $stmt->get_result();
$records = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
$connect->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical History</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-8">
        <h1 class="text-3xl font-bold mb-8">Medical History for <?php echo htmlspecialchars($patient['name']); ?></h1>

        <!-- Display medical history records -->
        <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
            <thead>
                <tr class="border-b">
                    <th class="py-2 px-4 text-left">Date of Visit</th>
                    <th class="py-2 px-4 text-left">Diagnosis</th>
                    <th class="py-2 px-4 text-left">Treatment</th>
                    <th class="py-2 px-4 text-left">Visit Notes</th>
                    <th class="py-2 px-4 text-left">Doctor Name</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($records)): ?>
                    <tr>
                        <td colspan="5" class="py-2 px-4 text-center">No medical history records found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($records as $record): ?>
                        <tr class="border-b">
                            <td class="py-2 px-4"><?php echo htmlspecialchars($record['visit_date']); ?></td>
                            <td class="py-2 px-4"><?php echo htmlspecialchars($record['diagnosis']); ?></td>
                            <td class="py-2 px-4"><?php echo htmlspecialchars($record['treatment']); ?></td>
                            <td class="py-2 px-4"><?php echo htmlspecialchars($record['visit_notes']); ?></td>
                            <td class="py-2 px-4"><?php echo htmlspecialchars($record['doctor_name']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
