<?php
// Include database connection
require "./public/include/connect.php";

// Ensure database connection
if (!$connect) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Initialize variables
$success_msg = '';
$error_msg = '';
$patient_name = '';  // Initialize patient_name as an empty string

// Check if patient ID has been entered and form is submitted to fetch patient name
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['fetch_patient'])) {
    $patient_id = mysqli_real_escape_string($connect, $_POST['patient_id']);

    // Verify patient ID exists in the patient_registration table
    $patient_check_query = "SELECT name FROM patient_registration WHERE id = '$patient_id'";
    $result_check = mysqli_query($connect, $patient_check_query);

    if (mysqli_num_rows($result_check) > 0) {
        $patient_row = mysqli_fetch_assoc($result_check);
        $patient_name = $patient_row['name'];
    } else {
        $error_msg = "Patient ID does not exist.";
    }
}

// Handle the form submission for registering the test result
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register_test'])) {
    // Sanitize and validate input
    $patient_id = mysqli_real_escape_string($connect, $_POST['patient_id']);
    $test_type = mysqli_real_escape_string($connect, $_POST['test_type']);
    $test_date = mysqli_real_escape_string($connect, $_POST['test_date']);
    $result = mysqli_real_escape_string($connect, $_POST['result']);
    $patient_name = mysqli_real_escape_string($connect, $_POST['patient_name']);  // Now submit the patient_name

    // Proceed with the test result insertion
    $query = "INSERT INTO test_results (patient_id, patient_name, test_type, test_date, result) 
              VALUES ('$patient_id', '$patient_name', '$test_type', '$test_date', '$result')";

    if (mysqli_query($connect, $query)) {
        $success_msg = "Test result registered successfully.";
    } else {
        $error_msg = "Error inserting test result: " . mysqli_error($connect);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Results</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex">
        <?php require "./public/include/sidebar_lab.php"; ?>

        <main class="flex-1 p-8 lg:ml-64">
            <div class="container mx-auto">
                <div class="max-w-3xl p-6 mx-auto bg-white rounded-lg shadow-md">
                    <h1 class="mb-4 text-2xl font-bold">Register Test Result</h1>

                    <!-- First form to fetch patient name -->
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="space-y-4">
                        <div class="flex flex-col mb-4">
                            <label for="patient_id" class="mb-2 text-sm font-semibold text-gray-700">Patient ID:</label>
                            <input type="text" id="patient_id" name="patient_id" class="w-full p-3 border border-gray-300 rounded-lg" placeholder="Enter patient ID" required>
                        </div>
                        <button type="submit" name="fetch_patient" class="px-4 py-2 font-semibold text-white bg-blue-600 rounded-lg shadow-md hover:bg-blue-700 focus:outline-none">Fetch Patient Name</button>
                    </form>

                    <!-- Second form to register test result once the patient name is fetched -->
                    <?php if (!empty($patient_name)): ?>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="mt-4 space-y-4">
                        <input type="hidden" name="patient_id" value="<?php echo htmlspecialchars($_POST['patient_id']); ?>">

                        <div class="flex flex-col mb-4">
                            <label for="patient_name" class="mb-2 text-sm font-semibold text-gray-700">Patient Name:</label>
                            <input type="text" id="patient_name" name="patient_name" class="w-full p-3 border border-gray-300 rounded-lg" value="<?php echo htmlspecialchars($patient_name); ?>" readonly>
                        </div>

                        <div class="flex flex-col mb-4">
                            <label for="test_type" class="mb-2 text-sm font-semibold text-gray-700">Test Type:</label>
                            <input type="text" id="test_type" name="test_type" class="w-full p-3 border border-gray-300 rounded-lg" placeholder="Enter test type" required>
                        </div>
                        <div class="flex flex-col mb-4">
                            <label for="test_date" class="mb-2 text-sm font-semibold text-gray-700">Test Date:</label>
                            <input type="date" id="test_date" name="test_date" class="w-full p-3 border border-gray-300 rounded-lg" required>
                        </div>
                        <div class="flex flex-col mb-4">
                            <label for="result" class="mb-2 text-sm font-semibold text-gray-700">Result:</label>
                            <textarea id="result" name="result" rows="4" class="w-full p-3 border border-gray-300 rounded-lg" placeholder="Enter result"></textarea>
                        </div>
                        <button type="submit" name="register_test" class="px-4 py-2 font-semibold text-white bg-blue-600 rounded-lg shadow-md hover:bg-blue-700 focus:outline-none">Register Test Result</button>
                    </form>
                    <?php endif; ?>

                    <!-- Display success or error message -->
                    <?php if ($success_msg): ?>
                        <p class="mt-4 text-green-600"><?php echo htmlspecialchars($success_msg); ?></p>
                    <?php elseif ($error_msg): ?>
                        <p class="mt-4 text-red-600"><?php echo htmlspecialchars($error_msg); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
