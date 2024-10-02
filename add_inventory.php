<?php
// Database connection
require "./public/include/connect.php";

// Fetch drugs from the database
$drugs = [];
$query = "SELECT id, drug_name FROM drugs";
$result = $connect->query($query);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $drugs[] = $row;
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $drugId = $_POST['drugId']; // Get the selected drug ID
    $quantity = $_POST['quantity'];

    // Fetch the selected drug details (name, type, and price) from the drugs table
    $drugQuery = $connect->prepare("SELECT drug_name, drug_type, price FROM drugs WHERE id = ?");
    $drugQuery->bind_param("i", $drugId);
    $drugQuery->execute();
    $drugResult = $drugQuery->get_result();
    $drug = $drugResult->fetch_assoc();

    $drugName = $drug['drug_name'];
    $drugType = $drug['drug_type'];
    $price = $drug['price'];

    // Prepare and bind to insert into inventory
    $stmt = $connect->prepare("INSERT INTO inventory (drug_name, drug_type, quantity, price) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssii", $drugName, $drugType, $quantity, $price);

    // Execute
    if ($stmt->execute()) {
        $message = "Inventory item added successfully.";
    } else {
        $message = "Error: " . $stmt->error;
    }

    $stmt->close();
    $connect->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Add Inventory</title>
</head>
<body class="bg-gray-100">
    <div class="flex">
        <?php require "./public/include/sidebar_pharmacist.php"; ?>
        <main class="flex-1 p-4 ml-4">
            <div class="max-w-2xl p-6 mx-auto bg-white rounded-lg shadow-lg">
                <h1 class="mb-4 text-2xl font-bold">Add Inventory</h1>
                <?php if (isset($message)): ?>
                    <div class="p-3 mb-4 text-green-700 bg-green-100 rounded-lg"><?= htmlspecialchars($message) ?></div>
                <?php endif; ?>
                <form method="post" action="add_inventory.php">
                    <div class="mb-4">
                        <label for="drugId" class="block mb-2 text-sm font-bold text-gray-700">Select Drug</label>
                        <select id="drugId" name="drugId" required class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                            <option value="">Select a Drug</option>
                            <?php foreach ($drugs as $drug): ?>
                                <option value="<?= htmlspecialchars($drug['id']) ?>"><?= htmlspecialchars($drug['drug_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="quantity" class="block mb-2 text-sm font-bold text-gray-700">Quantity</label>
                        <input type="number" id="quantity" name="quantity" required class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                    </div>

                    <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded-lg shadow-md hover:bg-blue-700 focus:outline-none">Add Item</button>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
