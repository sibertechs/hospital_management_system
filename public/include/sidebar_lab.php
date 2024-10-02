<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lab Sidebar</title>
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
  <aside id="sidebar" class="fixed top-0 left-0 z-40 w-64 min-h-screen transition-transform duration-300 transform -translate-x-full bg-blue-800 shadow-lg md:relative md:translate-x-0 md:block">
    <div class="flex flex-col h-full">
      <div class="p-5 text-sm font-bold text-center text-white border-b border-blue-700 md:text-xl">
        <i class="mr-2 fas fa-flask"></i> Lab Dashboard
      </div>
      <nav class="flex-1 mt-4">
        <!-- Manage Samples Dropdown -->
        <div class="relative">
          <button onclick="toggleDropdown('samplesDropdown')" class="flex items-center w-full px-4 py-3 text-white hover:bg-blue-700 focus:outline-none">
            <i class="mr-3 fas fa-vial"></i> Manage Samples
          </button>
          <div id="samplesDropdown" class="z-10 hidden w-full mt-2 bg-blue-800 rounded-md shadow-lg">
            <a href="sample_dashboard.php" class="block px-4 py-3 text-white hover:bg-blue-700">Sample Dashboard</a>
            <a href="sample_registration.php" class="block px-4 py-3 text-white hover:bg-blue-700">Register New Sample</a>
          </div>
        </div>

        <!-- Manage Tests Dropdown -->
        <div class="relative">
          <button onclick="toggleDropdown('testsDropdown')" class="flex items-center w-full px-4 py-3 text-white hover:bg-blue-700 focus:outline-none">
            <i class="mr-3 fas fa-flask"></i> Manage Tests
          </button>
          <div id="testsDropdown" class="z-10 hidden w-full mt-2 bg-blue-800 rounded-md shadow-lg">
            <a href="test_dashboard.php" class="block px-4 py-3 text-white hover:bg-blue-700">Test Dashboard</a>
            <a href="test_results.php" class="block px-4 py-3 text-white hover:bg-blue-700">Test Results</a>
          </div>
        </div>

        <!-- Communicate with Departments Section -->
        <div class="relative">
          <button onclick="toggleDropdown('departmentsDropdown')" class="flex items-center w-full px-4 py-3 text-white hover:bg-blue-700 focus:outline-none">
            <i class="mr-3 fas fa-building"></i> Comm. with Dep.
          </button>
          <div id="departmentsDropdown" class="z-10 hidden w-full mt-2 bg-blue-800 rounded-md shadow-lg">
            <a href="lab_units_communication.php" class="block px-4 py-3 text-white hover:bg-blue-700">
              <i class="mr-2 fas fa-building"></i> Units
            </a>
            </a>
          </div>
        </div>

        <!-- Logout -->
        <a href="lab_login.php" class="block px-4 py-3 text-white hover:bg-blue-700">Logout</a>
      </nav>
    </div>
  </aside>

  <!-- Overlay for mobile when sidebar is open -->
  <div id="overlay" class="fixed inset-0 z-30 hidden bg-black opacity-50 md:hidden" onclick="toggleSidebar()"></div>

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
