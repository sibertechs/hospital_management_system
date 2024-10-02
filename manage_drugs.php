<?php
session_start();
require './public/include/connect.php';

// Fetch all unique drugs from the database, showing the summed quantity
$query = "
   SELECT id, name, dosage, SUM(quantity) AS total_quantity, created_at
FROM drugs
GROUP BY id, name, dosage, created_at
ORDER BY name ASC

";
$result = mysqli_query($connect, $query);

// Check for errors
if (!$result) {
    echo "Error fetching drugs: " . mysqli_error($connect);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Drugs</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
</head>
<body class="bg-gray-100 flex">

    <!-- Sidebar -->
    <?php require './public/include/sidebar_admin.php'; ?>

    <div class="flex-1 p-8">
        <div class="container mx-auto py-8">
            <h1 class="text-3xl font-bold mb-6">View Drugs</h1>

            <div class="bg-white shadow-md rounded-lg p-6">
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <table class="min-w-full border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="border px-4 py-2">ID</th>
                                <th class="border px-4 py-2">Name</th>
                                <th class="border px-4 py-2">Dosage</th>
                                <th class="border px-4 py-2">Quantity</th>
                                <th class="border px-4 py-2">Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($drug = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td class="border px-4 py-2"><?php echo htmlspecialchars($drug['id']); ?></td>
                                    <td class="border px-4 py-2"><?php echo htmlspecialchars($drug['name']); ?></td>
                                    <td class="border px-4 py-2"><?php echo htmlspecialchars($drug['dosage']); ?></td>
                                    <td class="border px-4 py-2"><?php echo htmlspecialchars($drug['total_quantity']); ?></td>
                                    <td class="border px-4 py-2"><?php echo htmlspecialchars($drug['created_at']); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No drugs found in the database.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

</body>
</html>

<?php
// Close database connection
mysqli_close($connect);
?>
