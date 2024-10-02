<?php
// Include database connection
require "./public/include/connect.php";

// Ensure database connection
if (!$connect) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Fetch inventory data
$query = "SELECT * FROM inventory";
$result = mysqli_query($connect, $query);

// Check if query was successful
if (!$result) {
    die("Error fetching data: " . mysqli_error($connect));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Inventory</title>
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
     <!-- Overlay for mobile when sidebar is open -->
     <div id="overlay" class="fixed inset-0 z-30 hidden bg-black opacity-50 md:hidden" onclick="toggleSidebar()"></div>
     <?php
         require "./public/include/sidebar_pharmacist.php";
     ?>
  <main class="flex-1 p-8 ml-4">
        <div class="container mx-auto">
            <div class="max-w-6xl p-6 mx-auto bg-white rounded-lg shadow-md">
                <h1 class="mb-4 text-2xl font-bold">Inventory List</h1>

                <table class="min-w-full bg-white border border-gray-300">
                    <thead>
                        <tr class="bg-gray-100 border-b">
                            <th class="p-4 text-left">ID</th>
                            <th class="p-4 text-left">Drug Name</th>
                            <th class="p-4 text-left">Quantity</th>
                            <th class="p-4 text-left">Price</th>
                            <th class="p-4 text-left">Added At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td class="p-4 border-b"><?php echo htmlspecialchars($row['id']); ?></td>
                            <td class="p-4 border-b"><?php echo htmlspecialchars($row['drug_name']); ?></td>
                            <td class="p-4 border-b"><?php echo htmlspecialchars($row['quantity']); ?></td>
                            <td class="p-4 border-b"><?php echo htmlspecialchars($row['price']); ?></td>
                            <td class="p-4 border-b"><?php echo htmlspecialchars($row['created_at']); ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
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

        // Move navButton to the right when sidebar is open, back to the left when closed
        if (sidebar.classList.contains('-translate-x-full')) {
            navButton.style.left = '2rem'; // Left when sidebar is closed
            navButton.style.right = 'auto';
        } else {
            navButton.style.left = 'auto';
            navButton.style.right = '1rem'; // Right when sidebar is open
        }
    }
    </script>
</body>
</html>
