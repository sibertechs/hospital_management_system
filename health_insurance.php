<?php
require "./public/include/connect.php";
session_start();

// Check if the patient is logged in
$patient_id = $_SESSION['patient_id'] ?? null;

if (!$patient_id) {
    echo "<script>alert('You must be logged in to manage health insurance.'); window.location.href='patient_login.php';</script>";
    exit;
}

// Handle form submission for adding health insurance
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $provider_name = mysqli_real_escape_string($connect, $_POST['provider_name']);
    $policy_number = mysqli_real_escape_string($connect, $_POST['policy_number']);
    $coverage_amount = mysqli_real_escape_string($connect, $_POST['coverage_amount']);

    // Insert health insurance into the database
    $query = "INSERT INTO health_insurance (patient_id, provider_name, policy_number, coverage_amount) 
              VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($connect, $query);
    mysqli_stmt_bind_param($stmt, "issd", $patient_id, $provider_name, $policy_number, $coverage_amount);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Health insurance added successfully!'); window.location.href='health_insurance.php';</script>";
    } else {
        echo "<script>alert('Error adding health insurance: " . mysqli_stmt_error($stmt) . "');</script>";
    }
}

// Fetch all health insurance for the patient
$insurance_query = "SELECT * FROM health_insurance WHERE patient_id = ?";
$stmt = mysqli_prepare($connect, $insurance_query);
mysqli_stmt_bind_param($stmt, "i", $patient_id);
mysqli_stmt_execute($stmt);
$insurance_result = mysqli_stmt_get_result($stmt);


$common_insurance_providers = [
    "Ghana National Health Insurance Scheme (NHIS)",
    "Enterprise Life Insurance",
    "Ghana Medical Association (GMA) Health Insurance",
    "Metropolitan Health Insurance",
    "Eagle Health Insurance",
    "BIMA",
    "HFC Bank Health Insurance",
    "StarLife Assurance"
];
?>

<!DOCTYPE html>
<html lang="en">
<?php require "./public/include/head.php"; ?>
<body class="bg-gray-100">

    <!-- Sidebar -->
    <div class="flex">
        <?php require "./public/include/sidebar_patient.php"; ?>
        
        <!-- Main Content -->
        <div class="w-4/5 p-8">
            <div class="container max-w-2xl p-6 mx-auto bg-white rounded-lg shadow-lg">
                <h1 class="mb-6 text-3xl font-bold text-center text-gray-800">Health Insurance</h1>

                <form action="health_insurance.php" method="POST" class="space-y-4">
                <div>
                        <label for="provider_name" class="block text-gray-700">Insurance Provider</label>
                        <select id="provider_name" name="provider_name" required class="block w-full p-2 border border-gray-300 rounded-md shadow-sm outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Select Insurance Provider</option>
                            <?php foreach ($common_insurance_providers as $provider): ?>
                                <option value="<?= htmlspecialchars($provider); ?>"><?= htmlspecialchars($provider); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div>
                        <label for="policy_number" class="block text-gray-700">Policy Number</label>
                        <input type="text" id="policy_number" name="policy_number" required class="block w-full p-2 border border-gray-300 rounded-md shadow-sm outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter Policy Number">
                    </div>

                    <div>
                        <label for="coverage_amount" class="block text-gray-700">Coverage Amount</label>
                        <input type="number" id="coverage_amount" name="coverage_amount" required class="block w-full p-2 border border-gray-300 rounded-md shadow-sm outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter Coverage Amount">
                    </div>

                    <div>
                        <input type="submit" value="Add Health Insurance" class="w-full p-3 mt-6 font-bold text-white bg-indigo-600 rounded-md cursor-pointer hover:bg-indigo-700">
                    </div>
                </form>

                <h2 class="mt-8 mb-4 text-2xl font-bold">Insured Plans</h2>
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Provider</th>
                            <th>Policy Number</th>
                            <th>Coverage Amount</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($insurance = mysqli_fetch_assoc($insurance_result)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($insurance['id']); ?></td>
                                <td><?php echo htmlspecialchars($insurance['provider_name']); ?></td>
                                <td><?php echo htmlspecialchars($insurance['policy_number']); ?></td>
                                <td><?php echo htmlspecialchars($insurance['coverage_amount']); ?></td>
                                <td><?php echo htmlspecialchars($insurance['created_at']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>