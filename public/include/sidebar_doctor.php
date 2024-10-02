<html>

<head>
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
      <div class="p-5 text-sm font-bold text-center text-white border-b border-blue-700">
        <i class="mr-2 fas fa-stethoscope"></i> Doctor's Dashboard
      </div>

      <!-- Navigation -->
      <nav class="flex-1 mt-4">

      <div class="relative">
          <button onclick="toggleDropdown('doctorDropdown')" class="flex items-center w-full px-4 py-3 text-white hover:bg-blue-700 focus:outline-none">
            <i class="mr-3 fas fa-user-md"></i> Profile
          </button>
          <div id="doctorDropdown" class="z-10 hidden w-full mt-2 bg-blue-800 rounded-md shadow-lg">
            <a href="doctor_dashboard.php" class="block px-4 py-3 text-white hover:bg-blue-700">
             Dashboard
            </a>
          </div>
        </div>

      
        <!-- Patient Management -->
        <div class="relative">
          <button onclick="toggleDropdown('patientDropdown')" class="flex items-center w-full px-4 py-3 text-white hover:bg-blue-700 focus:outline-none">
            <i class="mr-3 fas fa-user-md"></i> Patients
          </button>
          <div id="patientDropdown" class="z-10 hidden w-full mt-2 bg-blue-800 rounded-md shadow-lg">
            <a href="patient_history.php" class="block px-4 py-3 text-white hover:bg-blue-700">
              Patient History
            </a>
          </div>
        </div>

        <!-- Appointment Management -->
        <div class="relative">
          <button onclick="toggleDropdown('appointmentsDropdown')" class="flex items-center w-full px-4 py-3 text-white hover:bg-blue-700 focus:outline-none">
            <i class="mr-3 fas fa-calendar-alt"></i> Appointments
          </button>
          <div id="appointmentsDropdown" class="z-10 hidden w-full mt-2 bg-blue-800 rounded-md shadow-lg">
            <a href="view_appointments.php" class="block px-4 py-3 text-white hover:bg-blue-700">
              View Appointments
            </a>
          </div>
        </div>

        <!-- Prescription Management -->
        <a href="doctor_prescriptions.php" class="block px-4 py-3 text-white hover:bg-blue-700">
          <i class="mr-3 fas fa-prescription-bottle"></i> Manage Prescriptions
        </a>

        <!-- Communication with Departments -->
        <div class="relative">
          <button onclick="toggleDropdown('departmentsDropdown')" class="flex items-center w-full px-4 py-3 text-white hover:bg-blue-700 focus:outline-none">
            <i class="mr-3 fas fa-hospital"></i> Communication
          </button>
          <div id="departmentsDropdown" class="z-10 hidden w-full mt-2 bg-blue-800 rounded-md shadow-lg">
          <a href="doctor_communication.php" class="block px-4 py-3 text-white hover:bg-gray-600">
              <i class="mr-2 fas fa-building"></i> Units
            </a>
          </div>
        </div>

        <!-- Logout -->
        <a href="doctor_login.php" class="block px-4 py-3 text-white hover:bg-blue-700">
          <i class="mr-3 fas fa-sign-out-alt"></i> Logout
        </a>
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

      sidebar.classList.toggle('-translate-x-full');
      overlay.classList.toggle('hidden');

      if (sidebar.classList.contains('-translate-x-full')) {
        navButton.style.left = '2rem';
        navButton.style.right = 'auto';
      } else {
        navButton.style.left = 'auto';
        navButton.style.right = '1rem';
      }
    }
  </script>
</body>

</html>
