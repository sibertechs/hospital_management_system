<?php
require "./public/include/connect.php";
session_start();

// Check if the user is logged in and has admin role
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: admin_login.php");
    exit();
}

// Handle form submission for adding new insurance providers
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate and sanitize inputs
    $provider_name = mysqli_real_escape_string($connect, $_POST['provider_name']);
    $contact_phone = mysqli_real_escape_string($connect, $_POST['contact_phone']);
    $email = mysqli_real_escape_string($connect, $_POST['email']);
    $policy_number = mysqli_real_escape_string($connect, $_POST['policy_number']);
    $coverage_amount = floatval($_POST['coverage_amount']); // Ensure this is a float
    
    // Insert insurance provider into the database
    $query = "INSERT INTO health_insurance (provider_name, contact_phone, email, policy_number, coverage_amount) 
              VALUES (?, ?, ?, ?, ?)";
    
    if ($stmt = mysqli_prepare($connect, $query)) {
        mysqli_stmt_bind_param($stmt, "ssssd", $provider_name, $contact_phone, $email, $policy_number, $coverage_amount);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Insurance provider added successfully!');</script>";
        } else {
            echo "<script>alert('Error adding insurance provider: " . mysqli_stmt_error($stmt) . "');</script>";
        }
        
        mysqli_stmt_close($stmt);
    } else {
        echo "<script>alert('Error preparing query: " . mysqli_error($connect) . "');</script>";
    }
}

// Fetch all insurance providers
$insurance_query = "SELECT * FROM health_insurance ORDER BY provider_name ASC";
$insurance_result = mysqli_query($connect, $insurance_query);

if (!$insurance_result) {
    echo "<script>alert('Error fetching insurance providers: " . mysqli_error($connect) . "');</script>";
}

// Hardcoded list of common health insurance providers in Ghana
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
        <?php require "./public/include/sidebar_admin.php"; ?>
        
        <!-- Main Content -->
        <div class="w-4/5 p-8">
            <div class="container max-w-2xl p-6 mx-auto bg-white rounded-lg shadow-lg">
                <h1 class="mb-6 text-3xl font-bold text-center text-gray-800">Manage Insurance Providers</h1>

                <form action="manage_insurance.php" method="POST" class="space-y-4">
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
                        <label for="contact_phone" class="block text-gray-700">Contact Phone</label>
                        <input type="text" id="contact_phone" name="contact_phone" required class="block w-full p-2 border border-gray-300 rounded-md shadow-sm outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter Contact Phone Number">
                    </div>

                    <div>
                        <label for="email" class="block text-gray-700">Email Address</label>
                        <input type="email" id="email" name="email" class="block w-full p-2 border border-gray-300 rounded-md shadow-sm outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter Contact Email Address">
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
                        <input type="submit" value="Add Insurance Provider" class="w-full p-3 mt-6 font-bold text-white bg-indigo-600 rounded-md cursor-pointer hover:bg-indigo-700">
                    </div>
                </form>

                <h2 class="mt-8 mb-4 text-2xl font-bold">Insurance Providers List</h2>
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Provider Name</th>
                            <th>Contact Phone</th>
                            <th>Email</th>
                            <th>Policy Number</th>
                            <th>Coverage Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($insurance = mysqli_fetch_assoc($insurance_result)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($insurance['id'] ?? 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars($insurance['provider_name'] ?? 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars($insurance['contact_phone'] ?? 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars($insurance['email'] ?? 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars($insurance['policy_number'] ?? 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars($insurance['coverage_amount'] ?? 'N/A'); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>