<?php
session_start();

// Ensure the pharmacist is logged in
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'finance') {
    header("Location: finance_login.php");
    exit();
}

require "./public/include/connect.php";

// Fetch all transactions
$query = "SELECT t.*, d.drug_name AS drug_name, p.name AS patient_name FROM transactions t
          JOIN drugs d ON t.drug_id = d.id
          JOIN patient_registration p ON t.patient_id = p.id
          ORDER BY t.transaction_date DESC";
$result = mysqli_query($connect, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Transactions</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
</head>
<body class="flex bg-gray-100">

    <!-- Sidebar -->
    <?php
        require "./public/include/sidebar_finance.php";
    ?>

    <!-- Main Content -->
    <div class="flex-1 p-6">
        <h1 class="text-3xl font-bold text-gray-800">Transactions</h1>

        <table class="min-w-full mt-6 bg-white border border-gray-300">
            <thead>
                <tr>
                    <th class="px-4 py-2 border-b">Transaction Date</th>
                    <th class="px-4 py-2 border-b">Drug</th>
                    <th class="px-4 py-2 border-b">Patient</th>
                    <th class="px-4 py-2 border-b">Amount</th>
                    <th class="px-4 py-2 border-b">Type</th>
                    <th class="px-4 py-2 border-b">Description</th>
                    <th class="px-4 py-2 border-b">Drug Price</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td class="px-4 py-2 border-b">
                                <?php echo htmlspecialchars(date("Y-m-d H:i:s", strtotime($row['transaction_date']))); ?>
                            </td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['drug_name']); ?></td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['patient_name']); ?></td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['amount']); ?></td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['type']); ?></td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['description']); ?></td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['drug_price']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="px-4 py-2 text-center border-b">No transactions found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
