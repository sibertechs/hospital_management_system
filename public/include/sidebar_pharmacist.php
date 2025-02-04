<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <script src="https://cdn.tailwindcss.com"></script>
  <title>Pharmacist Dashboard</title>
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
      <div class="p-5 text-sm font-bold text-center text-white border-b border-blue-700">
        <i class="mr-2 fas fa-capsules"></i> Pharmacist Dashboard
      </div>
      <nav class="flex-1 mt-4">
      <div class="relative">
          <button onclick="toggleDropdown('pharmacistDropdown')" class="flex items-center w-full px-4 py-3 text-white hover:bg-blue-700 focus:outline-none">
            <i class="mr-3 fas fa-user-check"></i> Dashboard
          </button>
          <div id="pharmacistDropdown" class="z-10 hidden w-full mt-2 bg-blue-800 rounded-md shadow-lg">
            <a href="pharmacist_dashboard.php" class="block px-4 py-3 text-white hover:bg-blue-700">Dashboard</a>
         

          </div>
        </div>
      
        <!-- Manage Inventory Dropdown -->
        <div class="relative">
          <button onclick="toggleDropdown('inventoryDropdown')" class="flex items-center w-full px-4 py-3 text-white hover:bg-blue-700 focus:outline-none">
            <i class="mr-3 fas fa-boxes"></i> Manage Inventory
          </button>
          <div id="inventoryDropdown" class="z-10 hidden w-full mt-2 bg-blue-800 rounded-md shadow-lg">
            <a href="view_inventory.php" class="block px-4 py-3 text-white hover:bg-blue-700">View Inventory</a>
            <a href="add_inventory.php" class="block px-4 py-3 text-white hover:bg-blue-700">Add Inventory</a>
          </div>
        </div>

        <!-- Manage Prescriptions Dropdown -->
        <div class="relative">
          <button onclick="toggleDropdown('prescriptionsDropdown')" class="flex items-center w-full px-4 py-3 text-white hover:bg-blue-700 focus:outline-none">
            <i class="mr-3 fas fa-prescription-bottle"></i> Manage Prescriptions
          </button>
          <div id="prescriptionsDropdown" class="z-10 hidden w-full mt-2 bg-blue-800 rounded-md shadow-lg">
            <a href="view_prescriptions.php" class="block px-4 py-3 text-white hover:bg-blue-700">View Prescriptions</a>
            <a href="new_prescription.php" class="block px-4 py-3 text-white hover:bg-blue-700">New Prescription</a>
          </div>
        </div>

        <!-- Communicate with Departments Dropdown -->
        <div class="relative">
          <button onclick="toggleDropdown('departmentsDropdown')" class="flex items-center w-full px-4 py-3 text-white hover:bg-blue-700 focus:outline-none">
            <i class="mr-3 fas fa-building"></i> Comm. with Dep.
          </button>
          <div id="departmentsDropdown" class="z-10 hidden w-full mt-2 bg-blue-800 rounded-md shadow-lg">
           
            <a href="pharmacy_communication.php" class="block px-4 py-3 text-white hover:bg-blue-700">
              <i class="mr-2 fas fa-building"></i> Units
            </a>
           
          </div>
        </div>

        <!-- Logout -->
        <a href="pharmacist_login.php" class="block px-4 py-3 text-white hover:bg-blue-700">Logout</a>
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
