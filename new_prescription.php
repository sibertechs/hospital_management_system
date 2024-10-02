<?php
// Include database connection
require "./public/include/connect.php";

// Ensure database connection
if (!$connect) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Fetch patient names for the dropdown
$patientsQuery = "SELECT id, name FROM patient_registration";
$patientsResult = mysqli_query($connect, $patientsQuery);

if (!$patientsResult) {
    die("Error fetching patients: " . mysqli_error($connect));
}

// Fetch drugs for the dropdown
$drugsQuery = "SELECT id, drug_name FROM drugs"; // Changed 'name' to 'drug_name'
$drugsResult = mysqli_query($connect, $drugsQuery);

if (!$drugsResult) {
    die("Error fetching drugs: " . mysqli_error($connect));
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patient_id = $_POST['patient_id'] ?? '';
    $drug_id = $_POST['drug_id'] ?? '';
    $drug_name = $_POST['drug_name'] ?? '';
    $dosage = $_POST['dosage'] ?? '';
    $date = $_POST['date'] ?? '';

    // Validate form inputs
    if ($patient_id && $drug_id && $drug_name && $dosage && $date) {
        // Insert prescription into the database
        $query = "INSERT INTO prescriptions (patient_id, drug_id, drug_name, dosage, created_at) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($connect, $query);
        mysqli_stmt_bind_param($stmt, "iisss", $patient_id, $drug_id, $drug_name, $dosage, $date);

        if (mysqli_stmt_execute($stmt)) {
            echo "<p class='text-green-500'>Prescription added successfully!</p>";
        } else {
            echo "<p class='text-red-500'>Error adding prescription: " . mysqli_error($connect) . "</p>";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "<p class='text-red-500'>Please fill all fields.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Prescription</title>
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

    <!-- Sidebar (Initially hidden on mobile) -->
   <div class="flex">
   <?php
        require "./public/include/sidebar_pharmacist.php";
    ?>
     <!-- Overlay for mobile when sidebar is open -->
     <div id="overlay" class="fixed inset-0 z-30 hidden bg-black opacity-50 md:hidden" onclick="toggleSidebar()"></div>

<main class="flex-1 p-8 ml-4">
    <div class="container mx-auto">
        <div class="max-w-6xl p-6 mx-auto bg-white rounded-lg shadow-md">
            <h1 class="mb-4 text-2xl font-bold">New Prescription</h1>

            <form action="new_prescription.php" method="post" class="space-y-4">
                <div class="flex flex-col">
                    <label for="patient_id" class="text-sm font-medium text-gray-700">Patient Name</label>
                    <select id="patient_id" name="patient_id" class="p-2 border border-gray-300 rounded">
                        <option value="">Select Patient</option>
                        <?php while ($patient = mysqli_fetch_assoc($patientsResult)): ?>
                        <option value="<?php echo htmlspecialchars($patient['id']); ?>">
                            <?php echo htmlspecialchars($patient['name']); ?>
                        </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="flex flex-col">
                    <label for="drug_id" class="text-sm font-medium text-gray-700">Drug</label>
                    <select id="drug_id" name="drug_id" class="p-2 border border-gray-300 rounded" required>
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

                <div class="flex flex-col">
                    <label for="dosage" class="text-sm font-medium text-gray-700">Dosage</label>
                    <input type="text" id="dosage" name="dosage" class="p-2 border border-gray-300 rounded" required>
                </div>

                <div class="flex flex-col">
                    <label for="date" class="text-sm font-medium text-gray-700">Date</label>
                    <input type="date" id="date" name="date" class="p-2 border border-gray-300 rounded" required>
                </div>

                <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded">Add Prescription</button>
            </form>
        </div>
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

        // Change button icon
        var buttonIcon = navButton.querySelector('i');
        buttonIcon.classList.toggle('fa-bars');
        buttonIcon.classList.toggle('fa-times');
    }

    document.getElementById('drug_id').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];
        var drugName = selectedOption.getAttribute('data-name');
        document.getElementById('drug_name').value = drugName;
    });
    </script>
</body>
</html>
