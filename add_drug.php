<?php
// add_drug.php

// Include database connection
require './public/include/connect.php';

// Initialize variables
$price = $expiry_date = $dosage = '';
$name = '';
$errors = [];

// Fetch drug options
$drug_options = [];
$sql = "SELECT id, name FROM drugs";
$result = $connect->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $drug_options[] = $row;
    }
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form input
    $name = $_POST['name'];
    $price = $_POST['price'];
    $expiry_date = $_POST['expiry_date'];
    $dosage = $_POST['dosage'];

    // Validate input
    if (empty($name)) {
        $errors[] = 'Drug name is required.';
    }
    if (empty($price) || !is_numeric($price)) {
        $errors[] = 'Valid price is required.';
    }
    if (empty($expiry_date)) {
        $errors[] = 'Expiry date is required.';
    }
    if (empty($dosage)) {
        $errors[] = 'Dosage is required.';
    }

    // Insert data if no errors
    if (empty($errors)) {
        // Get current timestamp for created_at
        $created_at = date('Y-m-d H:i:s');

        // Prepare the SQL query to insert data
        $sql = "INSERT INTO drugs (name, price, expiry_date, dosage, created_at) VALUES (?, ?, ?, ?, ?)";
        $stmt = $connect->prepare($sql);
        $stmt->bind_param("sssss", $name, $price, $expiry_date, $dosage, $created_at);

        // Execute the query
        if ($stmt->execute()) {
            echo "<script>alert('Drug added successfully.');</script>";
            $name = $price = $expiry_date = $dosage = ''; // Clear the form fields
        } else {
            $errors[] = "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }

    // Close the connection
    $connect->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Drug</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
</head>
<body class="bg-gray-100">
    <div class="flex">
        <!-- Sidebar -->
    <?php
        require "./public/include/sidebar_admin.php"
    ?>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h1 class="text-xl font-bold mb-4">Add Drug</h1>

                <!-- Display success or error messages -->
                <?php if (!empty($success_message)): ?>
                    <div class="mb-4 p-4 bg-green-100 text-green-700 border border-green-400 rounded">
                        <?php echo htmlspecialchars($success_message); ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($errors)): ?>
                    <div class="mb-4 p-4 bg-red-100 text-red-700 border border-red-400 rounded">
                        <?php foreach ($errors as $error): ?>
                            <p><?php echo htmlspecialchars($error); ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- Form for adding a new drug -->
                <form action="" method="post">
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Drug</label>
                            <?php require "./public/include/all_drugs.php"; ?>
                        </div>
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                            <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($price); ?>" step="0.01" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                        <div>
                            <label for="expiry_date" class="block text-sm font-medium text-gray-700">Expiry Date</label>
                            <input type="date" id="expiry_date" name="expiry_date" value="<?php echo htmlspecialchars($expiry_date); ?>" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                        <div>
                            <label for="dosage" class="block text-sm font-medium text-gray-700">Dosage (According to Age)</label>
                            <input type="text" id="dosage" name="dosage" value="<?php echo htmlspecialchars($dosage); ?>" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <p class="text-gray-500 text-sm mt-1">e.g., "Adults: 2 pills daily, Children: 1 pill daily"</p>
                        </div>
                    </div>
                    <button type="submit" class="mt-6 bg-blue-500 text-white px-4 py-2 rounded-md shadow-sm hover:bg-blue-600">Add Drug</button>
                </form>
            </div>
        </main>
    </div>

    <script>
        function toggleDropdown(id) {
            document.getElementById(id).classList.toggle('hidden');
        }
    </script>
</body>
</html>
