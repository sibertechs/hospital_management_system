<?php
// Assuming you have a database connection
require "./public/include/connect.php";

// Fetch existing appointments with patient names
$query = "
    SELECT 
        a.id, 
        a.patient_id, 
        a.appointment_date, 
        a.doctor_name, 
        a.status, 
        p.name AS patient_name
    FROM 
        appointments a
    JOIN 
        patient_registration p ON a.patient_id = p.id
";
$appointments = $connect->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Appointments</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
</head>
<body class="bg-gray-100">
    <div class="flex">
        <!-- Sidebar -->
      <?php
          require "./public/include/sidebar_doctor.php";
      ?>

        <!-- Main Content -->
        <div class="w-4/5 p-6">
            <h1 class="mb-6 text-3xl font-bold">View Appointments</h1>

            <!-- View Appointments Table -->
            <div class="p-4 bg-white rounded shadow-md">
                <h2 class="mb-4 text-xl font-bold">Scheduled Appointments</h2>
                <table class="w-full text-left table-auto">
                    <thead>
                        <tr class="text-white bg-blue-600">
                            <th class="px-4 py-2">Patient Name</th>
                            <th class="px-4 py-2">Appointment Date</th>
                            <th class="px-4 py-2">Doctor Name</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $appointments->fetch_assoc()) : ?>
                            <tr class="border-t border-gray-300">
                                <td class="px-4 py-2"><?php echo htmlspecialchars($row['patient_name'] ?? 'N/A'); ?></td>
                                <td class="px-4 py-2"><?php echo htmlspecialchars($row['appointment_date'] ?? 'N/A'); ?></td>
                                <td class="px-4 py-2"><?php echo htmlspecialchars($row['doctor_name'] ?? 'N/A'); ?></td>
                                <td class="px-4 py-2"><?php echo htmlspecialchars($row['status'] ?? 'N/A'); ?></td>
                                <td class="px-4 py-2">
                                    <a href="edit_appointment.php?id=<?php echo $row['id']; ?>" class="text-blue-600">Edit</a>
                                    |
                                    <a href="delete_appointment.php?id=<?php echo $row['id']; ?>" class="text-red-600" onclick="return confirm('Are you sure you want to delete this appointment?')">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
