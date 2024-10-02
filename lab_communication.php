<?php 
// Include database connection
require "./public/include/connect.php";

// Increase execution time limit
set_time_limit(300); // 5 minutes

// Example: Get active doctor ID (this should be set based on your authentication logic)
$active_doctor_id = 1; // Hardcoded for demonstration purposes; replace with actual active doctor ID

// Fetch available units
$units_query = "SELECT id, name FROM units";
$units_result = mysqli_query($connect, $units_query);

// Handle message submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['send_message'])) {
    $message = mysqli_real_escape_string($connect, $_POST['message']);
    $unit_id = mysqli_real_escape_string($connect, $_POST['unit_id']);

    // Insert message into the database
    $query = "INSERT INTO unit_messages (message, created_at, doctor_id, unit_id, role) 
              VALUES ('$message', NOW(), '$active_doctor_id', '$unit_id', 'doctor')";
    if (mysqli_query($connect, $query)) {
        $success_msg = "Message sent successfully to the selected unit.";
    } else {
        $error_msg = "Error: " . mysqli_error($connect);
    }
}

// Fetch messages from the lab (we'll keep this for reference)
$lab_query = "SELECT lm.id, lm.message, lm.created_at, d.name AS doctor_name, lm.role 
              FROM lab_messages lm 
              JOIN doctors d ON lm.doctor_id = d.id 
              WHERE lm.role = 'lab' AND lm.doctor_id = '$active_doctor_id'
              ORDER BY lm.created_at DESC";
$lab_result = mysqli_query($connect, $lab_query);

// Check if the result is valid
if (!$lab_result) {
    die("Query failed: " . mysqli_error($connect));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unit Communication</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex">
        <?php require "./public/include/sidebar_doctor.php"; // Adjust path if needed ?>
        
        <main class="flex-1 p-8">
            <div class="container mx-auto p-4">
                <div class="bg-white shadow-md rounded-lg p-6 max-w-3xl mx-auto">
                    <h1 class="text-xl font-bold mb-4">Unit Communication</h1>

                    <!-- Message Form with Unit Selection -->
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="space-y-4 mb-6">
                        <div class="flex flex-col mb-4">
                            <label for="unit_id" class="text-sm font-semibold text-gray-700 mb-2">Select Unit:</label>
                            <select id="unit_id" name="unit_id" class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                <option value="">Select a unit</option>
                                <?php while ($unit = mysqli_fetch_assoc($units_result)): ?>
                                    <option value="<?php echo $unit['id']; ?>"><?php echo htmlspecialchars($unit['name']); ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="flex flex-col mb-4">
                            <label for="message" class="text-sm font-semibold text-gray-700 mb-2">Your Message:</label>
                            <textarea id="message" name="message" rows="6" class="w-full h-32 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Type your message here..." required></textarea>
                        </div>
                        <button type="submit" name="send_message" class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Send Message</button>
                    </form>

                    <?php if (isset($success_msg)): ?>
                        <p class="mt-4 text-green-600"><?php echo htmlspecialchars($success_msg); ?></p>
                    <?php elseif (isset($error_msg)): ?>
                        <p class="mt-4 text-red-600"><?php echo htmlspecialchars($error_msg); ?></p>
                    <?php endif; ?>

                    <!-- Display Messages from the Lab (for reference) -->
                    <h2 class="text-lg font-bold mt-6 mb-4">Messages from the Lab</h2>
                    <?php if (mysqli_num_rows($lab_result) > 0): ?>
                        <ul>
                            <?php while ($row = mysqli_fetch_assoc($lab_result)): ?>
                                <li class="mb-4 p-4 border-b border-gray-300">
                                    <strong class="text-blue-500"><?php echo htmlspecialchars($row['doctor_name']); ?></strong> 
                                    <span class="text-gray-500 text-sm"><?php echo htmlspecialchars($row['created_at']); ?></span>
                                    <p class="text-gray-700 mt-2"><?php echo htmlspecialchars($row['message']); ?></p>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                    <?php else: ?>
                        <p class="text-gray-600">No messages from the lab yet.</p>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>
</body>
</html>