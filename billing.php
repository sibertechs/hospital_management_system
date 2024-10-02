<?php
session_start();
require "./public/include/connect.php";

$patient_id = $_SESSION['patient_id'] ?? null;
$bills = [];

if ($patient_id) {
    // Fetch all bills for this patient
    $query = "SELECT * FROM bills WHERE patient_id = '$patient_id'";
    $result = mysqli_query($connect, $query);
    $bills = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // Handle form submission for adding new bills
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $consultation_fees = $_POST['consultation_fees'];
        $drugs_fees = $_POST['drugs_fees'];
        $lab_fees = $_POST['lab_fees'];
        $ward_fees = $_POST['ward_fees'];
        $total_fees = $consultation_fees + $drugs_fees + $lab_fees + $ward_fees; 
        $date = $_POST['date'];

        $query = "INSERT INTO bills (patient_id, consultation_fees, drugs_fees, lab_fees, ward_fees, total_fees, date) 
                  VALUES ('$patient_id', '$consultation_fees', '$drugs_fees', '$lab_fees', '$ward_fees', '$total_fees', '$date')";
        mysqli_query($connect, $query);
        header("Location: billing.php");
    }
} else {
    echo "Patient ID is not set in session.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
</head>
<body class="bg-gray-100">
    <div class="flex">
       <!-- Sidebar -->
    <?php
            require "./public/include/sidebar_admin.php"
        ?>

        <!-- Main Content -->
        <div class="w-3/4 p-6 bg-white rounded-lg shadow-lg mt-10">
            <h1 class="text-3xl font-bold mb-4">Billing Information</h1>

            <!-- Billing Form -->
            <div class="mb-8">
                <h2 class="text-2xl font-semibold mb-4">Add New Bill</h2>
                <form action="billing.php" method="POST" class="space-y-4">
                    <div>
                        <label for="consultation_fees" class="block font-semibold">Consultation Fees</label>
                        <input type="number" name="consultation_fees" id="consultation_fees" step="0.01" required  class="border-b border-gray-300 p-2 w-full outline-none">
                    </div>
                    <div>
                        <label for="drugs_fees" class="block font-semibold">Drugs Fees</label>
                        <input type="number" name="drugs_fees" id="drugs_fees" step="0.01" required  class="border-b border-gray-300 p-2 w-full outline-none"">
                    </div>
                    <div>
                        <label for="lab_fees" class="block font-semibold">Lab Fees</label>
                        <input type="number" name="lab_fees" id="lab_fees" step="0.01" required  class="border-b border-gray-300 p-2 w-full outline-none"">
                    </div>
                    <div>
                        <label for="ward_fees" class="block font-semibold">Ward Fees</label>
                        <input type="number" name="ward_fees" id="ward_fees" step="0.01" required  class="border-b border-gray-300 p-2 w-full outline-none"">
                    </div>
                    <div>
                        <label for="ward_fees" class="block font-semibold">Date</label>
                        <input type="date" name="date" id="datetime" step="0.01" required  class="border-b border-gray-300 p-2 w-full outline-none"">
                    </div>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Add Bill</button>
                </form>
            </div>

            <!-- Bills Table -->
            <div>
                <h2 class="text-2xl font-semibold mb-4">Bills</h2>
                <?php if ($bills): ?>
                    <table class="min-w-full bg-white border border-gray-300">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 border">Consultation Fees</th>
                                <th class="px-4 py-2 border">Drugs Fees</th>
                                <th class="px-4 py-2 border">Lab Fees</th>
                                <th class="px-4 py-2 border">Ward Fees</th>
                                <th class="px-4 py-2 border">Total Fees</th>
                                <th class="px-4 py-2 border">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($bills as $bill): ?>
                                <tr>
                                    <td class="px-4 py-2 border"><?php echo htmlspecialchars($bill['consultation_fees']); ?></td>
                                    <td class="px-4 py-2 border"><?php echo htmlspecialchars($bill['drugs_fees']); ?></td>
                                    <td class="px-4 py-2 border"><?php echo htmlspecialchars($bill['lab_fees']); ?></td>
                                    <td class="px-4 py-2 border"><?php echo htmlspecialchars($bill['ward_fees']); ?></td>
                                    <td class="px-4 py-2 border"><?php echo htmlspecialchars($bill['total_fees']); ?></td>
                                    <!-- <td class="px-4 py-2 border"><?php echo htmlspecialchars($bill['date']); ?></td> -->
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No bills found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
