<?php
session_start();
require "./public/include/connect.php";

// Check if the finance personnel is logged in
if (!isset($_SESSION['finance_staff_id'])) {
    header("Location: finance_login.php"); 
    exit();
}

// Constants for department names
define('UNIT_DOCTOR', 'Doctor');
define('UNIT_PHARMACY', 'Pharmacy');
define('UNIT_LABORATORY', 'Laboratory');

// Get the logged-in finance personnel's ID
$finance_staff_id = $_SESSION['finance_staff_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['send_message'])) {
    $message = mysqli_real_escape_string($connect, $_POST['message']);
    $unit = mysqli_real_escape_string($connect, $_POST['unit']); 

    // Insert the message into the units_messages table, marking it as sent by finance
    $query = "INSERT INTO units_messages (message, created_at, finance_staff_id, unit, sender_type) 
              VALUES ('$message', NOW(), '$finance_staff_id', '$unit', 'finance')";
    if (mysqli_query($connect, $query)) {
        $success_msg = "Message sent successfully to the $unit.";
    } else {
        $error_msg = "Error: " . mysqli_error($connect);
    }
}

// Fetch finance personnel details (for display purposes)
$query_finance_staff = "SELECT name FROM finance WHERE id = '$finance_staff_id'";
$finance_staff_result = mysqli_query($connect, $query_finance_staff);
$finance_staff = mysqli_fetch_assoc($finance_staff_result);

if (!$finance_staff) {
    die("Finance personnel not found: " . mysqli_error($connect));
}

// Fetch messages sent to the finance department and messages sent by the finance department
$query_messages = "
    SELECT message, created_at, unit, sender_type,
           CASE
               WHEN sender_type = 'finance' THEN 'Sent to'
               ELSE 'Received from'
           END AS message_direction
    FROM units_messages 
    WHERE (finance_staff_id = '$finance_staff_id' AND sender_type = 'finance')
       OR (unit = 'Finance' AND sender_type != 'finance')
    ORDER BY created_at DESC";
$result_messages = mysqli_query($connect, $query_messages);

// Error handling for message fetching
if (!$result_messages) {
    die("Error fetching messages: " . mysqli_error($connect));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finance to Unit Communication</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
</head>
<body class="bg-gray-100">
    <div class="flex">
        <?php require "./public/include/sidebar_finance.php"; // Include sidebar ?>
        
        <main class="flex-1 p-8">
            <div class="container p-4 mx-auto">
                <div class="max-w-3xl p-6 mx-auto bg-white rounded-lg shadow-md">
                    <h1 class="mb-4 text-xl font-bold">Communicate with Departments - <?php echo htmlspecialchars($finance_staff['name']); ?></h1>

                    <!-- Message Form -->
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="mb-6 space-y-4">
                        <div class="flex flex-col mb-4">
                            <label for="unit" class="mb-2 text-sm font-semibold text-gray-700">Select Department:</label>
                            <select id="unit" name="unit" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                <option value="<?php echo UNIT_DOCTOR; ?>">Doctor</option>
                                <option value="<?php echo UNIT_PHARMACY; ?>">Pharmacy</option>
                                <option value="<?php echo UNIT_LABORATORY; ?>">Laboratory</option>
                            </select>
                        </div>
                        <div class="flex flex-col mb-4">
                            <label for="message" class="mb-2 text-sm font-semibold text-gray-700">Your Message:</label>
                            <textarea id="message" name="message" rows="6" class="w-full h-32 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Type your message here..." required></textarea>
                        </div>
                        <button type="submit" name="send_message" class="px-4 py-2 font-semibold text-white bg-blue-600 rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Send Message</button>
                    </form>

                    <?php if (isset($success_msg)): ?>
                        <p class="mt-4 text-green-600"><?php echo htmlspecialchars($success_msg); ?></p>
                    <?php elseif (isset($error_msg)): ?>
                        <p class="mt-4 text-red-600"><?php echo htmlspecialchars($error_msg); ?></p>
                    <?php endif; ?>

                    <!-- Display Messages -->
                    <h2 class="mt-6 mb-4 text-lg font-bold">Messages</h2>
                    <?php if (mysqli_num_rows($result_messages) > 0): ?>
                        <ul>
                            <?php while ($row = mysqli_fetch_assoc($result_messages)): ?>
                                <li class="p-4 mb-4 border-b border-gray-300">
                                    <span class="text-sm text-gray-500"><?php echo htmlspecialchars($row['created_at']); ?></span>
                                    <p class="mt-2 text-gray-700"><?php echo htmlspecialchars($row['message']); ?></p>
                                    <span class="text-sm text-gray-500">
                                        <?php echo htmlspecialchars($row['message_direction'] . ': ' . $row['unit']); ?>
                                    </span>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                    <?php else: ?>
                        <p class="text-gray-600">No messages yet.</p>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>
</body>
</html>