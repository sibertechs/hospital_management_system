<?php
// Include database connection
require "./public/include/connect.php";

// Ensure database connection
if (!$connect) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Initialize search term
$search_term = '';
if (isset($_GET['search'])) {
    $search_term = mysqli_real_escape_string($connect, $_GET['search']);
}

// Fetch patient history data with search functionality
$query = "
    SELECT id, name AS full_name, dob, COUNT(*) AS visit_count
    FROM patient_registration
    WHERE name LIKE '%$search_term%'
    GROUP BY id, dob;
";

$result = mysqli_query($connect, $query);

if (!$result) {
    die("Error fetching patient history: " . mysqli_error($connect));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient History</title>
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
    <div class="flex">
        <!-- Sidebar (Initially hidden on mobile) -->
        <?php require "./public/include/sidebar_doctor.php"; ?>
        <!-- Overlay for mobile when sidebar is open -->
        <div id="overlay" class="fixed inset-0 z-30 hidden bg-black opacity-50 md:hidden" onclick="toggleSidebar()"></div>

        <main class="flex-1 p-8 ml-4">
            <div class="container mx-auto">
                <div class="max-w-6xl p-6 mx-auto bg-white rounded-lg shadow-md">
                    <h1 class="mb-4 text-2xl font-bold">Patient History</h1>
                    
                    <!-- Search Form -->
                    <form method="GET" class="mb-6">
                        <input type="text" name="search" value="<?php echo htmlspecialchars($search_term); ?>" placeholder="Search by name..." class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <button type="submit" class="px-4 py-2 mt-2 text-white bg-blue-600 rounded-lg">Search</button>
                    </form>

                    <table class="w-full text-left bg-white border border-gray-300 rounded">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="px-4 py-2 border-b">Patient ID</th>
                                <th class="px-4 py-2 border-b">Full Name</th>
                                <th class="px-4 py-2 border-b">Date of Birth</th>
                                <th class="px-4 py-2 border-b">Visit Count</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['id']); ?></td>
                                <td class="px-4 py-2 border-b">
                                    <a href="patient_record.php?id=<?php echo htmlspecialchars($row['id']); ?>" class="text-blue-600 hover:underline">
                                        <?php echo htmlspecialchars($row['full_name']); ?>
                                    </a>
                                </td>
                                <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['dob']); ?></td>
                                <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['visit_count']); ?></td>
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

        // Change button icon
        var buttonIcon = navButton.querySelector('i');
        buttonIcon.classList.toggle('fa-bars');
        buttonIcon.classList.toggle('fa-times');
    }
    </script>
</body>
</html>

