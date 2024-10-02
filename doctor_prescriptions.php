<?php
// Assuming you have a database connection
require "./public/include/connect.php";

// Fetch existing prescriptions
$query = "SELECT * FROM prescriptions";
$prescriptions = $connect->query($query);

// Fetch drugs for the dropdown
$drugsQuery = "SELECT id, drug_name FROM drugs"; // Assuming the 'drugs' table contains 'id' and 'drug_name' columns
$drugsResult = mysqli_query($connect, $drugsQuery);

// Handle new prescription form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patient_id = $_POST['patient_id'];
    $drug_name = $_POST['drug_name'];
    $dosage = $_POST['dosage'];
    $duration = $_POST['duration'];
    $instructions = $_POST['instructions'];

    // Check if the prescription already exists
    $check_query = "SELECT * FROM prescriptions WHERE patient_id = ? AND drug_name = ?";
    $stmt = $connect->prepare($check_query);
    $stmt->bind_param("ss", $patient_id, $drug_name); // Bind patient_id and drug_name to the query
    $stmt->execute();
    $check_result = $stmt->get_result();

    if ($check_result->num_rows > 0) {
        // Prescription already exists
        echo "<script>alert('Prescription for this patient and drug already exists!');</script>";
    } else {
        // Insert new prescription using prepared statement
        $insert_query = "INSERT INTO prescriptions (patient_id, drug_name, dosage, duration, instructions) 
                         VALUES (?, ?, ?, ?, ?)";
        $stmt = $connect->prepare($insert_query);
        $stmt->bind_param("sssss", $patient_id, $drug_name, $dosage, $duration, $instructions);

        if ($stmt->execute()) {
            echo "<script>alert('Prescription added successfully!')</script>";
        } else {
            echo "Error: " . $stmt->error;
        }
    }
    $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Prescriptions</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <?php
            require "./public/include/sidebar_doctor.php";
        ?>

        <!-- Main Content -->
        <div class="flex-1 p-6">
            <h1 class="mb-4 text-3xl font-bold text-center">Manage Prescriptions</h1>

            <!-- Add New Prescription Form -->
            <div class="max-w-xl p-4 mx-auto mb-6 bg-white rounded shadow-md">
    <h2 class="mb-4 text-xl font-bold">Add New Prescription</h2>
    <form method="POST" action="">
        <div class="mb-4">
            <label class="block text-gray-700">Patient ID</label>
            <input type="text" name="patient_id" class="w-full p-2 border-b border-gray-300 rounded outline-none" required>
        </div>
        
        <div class="flex flex-col">
                    <label for="drug_id" class="text-sm font-medium text-gray-700">Drug</label>
                    <select id="drug_id" name="drug_id" class="w-full p-2 border-b border-gray-300 rounded outline-none" required>
                        <option value="">Select Drug</option>
                        <?php while ($drug = mysqli_fetch_assoc($drugsResult)): ?>
                        <option value="<?php echo htmlspecialchars($drug['id']); ?>" data-name="<?php echo htmlspecialchars($drug['drug_name']); ?>">
                            <?php echo htmlspecialchars($drug['drug_name']); ?>
                        </option>
                        <?php endwhile; ?>
                    </select>
                    <!-- Hidden input to store drug_name -->
                    <input type="hidden" id="drug_name" name="drug_name">
                </div>

        
        <div class="mb-4">
            <label class="block text-gray-700">Dosage</label>
            <input type="text" name="dosage" class="w-full p-2 border-b border-gray-300 rounded outline-none" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Duration (e.g., 7 days)</label>
            <input type="text" name="duration" class="w-full p-2 border-b border-gray-300 rounded outline-none" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Instructions</label>
            <textarea name="instructions" class="w-full p-2 border-b border-gray-300 rounded outline-none" required></textarea>
        </div>
        <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded">Add Prescription</button>
    </form>
</div>



            <!-- View Existing Prescriptions -->
            <div class="p-4 bg-white rounded shadow-md">
                <h2 class="mb-4 text-xl font-bold">Existing Prescriptions</h2>
                <table class="w-full text-left table-auto">
                    <thead>
                        <tr class="text-white bg-blue-600">
                            <th class="px-4 py-2">Patient ID</th>
                            <th class="px-4 py-2">Drug Name</th>
                            <th class="px-4 py-2">Dosage</th>
                            <th class="px-4 py-2">Duration</th>
                            <th class="px-4 py-2">Instructions</th>
                            <th class="px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $prescriptions->fetch_assoc()) : ?>
                            <tr class="border-t border-gray-300">
                                <td class="px-4 py-2"><?php echo $row['patient_id']; ?></td>
                                <td class="px-4 py-2"><?php echo $row['drug_name']; ?></td>
                                <td class="px-4 py-2"><?php echo $row['dosage']; ?></td>
                                <td class="px-4 py-2"><?php echo $row['duration']; ?></td>
                                <td class="px-4 py-2"><?php echo $row['instructions']; ?></td>
                                <td class="px-4 py-2">
                                    <a href="edit_prescription.php?id=<?php echo $row['id']; ?>" class="text-blue-600">Edit</a>
                                    |
                                    <a href="delete_prescription.php?id=<?php echo $row['id']; ?>" class="text-red-600" onclick="return confirm('Are you sure you want to delete this prescription?')">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
         document.getElementById('drug_id').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];
        var drugName = selectedOption.getAttribute('data-name');
        document.getElementById('drug_name').value = drugName;
    });
    </script>
</body>
</html>
