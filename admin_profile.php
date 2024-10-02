<?php
session_start();
require "./public/include/connect.php";

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // Redirect to the login page if not logged in
    header('Location: admin_login.php');
    exit;
}

// $admin_id = $_SESSION['admin_id'];

// Initialize biodata and actions arrays
$biodata = $actions = [];

// Fetch biodata
$admin_query = "SELECT * FROM user_registration WHERE id = ?";
$stmt = mysqli_prepare($connect, $admin_query);
mysqli_stmt_bind_param($stmt, "i", $admin_id);
mysqli_stmt_execute($stmt);
$admin_result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($admin_result) == 0) {
    echo "<script>alert('Admin not found.'); window.location.href='login.php';</script>";
    exit;
}

$biodata = mysqli_fetch_assoc($admin_result);

// Fetch admin actions
$actions_query = "SELECT * FROM admin_action_logs WHERE admin_id = ? ORDER BY action_time DESC";
$stmt = mysqli_prepare($connect, $actions_query);
mysqli_stmt_bind_param($stmt, "i", $admin_id);
mysqli_stmt_execute($stmt);
$actions_result = mysqli_stmt_get_result($stmt);
$actions = mysqli_fetch_all($actions_result, MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }
        .bg-custom {
            background-color: #f3f4f6; /* Light gray background */
        }
        .card {
            background-color: #ffffff; /* White card background */
            border-radius: 0.5rem; /* Rounded corners */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); /* Soft shadow */
        }
        .btn-primary {
            background-color: #4f46e5; /* Indigo background */
            color: white;
        }
        .btn-primary:hover {
            background-color: #4338ca; /* Darker indigo on hover */
        }
        .table-header {
            background-color: #e5e7eb; /* Light gray for table header */
        }
        .table-row:hover {
            background-color: #f9fafb; /* Light hover effect */
        }
    </style>
</head>
<body class="bg-custom">

<div class="grid grid-cols-1 gap-4 p-4 md:grid-cols-4">
    <!-- Sidebar -->
    <aside class="col-span-1 p-4 bg-white shadow-lg">
        <?php require "./public/include/sidebar_admin.php"; ?>
    </aside>

    <!-- Main Content -->
    <main class="col-span-3 p-6 mt-4 card">
        <h1 class="mb-4 text-3xl font-bold text-gray-800">Admin Profile</h1>

        <!-- Biodata Section -->
        <section class="mb-6">
            <h2 class="mb-2 text-2xl font-semibold text-gray-700">Biodata</h2>
            <?php if ($biodata): ?>
                <div class="flex flex-col items-center md:flex-row md:items-start">
                    <?php
                    $profile_picture_path = 'uploads/' . htmlspecialchars($biodata['profile_picture'] ?? 'default-profile.png');
                    if (!file_exists($profile_picture_path)) {
                        $profile_picture_path = 'uploads/default-profile.png';
                    }
                    ?>
                    <img id="profilePic" src="<?php echo $profile_picture_path; ?>" alt="Profile Picture" class="w-32 h-32 mb-4 border-2 border-gray-300 rounded-full shadow-lg md:w-40 md:h-40 md:mb-0 md:mr-6">
                    <div class="flex flex-col">
                        <p class="text-gray-600"><strong>Name:</strong> <?php echo htmlspecialchars($biodata['name'] ?? 'N/A'); ?></p>
                        <p class="text-gray-600"><strong>Phone:</strong> <?php echo htmlspecialchars($biodata['phone'] ?? 'N/A'); ?></p>
                        <p class="text-gray-600"><strong>Email:</strong> <?php echo htmlspecialchars($biodata['email'] ?? 'N/A'); ?></p>
                        <p class="text-gray-600"><strong>Date of Birth:</strong> <?php echo htmlspecialchars($biodata['dob'] ?? 'N/A'); ?></p>
                        <p class="text-gray-600"><strong>Country of Origin:</strong> <?php echo htmlspecialchars($biodata['country_of_origin'] ?? 'N/A'); ?></p>
                        <input type="file" id="profilePicInput" class="p-2 mt-2 border border-gray-300 rounded" accept="image/*" onchange="handleProfilePicChange(event)">
                    </div>
                </div>
            <?php else: ?>
                <p>No biodata found for this admin.</p>
            <?php endif; ?>
        </section>

        <!-- Actions Section -->
        <section>
            <h2 class="mb-2 text-2xl font-semibold text-gray-700">Recent Actions</h2>
            <?php if ($actions): ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border-collapse shadow-lg">
                        <thead>
                            <tr class="table-header">
                                <th class="px-4 py-2 border">Action</th>
                                <th class="px-4 py-2 border">Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($actions as $action): ?>
                                <tr class="table-row">
                                    <td class="px-4 py-2 border"><?php echo htmlspecialchars($action['action']); ?></td>
                                    <td class="px-4 py-2 border"><?php echo htmlspecialchars($action['action_time']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p>No actions found for this admin.</p>
            <?php endif; ?>
        </section>

        <div class="flex justify-between mt-6">
            <a href="admin_dashboard.php" class="px-4 py-2 transition duration-200 rounded btn-primary hover:bg-blue-600">
                Back to Admin Dashboard
            </a>
        </div>
    </main>
</div>

<script>
    function handleProfilePicChange(event) {
        const file = event.target.files[0];
        if (file) {
            const formData = new FormData();
            formData.append('profile_picture', file);
            formData.append('admin_id', <?php echo json_encode($admin_id); ?>);
            
            fetch('update_profile_picture.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('profilePic').src = data.new_image_url;
                    alert('Profile picture updated successfully.');
                } else {
                    alert('Failed to update profile picture.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while updating the profile picture.');
            });
        }
    }
</script>

</body>
</html>

<?php
mysqli_close($connect);
?>
