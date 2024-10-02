<aside id="sidebar" class="w-64 bg-gray-800 shadow-md min-h-screen">
    <div class="sidebar w-64 bg-gray-800 text-white">
        <div class="p-5 text-center font-bold text-xl">Dashboard</div>
        <nav class="mt-5">
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                <a href="admin_dashboard.php" class="flex items-center px-4 py-2 hover:bg-gray-700 <?php echo basename($_SERVER['PHP_SELF']) == 'admin_dashboard.php' ? 'bg-gray-700' : ''; ?>">
                    <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                </a>
                <a href="admin_profile.php" class="flex items-center px-4 py-2 hover:bg-gray-700 <?php echo basename($_SERVER['PHP_SELF']) == 'admin_profile.php' ? 'bg-gray-700' : ''; ?>">
                    <i class="fas fa-user-circle mr-2"></i> Profile
                </a>
                <a href="add_admin.php" class="flex items-center px-4 py-2 hover:bg-gray-700 <?php echo basename($_SERVER['PHP_SELF']) == 'add_admin.php' ? 'bg-gray-700' : ''; ?>">
                    <i class="fas fa-user-plus mr-2"></i> Add New Admin
                </a>
                <a href="logout.php" class="block px-4 py-2 hover:bg-gray-700">Logout</a>
            <?php elseif (isset($_SESSION['role']) && $_SESSION['role'] == 'patient'): ?>
                <a href="patient_dashboard.php" class="flex items-center px-4 py-2 hover:bg-gray-700 <?php echo basename($_SERVER['PHP_SELF']) == 'patient_dashboard.php' ? 'bg-gray-700' : ''; ?>">
                    <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                </a>
                <a href="schedule_appointment.php" class="flex items-center px-4 py-2 hover:bg-gray-700 <?php echo basename($_SERVER['PHP_SELF']) == 'schedule_appointment.php' ? 'bg-gray-700' : ''; ?>">
                    <i class="fas fa-calendar-plus mr-2"></i> Book Appointment
                </a>
                <a href="patient_profile.php" class="flex items-center px-4 py-2 hover:bg-gray-700 <?php echo basename($_SERVER['PHP_SELF']) == 'patient_profile.php' ? 'bg-gray-700' : ''; ?>">
                    <i class="fas fa-user-circle mr-2"></i> Profile
                </a>
                <a href="logout.php" class="block px-4 py-2 hover:bg-gray-700">Logout</a>
            <?php endif; ?>
        </nav>
    </div>
</aside>