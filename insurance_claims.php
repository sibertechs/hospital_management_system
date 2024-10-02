<?php
require "./public/include/connect.php";
session_start();

// Check if the patient is logged in
$patient_id = $_SESSION['patient_id'] ?? null;

if (!$patient_id) {
    echo "<script>alert('You must be logged in to manage claims.'); window.location.href='patient_login.php';</script>";
    exit;
}

// Fetch patient details
$patient_query = "SELECT name FROM patient_registration WHERE id = ?";
$stmt = mysqli_prepare($connect, $patient_query);
mysqli_stmt_bind_param($stmt, "i", $patient_id);
mysqli_stmt_execute($stmt);
$patient_result = mysqli_stmt_get_result($stmt);
$patient = mysqli_fetch_assoc($patient_result);

// Handle form submission for adding new claims
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $insurance_provider = mysqli_real_escape_string($connect, $_POST['insurance_provider']); // Assuming you're selecting the provider from a dropdown
    $insurance_card_id = mysqli_real_escape_string($connect, $_POST['insurance_card_id']); // This is the entered card ID

    // Insert claim into the database
    $insert_claim_query = "INSERT INTO insurance_claims (patient_id, insurance_provider, insurance_card_id, created_at) VALUES (?, ?, ?, NOW())";
    $stmt = mysqli_prepare($connect, $insert_claim_query);
    mysqli_stmt_bind_param($stmt, "iss", $patient_id, $insurance_provider, $insurance_card_id); // Note the change to "iss" to handle strings

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Claim submitted successfully!'); window.location.href='insurance_claims.php';</script>";
    } else {
        echo "<script>alert('Error submitting claim: " . mysqli_stmt_error($stmt) . "');</script>";
    }
}

// Fetch all claims for the patient
$claims_query = "SELECT * FROM insurance_claims WHERE patient_id = ? ORDER BY created_at DESC";
$stmt = mysqli_prepare($connect, $claims_query);
mysqli_stmt_bind_param($stmt, "i", $patient_id);
mysqli_stmt_execute($stmt);
$claims_result = mysqli_stmt_get_result($stmt);
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
                <h1 class="mb-6 text-3xl font-bold text-center text-gray-800">Insurance Claims</h1>

                <!-- Patient Details -->
                <div class="bg-gray-50 p-4 rounded-lg shadow-md mb-4">
                    <h2 class="mb-2 text-xl font-semibold text-gray-800">Patient Details</h2>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div class="my-1">
                            <label for="patient_name" class="block text-gray-700">Name</label>
                            <input type="text" id="patient_name" name="patient_name" value="<?php echo htmlspecialchars($patient['name']); ?>" required class="block w-full p-2 border border-gray-300 rounded-md shadow-sm outline-none focus:ring-indigo-500 focus:border-indigo-500" readonly>
                        </div>
                    </div>
                </div>

                <!-- Insurance Claim Form -->
                <form action="insurance_claims.php" method="POST" class="space-y-4">
                    <div>
                        <label for="insurance_provider" class="block text-gray-700">Insurance Provider</label>
                        <select id="insurance_provider" name="insurance_provider" required class="block w-full p-2 border border-gray-300 rounded-md shadow-sm outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="" disabled selected>Select Provider</option>
                            <!-- You can fetch the active providers from your database here -->
                            <?php while ($row = mysqli_fetch_assoc($insurance_result)): ?>
                                <option value="<?php echo htmlspecialchars($row['provider_name']); ?>">
                                    <?php echo htmlspecialchars($row['provider_name']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div>
                        <label for="insurance_card_id" class="block text-gray-700">Insurance Card ID</label>
                        <input type="text" id="insurance_card_id" name="insurance_card_id" required class="block w-full p-2 border border-gray-300 rounded-md shadow-sm outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter Insurance Card ID">
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <input type="submit" value="Submit Claim" class="w-full p-3 mt-6 font-bold text-white bg-indigo-600 rounded-md cursor-pointer hover:bg-indigo-700">
                    </div>
                </form>

                <!-- Submitted Claims Table -->
                <h2 class="mt-8 mb-4 text-2xl font-bold">Submitted Claims</h2>
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th>Claim ID</th>
                            <th>Insurance Provider</th>
                            <th>Insurance Card ID</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($claim = mysqli_fetch_assoc($claims_result)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($claim['id']); ?></td>
                                <td><?php echo htmlspecialchars($claim['insurance_provider']); ?></td>
                                <td><?php echo htmlspecialchars($claim['insurance_card_id']); ?></td>
                                <td><?php echo htmlspecialchars($claim['created_at']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>
