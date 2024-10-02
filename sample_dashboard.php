<?php
// Include database connection
require "./public/include/connect.php";

// Initialize variables
$total_samples = 0;
$sample_types_count = [];
$recent_samples = [];

// Fetch total number of samples
$result = mysqli_query($connect, "SELECT COUNT(*) AS total FROM samples");
if ($row = mysqli_fetch_assoc($result)) {
    $total_samples = $row['total'];
}

// Fetch sample types count
$result = mysqli_query($connect, "SELECT sample_type, COUNT(*) AS count FROM samples GROUP BY sample_type");
while ($row = mysqli_fetch_assoc($result)) {
    $sample_types_count[$row['sample_type']] = $row['count'];
}

// Fetch recent samples
$result = mysqli_query($connect, "SELECT sample_name, sample_type, description, collected_date FROM samples ORDER BY collected_date DESC LIMIT 5");
while ($row = mysqli_fetch_assoc($result)) {
    $recent_samples[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sample Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
  <!-- Mobile Navigation Button -->
  <div id="navButton" class="fixed top-0 left-0 z-50 p-4 lg:hidden">
    <button onclick="toggleSidebar()" class="p-2 text-white bg-blue-600 rounded-md shadow-md focus:outline-none">
      <i class="text-2xl fas fa-bars"></i> <!-- Open Button -->
    </button>
  </div>

  <div class="flex">
    <?php require "./public/include/sidebar_lab.php"; ?>

    <!-- Overlay for mobile when sidebar is open -->
    <div id="overlay" class="fixed inset-0 z-30 hidden bg-black opacity-50 md:hidden" onclick="toggleSidebar()"></div>

    <!-- Main Content -->
    <main class="p-8 lg:ml-64">
      <div class="container mx-auto">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
          <!-- Total Samples Card -->
          <div class="p-6 bg-white rounded-lg shadow-md">
            <h2 class="mb-4 text-xl font-bold">Total Samples</h2>
            <p class="text-3xl font-semibold"><?php echo $total_samples; ?></p>
          </div>

          <!-- Sample Types Count Card -->
          <div class="p-6 bg-white rounded-lg shadow-md">
            <h2 class="mb-4 text-xl font-bold">Sample Types</h2>
            <ul>
              <?php foreach ($sample_types_count as $type => $count): ?>
                <li class="mb-2">
                  <span class="font-semibold"><?php echo htmlspecialchars($type); ?>:</span> <?php echo htmlspecialchars($count); ?>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>

          <!-- Recent Samples Card -->
          <div class="p-6 bg-white rounded-lg shadow-md">
            <h2 class="mb-4 text-xl font-bold">Recent Samples</h2>
            <ul>
              <?php foreach ($recent_samples as $sample): ?>
                <li class="mb-4">
                  <h3 class="font-semibold"><?php echo htmlspecialchars($sample['sample_name']); ?></h3>
                  <p><strong>Type:</strong> <?php echo htmlspecialchars($sample['sample_type']); ?></p>
                  <p><strong>Description:</strong> <?php echo htmlspecialchars($sample['description']); ?></p>
                  <p><strong>Collected Date:</strong> <?php echo htmlspecialchars($sample['collected_date']); ?></p>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>
      </div>
    </main>
  </div>

  <script>
    function toggleSidebar() {
      var sidebar = document.getElementById('sidebar');
      var overlay = document.getElementById('overlay');
      var navButton = document.getElementById('navButton');

      // Toggle sidebar visibility and overlay
      sidebar.classList.toggle('lg:translate-x-0');
      overlay.classList.toggle('hidden');

      // Move navButton to the right when sidebar is open, back to the left when closed
      if (overlay.classList.contains('hidden')) {
        navButton.style.left = '2rem'; // Left when sidebar is closed
      } else {
        navButton.style.left = 'auto';
        navButton.style.right = '1rem'; // Right when sidebar is open
      }
    }
  </script>
</body>
</html>
