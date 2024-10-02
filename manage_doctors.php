<?php
session_start();
require './public/include/connect.php';

// Fetch all doctors from the database
$query = "SELECT d.id, d.name, d.specialty, d.phone, d.email, h.name AS hospital_name, d.created_at
          FROM doctors d
          LEFT JOIN hospitals h ON d.hospital_id = h.id
          ORDER BY d.name ASC";
$result = mysqli_query($connect, $query);

// Check for errors
if (!$result) {
    echo "Error fetching doctors: " . mysqli_error($connect);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Doctors</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
</head>
<body class="bg-gray-100 flex">

    <!-- Sidebar -->
    <?php require './public/include/sidebar_admin.php'; ?>

    <div class="flex-1 p-8">
        <div class="container mx-auto py-8">
            <h1 class="text-3xl font-bold mb-6">Manage Doctors</h1>

            <div class="bg-white shadow-md rounded-lg p-6">
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <table class="min-w-full border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="border px-4 py-2">ID</th>
                                <th class="border px-4 py-2">Name</th>
                                <th class="border px-4 py-2">Specialty</th>
                                <th class="border px-4 py-2">Phone</th>
                                <th class="border px-4 py-2">Email</th>
                                <th class="border px-4 py-2">Hospital</th>
                                <th class="border px-4 py-2">Created At</th>
                                <th class="border px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($doctor = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td class="border px-4 py-2"><?php echo htmlspecialchars($doctor['id'] ?? 'N/A'); ?></td>
                                    <td class="border px-4 py-2"><?php echo htmlspecialchars($doctor['name'] ?? 'N/A'); ?></td>
                                    <td class="border px-4 py-2"><?php echo htmlspecialchars($doctor['specialty'] ?? 'N/A'); ?></td>
                                    <td class="border px-4 py-2"><?php echo htmlspecialchars($doctor['phone'] ?? 'N/A'); ?></td>
                                    <td class="border px-4 py-2"><?php echo htmlspecialchars($doctor['email'] ?? 'N/A'); ?></td>
                                    <td class="border px-4 py-2"><?php echo htmlspecialchars($doctor['hospital_name'] ?? 'N/A'); ?></td>
                                    <td class="border px-4 py-2"><?php echo htmlspecialchars($doctor['created_at'] ?? 'N/A'); ?></td>
                                    <td class="border px-4 py-2 flex">
                                        <a href="edit_doctor.php?id=<?php echo $doctor['id']; ?>" class="text-blue-500 hover:underline">Edit</a>
                                        <a href="delete_doctor.php?id=<?php echo $doctor['id']; ?>" class="text-red-500 hover:underline ml-2">Delete</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No doctors found in the database.</p>
                <?php endif; ?>
            </div>

            <div class="mt-4">
                <a href="add_doctor.php" class="bg-blue-500 text-white px-4 py-2 rounded">Add New Doctor</a>
                <a href="admin_dashboard.php" class="bg-gray-500 text-white px-4 py-2 rounded">Back to Dashboard</a>
            </div>
        </div>
    </div>

</body>
</html>

<?php
// Close database connection
mysqli_close($connect);
?>