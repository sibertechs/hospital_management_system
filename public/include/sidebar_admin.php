<head>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Tailwind CSS (include this in your project or link to a CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <!-- Admin Sidebar -->
    <aside id="sidebar" class="hidden w-64 min-h-screen bg-gray-800 shadow-md md:block">
        <div class="text-white bg-gray-800 sidebar">
            <div class="p-5 font-bold text-center">Admin Dashboard</div>
            <nav class="mt-5">
                <!-- Dashboard Link -->
                <a href="admin_dashboard.php" class="flex items-center px-4 py-2 hover:bg-gray-700 <?php echo basename($_SERVER['PHP_SELF']) == 'admin_dashboard.php' ? 'bg-gray-700' : ''; ?>">
                    <i class="mr-2 fas fa-tachometer-alt"></i> Dashboard
                </a>

             

                <!-- Add Admin Link -->
                <a href="add_admin.php" class="flex items-center px-4 py-2 hover:bg-gray-700 <?php echo basename($_SERVER['PHP_SELF']) == 'add_admin.php' ? 'bg-gray-700' : ''; ?>">
                    <i class="mr-2 fas fa-user-plus"></i> Add New Admin
                </a>

                <!-- Manage Patient Dropdown -->
                <div class="relative">
                    <button onclick="toggleDropdown('patientDropdown')" class="flex items-center w-full px-4 py-2 text-left hover:bg-gray-700 focus:outline-none focus:bg-gray-700">
                        <i class="mr-2 fas fa-calendar-check"></i> Manage Patient
                    </button>
                    <div id="patientDropdown" class="hidden w-full mt-2 bg-gray-800 rounded-md shadow-lg">
                        <a href="patient_registration.php" class="block px-4 py-2 hover:bg-gray-600 <?php echo basename($_SERVER['PHP_SELF']) == 'patient_registration.php' ? 'bg-gray-600' : ''; ?>">Patient Registration</a>
                        <a href="patient_dashboard.php" class="block px-4 py-2 hover:bg-gray-600 <?php echo basename($_SERVER['PHP_SELF']) == 'patient_dashboard.php' ? 'bg-gray-600' : ''; ?>">Patient Dashboard</a>
                    </div>
                </div>

               
              

                <!-- Manage Appointments Dropdown -->
                <div class="relative">
                    <button onclick="toggleDropdown('appointmentsDropdown')" class="flex items-center w-full px-4 py-2 text-left hover:bg-gray-700 focus:outline-none focus:bg-gray-700">
                        <i class="mr-2 fas fa-calendar-alt"></i> Manage Appointments
                    </button>
                    <div id="appointmentsDropdown" class="hidden w-full mt-2 bg-gray-800 rounded-md shadow-lg">
                        <a href="schedule_appointment.php" class="block px-4 py-2 hover:bg-gray-600 <?php echo basename($_SERVER['PHP_SELF']) == 'schedule_appointment.php' ? 'bg-gray-600' : ''; ?>">Schedule Appointment</a>
                    </div>
                </div>

                <!-- Manage Doctors Dropdown -->
                <div class="relative">
                    <button onclick="toggleDropdown('doctorsDropdown')" class="flex items-center w-full px-4 py-2 text-left hover:bg-gray-700 focus:outline-none focus:bg-gray-700">
                        <i class="mr-2 fas fa-user-md"></i> Manage Doctors
                    </button>
                    <div id="doctorsDropdown" class="hidden w-full mt-2 bg-gray-800 rounded-md shadow-lg">
                        <a href="add_doctor.php" class="block px-4 py-2 hover:bg-gray-600 <?php echo basename($_SERVER['PHP_SELF']) == 'add_doctor.php' ? 'bg-gray-600' : ''; ?>">Add Doctor</a>
                        <a href="manage_doctors.php" class="block px-4 py-2 hover:bg-gray-600 <?php echo basename($_SERVER['PHP_SELF']) == 'manage_doctors.php' ? 'bg-gray-600' : ''; ?>">View Doctors</a>
                    </div>
                </div>

                <!-- Manage Registration for Pharmacists, Finance, Lab -->
                <div class="relative">
                    <button onclick="toggleDropdown('staffDropdown')" class="flex items-center w-full px-4 py-2 text-left hover:bg-gray-700 focus:outline-none focus:bg-gray-700">
                        <i class="mr-2 fas fa-user-nurse"></i> Register Staff
                    </button>
                    <div id="staffDropdown" class="hidden w-full mt-2 bg-gray-800 rounded-md shadow-lg">
                        <a href="add_doctor.php" class="block px-4 py-2 hover:bg-gray-600 <?php echo basename($_SERVER['PHP_SELF']) == 'register_doctor.php' ? 'bg-gray-600' : ''; ?>">Register Doctor</a>
                        <a href="pharmacist_register.php" class="block px-4 py-2 hover:bg-gray-600 <?php echo basename($_SERVER['PHP_SELF']) == 'register_pharmacist.php' ? 'bg-gray-600' : ''; ?>">Register Pharmacist</a>
                        <a href="finance_register.php" class="block px-4 py-2 hover:bg-gray-600 <?php echo basename($_SERVER['PHP_SELF']) == 'register_finance.php' ? 'bg-gray-600' : ''; ?>">Register Finance</a>
                        <a href="lab_register.php" class="block px-4 py-2 hover:bg-gray-600 <?php echo basename($_SERVER['PHP_SELF']) == 'register_lab.php' ? 'bg-gray-600' : ''; ?>">Register Lab</a>
                    </div>
                </div>

                <!-- Manage Hospitals Dropdown -->
                <div class="relative">
                    <button onclick="toggleDropdown('hospitalsDropdown')" class="flex items-center w-full px-4 py-2 text-left hover:bg-gray-700 focus:outline-none focus:bg-gray-700">
                        <i class="mr-2 fas fa-hospital"></i> Manage Hospitals
                    </button>
                    <div id="hospitalsDropdown" class="hidden w-full mt-2 bg-gray-800 rounded-md shadow-lg">
                        <a href="add_hospital.php" class="block px-4 py-2 hover:bg-gray-600 <?php echo basename($_SERVER['PHP_SELF']) == 'add_hospital.php' ? 'bg-gray-600' : ''; ?>">Add Hospital</a>
                        
                    </div>
                </div>

               
            </nav>
        </div>
    </aside>

    <script>
        function toggleDropdown(dropdownId) {
            const dropdown = document.getElementById(dropdownId);
            dropdown.classList.toggle('hidden');
        }
    </script>
</body>
