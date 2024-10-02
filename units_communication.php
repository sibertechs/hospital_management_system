<?php 
session_start();
require "./public/include/connect.php";

// Check if the doctor is logged in
if (!isset($_SESSION['doctor_id'])) {
    header("Location: doctor_login.php");
    exit();
}

// Get the logged-in doctor's ID
$doctor_id = $_SESSION['doctor_id'];

// Handle reply submission (sending a message from the doctor to the unit)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reply_message'])) {
    $message = mysqli_real_escape_string($connect, $_POST['message']);
    $unit = mysqli_real_escape_string($connect, $_POST['unit']); // Unit the message is being sent to

    // Insert the message into the units_messages table, marking it as sent by the doctor
    $query = "INSERT INTO units_messages (message, created_at, doctor_id, unit) 
              VALUES ('$message', NOW(), '$doctor_id', '$unit')";
    if (mysqli_query($connect, $query)) {
        $success_msg = "Message sent successfully to the $unit.";
    } else {
        $error_msg = "Error: " . mysqli_error($connect);
    }
}

// Fetch messages sent by units to the logged-in doctor
$query = "SELECT um.id, um.message, um.created_at, um.unit 
          FROM units_messages um 
          WHERE um.doctor_id = '$doctor_id'
          AND um.unit IS NOT NULL  -- Ensures messages are from units
          ORDER BY um.created_at DESC";
$result = mysqli_query($connect, $query);

// Check if the result is valid
if (!$result) {
    die("Query failed: " . mysqli_error($connect));
}

// Fetch doctor details (for display purposes)
$query_doctor = "SELECT name FROM doctors WHERE id = '$doctor_id'";
$doctor_result = mysqli_query($connect, $query_doctor);
$doctor = mysqli_fetch_assoc($doctor_result);

// Check if the result is valid
if (!$doctor) {
    die("Doctor not found: " . mysqli_error($connect));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Units to Doctor Communication</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex">
        <?php require "./public/include/sidebar_doctor.php"; // Adjust path if needed ?>
        
        <main class="flex-1 p-8">
            <div class="container p-4 mx-auto">
                <div class="max-w-3xl p-6 mx-auto bg-white rounded-lg shadow-md">
                    <h1 class="mb-4 text-xl font-bold">Communicate with Dr. <?php echo htmlspecialchars($doctor['name']); ?></h1>

                    <!-- Reply Form -->
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="mb-6 space-y-4">
                        <div class="flex flex-col mb-4">
                            <label for="unit" class="mb-2 text-sm font-semibold text-gray-700">Select Unit:</label>
                            <select id="unit" name="unit" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                <option value="Radiology">Radiology</option>
                                <option value="Pharmacy">Pharmacy</option>
                                <option value="Laboratory">Laboratory</option>
                                <option value="Finance">Finance</option>
                                <option value="Other">Other</option>
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

                    <!-- Display Messages -->
                    <h2 class="mt-6 mb-4 text-lg font-bold">Messages from Units to Dr. <?php echo htmlspecialchars($doctor['name']); ?></h2>
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <ul>
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                <li class="p-4 mb-4 border-b border-gray-300">
                                    <span class="text-sm text-gray-500"><?php echo htmlspecialchars($row['created_at']); ?> - <strong><?php echo htmlspecialchars($row['unit']); ?></strong></span>
                                    <p class="mt-2 text-gray-700"><?php echo htmlspecialchars($row['message']); ?></p>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                    <?php else: ?>
                        <p class="text-gray-600">No messages from any unit to the doctor yet.</p>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
