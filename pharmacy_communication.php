<?php 
session_start();
require "./public/include/connect.php"; // Include database connection

// Check if the pharmacist is logged in
if (!isset($_SESSION['pharmacist_id'])) {
    header("Location: pharmacist_login.php"); // Redirect to pharmacist login if not logged in
    exit();
}

// Get the logged-in pharmacist's ID
$id = $_SESSION['pharmacist_id'];

// Handle reply submission (sending a message from pharmacy to a department/unit)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reply_message'])) {
    $message = mysqli_real_escape_string($connect, $_POST['message']);
    $unit = mysqli_real_escape_string($connect, $_POST['unit']); // Unit the message is being sent to

    // Insert the message into the units_messages table, marking it as sent by pharmacy
    $query = "INSERT INTO units_messages (message, created_at, pharmacist_id, unit) 
              VALUES ('$message', NOW(), '$id', '$unit')";
    if (mysqli_query($connect, $query)) {
        $success_msg = "Message sent successfully to the $unit.";
    } else {
        $error_msg = "Error: " . mysqli_error($connect);
    }
}

// Fetch replies sent back to the pharmacist from doctors
$query_replies = "
    SELECT um.id, um.message, um.created_at, um.unit 
    FROM units_messages um 
    WHERE um.unit = 'Doctor' AND um.pharmacist_id != '$id' 
    ORDER BY um.created_at DESC";
$result_replies = mysqli_query($connect, $query_replies);

// Check if the result is valid
if (!$result_replies) {
    die("Query failed: " . mysqli_error($connect));
}

// Fetch pharmacist details (for display purposes)
$query_pharmacist = "SELECT name FROM pharmacists WHERE id = '$id'";
$pharmacist_result = mysqli_query($connect, $query_pharmacist);
$pharmacist = mysqli_fetch_assoc($pharmacist_result);

// Check if the result is valid
if (!$pharmacist) {
    die("Pharmacist not found: " . mysqli_error($connect));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pharmacy to Unit Communication</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
</head>
<body class="bg-gray-100">
    <div class="flex">
        <?php require "./public/include/sidebar_pharmacist.php"; // Include sidebar ?>
        
        <main class="flex-1 p-8">
            <div class="container p-4 mx-auto">
                <div class="max-w-3xl p-6 mx-auto bg-white rounded-lg shadow-md">
                    <h1 class="mb-4 text-xl font-bold">Communicate with Departments - Pharmacy <?php echo htmlspecialchars($pharmacist['name']); ?></h1>

                    <!-- Reply Form -->
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="mb-6 space-y-4">
                        <div class="flex flex-col mb-4">
                            <label for="unit" class="mb-2 text-sm font-semibold text-gray-700">Select Department:</label>
                            <select id="unit" name="unit" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                <option value="Doctor">Doctor</option>
                                <option value="Laboratory">Laboratory</option>
                                <option value="Finance">Finance</option>
                            </select>
                        </div>
                        <div class="flex flex-col mb-4">
                            <label for="message" class="mb-2 text-sm font-semibold text-gray-700">Your Message:</label>
                            <textarea id="message" name="message" rows="6" class="w-full h-32 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Type your message here..." required></textarea>
                        </div>
                        <button type="submit" name="reply_message" class="px-4 py-2 font-semibold text-white bg-blue-600 rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Send Message</button>
                    </form>

                    <?php if (isset($success_msg)): ?>
                        <p class="mt-4 text-green-600"><?php echo htmlspecialchars($success_msg); ?></p>
                    <?php elseif (isset($error_msg)): ?>
                        <p class="mt-4 text-red-600"><?php echo htmlspecialchars($error_msg); ?></p>
                    <?php endif; ?>

                    <!-- Display Replies -->
                    <h2 class="mt-6 mb-4 text-lg font-bold">Replies from Departments</h2>
                    <?php if (mysqli_num_rows($result_replies) > 0): ?>
                        <ul>
                            <?php while ($row = mysqli_fetch_assoc($result_replies)): ?>
                                <li class="p-4 mb-4 border-b border-gray-300">
                                    <span class="text-sm text-gray-500"><?php echo htmlspecialchars($row['created_at']); ?></span>
                                    <p class="mt-2 text-gray-700"><?php echo htmlspecialchars($row['message']); ?></p>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                    <?php else: ?>
                        <p class="text-gray-600">No replies from any department yet.</p>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>

</body>
</html>
 