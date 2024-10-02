<?php
// Include database connection
require "./public/include/connect.php";

// Initialize variables and error messages
$success_msg = '';
$error_msg = '';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register_sample'])) {
    // Sanitize and validate input
    $sample_name = mysqli_real_escape_string($connect, $_POST['sample_name']);
    $sample_type = mysqli_real_escape_string($connect, $_POST['sample_type']);
    $description = mysqli_real_escape_string($connect, $_POST['description']);
    $collected_date = mysqli_real_escape_string($connect, $_POST['collected_date']);

    // Insert sample into the database
    $query = "INSERT INTO samples (sample_name, sample_type, description, collected_date, created_at) 
              VALUES ('$sample_name', '$sample_type', '$description', '$collected_date', NOW())";
    if (mysqli_query($connect, $query)) {
        $success_msg = "Sample registered successfully.";
    } else {
        $error_msg = "Error: " . mysqli_error($connect);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sample Registration</title>
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

  <!-- Sidebar -->
  <div class="flex">
    <?php require "./public/include/sidebar_lab.php"; ?>

    <!-- Overlay for mobile when sidebar is open -->
    <div id="overlay" class="fixed inset-0 z-30 hidden bg-black opacity-50 md:hidden" onclick="toggleSidebar()"></div>

    <!-- Main Content -->
    <main class="flex-1 p-8 lg:ml-64">
      <div class="container max-w-4xl mx-auto">
        <div class="p-6 bg-white rounded-lg shadow-md">
          <h1 class="mb-4 text-2xl font-bold">Register New Sample</h1>
          
          <!-- Sample Registration Form -->
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="space-y-4">
            <div class="flex flex-col mb-4">
              <label for="sample_name" class="mb-2 text-sm font-semibold text-gray-700">Sample Name:</label>
              <select id="sample_name" name="sample_name" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                <option value="">Select a sample name</option>
                <option value="Blood">Blood</option>
                <option value="Urine">Urine</option>
                <option value="Saliva">Saliva</option>
                <option value="Sputum">Sputum</option>
                <!-- Add more options as needed -->
              </select>
            </div>
            <div class="flex flex-col mb-4">
              <label for="sample_type" class="mb-2 text-sm font-semibold text-gray-700">Sample Type:</label>
              <select id="sample_type" name="sample_type" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                <option value="">Select a sample type</option>
                <option value="Routine">Routine</option>
                <option value="Special">Special</option>
                <option value="Emergency">Emergency</option>
                <!-- Add more options as needed -->
              </select>
            </div>
            <div class="flex flex-col mb-4">
              <label for="description" class="mb-2 text-sm font-semibold text-gray-700">Description:</label>
              <textarea id="description" name="description" rows="4" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter description"></textarea>
            </div>
            <div class="flex flex-col mb-4">
              <label for="collected_date" class="mb-2 text-sm font-semibold text-gray-700">Collected Date:</label>
              <input type="date" id="collected_date" name="collected_date" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <button type="submit" name="register_sample" class="px-4 py-2 font-semibold text-white bg-blue-600 rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Register Sample</button>
          </form>

          <?php if ($success_msg): ?>
            <p class="mt-4 text-green-600"><?php echo htmlspecialchars($success_msg); ?></p>
          <?php elseif ($error_msg): ?>
            <p class="mt-4 text-red-600"><?php echo htmlspecialchars($error_msg); ?></p>
          <?php endif; ?>
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
