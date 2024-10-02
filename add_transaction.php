<?php
// Add your database connection code here
require "./public/include/connect.php";

if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $transaction_date = $_POST['transaction_date'];
    $amount = $_POST['amount'];
    $type = $_POST['type'];
    $description = $_POST['description'];
    $drug_id = $_POST['drug_id'] ?? '';
    $drug_price = $_POST['drug_price'] ?? '';
    $patient_id = $_POST['patient_id'] ?? ''; // Added patient_id

    $sql = "INSERT INTO transactions (transaction_date, amount, type, description, drug_id, drug_price, patient_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $connect->prepare($sql);
    $stmt->bind_param("sssssii", $transaction_date, $amount, $type, $description, $drug_id, $drug_price, $patient_id);

    if ($stmt->execute()) {
        $message = "New transaction added successfully";
    } else {
        $message = "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Fetch drugs for the dropdown
$drugsQuery = "SELECT id, drug_name, price FROM drugs";
$drugsResult = $connect->query($drugsQuery);

if (!$drugsResult) {
    die("Error fetching drugs: " . $connect->error);
}

// Fetch patient_registration for the dropdown
$patientsQuery = "SELECT id, name FROM patient_registration";
$patientsResult = $connect->query($patientsQuery);

if (!$patientsResult) {
    die("Error fetching patients: " . $connect->error);
}

$connect->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Transaction</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Mobile Navigation Button -->
    <div id="navButton" class="fixed top-0 left-[-7rem] z-50 p-4 ml-0 lg:hidden">
        <button onclick="toggleSidebar()" class="p-2 text-white bg-blue-600 rounded-md shadow-md focus:outline-none">
            <i class="text-2xl fas fa-bars"></i> <!-- Open Button -->
        </button>
    </div>

    <div class="flex">
        <!-- Sidebar (Initially hidden on mobile) -->
        <?php require "./public/include/sidebar_finance.php"; ?>

        <!-- Overlay for mobile when sidebar is open -->
        <div id="overlay" class="fixed inset-0 z-30 hidden bg-black opacity-50 md:hidden" onclick="toggleSidebar()"></div>

        <!-- Page Content -->
        <main class="flex-1 ml-4">
            <div class="p-8 ml-4">
                <h1 class="mb-4 text-2xl font-bold">Add Transaction</h1>

                <?php if (isset($message)): ?>
                    <div class="p-4 mb-4 text-green-800 bg-green-200 rounded-md"><?= htmlspecialchars($message) ?></div>
                <?php endif; ?>

                <form action="add_transaction.php" method="POST" class="p-6 bg-white rounded-md shadow-md">
                    <div class="mb-4">
                        <label for="transaction_date" class="block text-gray-700">Transaction Date</label>
                        <input type="date" id="transaction_date" name="transaction_date" required class="w-full p-2 mt-1 border border-gray-300 rounded-md">
                    </div>
                    <div class="mb-4">
                        <label for="amount" class="block text-gray-700">Amount</label>
                        <input type="number" id="amount" name="amount" step="0.01" required class="w-full p-2 mt-1 border border-gray-300 rounded-md">
                    </div>
                    <div class="mb-4">
                        <label for="type" class="block text-gray-700">Transaction Type</label>
                        <select id="type" name="type" required class="w-full p-2 mt-1 border border-gray-300 rounded-md">
                            <option value="Credit">Credit</option>
                            <option value="Debit">Debit</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="drug_id" class="block text-gray-700">Drug</label>
                        <select id="drug_id" name="drug_id" required class="w-full p-2 mt-1 border border-gray-300 rounded-md">
                            <option value="">Select Drug</option>
                            <?php while ($drug = $drugsResult->fetch_assoc()): ?>
                                <option value="<?php echo htmlspecialchars($drug['id']); ?>" data-price="<?php echo htmlspecialchars($drug['price']); ?>">
                                    <?php echo htmlspecialchars($drug['drug_name']); ?> - ₵<?php echo htmlspecialchars($drug['price']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                        <input type="hidden" id="drug_price" name="drug_price">
                    </div>
                    <div class="mb-4">
                        <label for="patient_id" class="block text-gray-700">Patient</label>
                        <select id="patient_id" name="patient_id" required class="w-full p-2 mt-1 border border-gray-300 rounded-md">
                            <option value="">Select Patient</option>
                            <?php while ($patient = $patientsResult->fetch_assoc()): ?>
                                <option value="<?php echo htmlspecialchars($patient['id']); ?>">
                                    <?php echo htmlspecialchars($patient['name']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="description" class="block text-gray-700">Description</label>
                        <textarea id="description" name="description" rows="4" class="w-full p-2 mt-1 border border-gray-300 rounded-md"></textarea>
                    </div>
                    <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">Add Transaction</button>
                </form>
            </div>
        </main>
    </div>

    <script>
        function toggleDropdown(dropdownId) {
            var dropdown = document.getElementById(dropdownId);
            dropdown.classList.toggle('hidden');
        }

        function toggleSidebar() {
            var sidebar = document.getElementById('sidebar');
            var overlay = document.getElementById('overlay');
            var navButton = document.getElementById('navButton');

            // Toggle sidebar visibility and overlay
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');

            // Move navButton to the right when sidebar is open, back to the left when closed
            if (sidebar.classList.contains('-translate-x-full')) {
                navButton.style.left = '2rem'; // Left when sidebar is closed
                navButton.style.right = 'auto';
            } else {
                navButton.style.left = 'auto';
                navButton.style.right = '1rem'; // Right when sidebar is open
            }
        }

        document.getElementById('drug_id').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            var drugPrice = selectedOption.getAttribute('data-price');
            document.getElementById('drug_price').value = drugPrice;
        });
    </script>
</body>
</html>
