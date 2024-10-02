<?php
session_start();
require "./public/include/connect.php";

// Check if the user is logged in and has admin role
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: doctor_dashboard.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($connect, $_POST['name']);
    $specialty = mysqli_real_escape_string($connect, $_POST['specialty']);
    $dob = mysqli_real_escape_string($connect, $_POST['dob']);
    $country_of_origin = mysqli_real_escape_string($connect, $_POST['country_of_origin']);
    $phone = mysqli_real_escape_string($connect, $_POST['phone']);
    $email = mysqli_real_escape_string($connect, $_POST['email']);
    $hospital_id = mysqli_real_escape_string($connect, $_POST['hospital_id']);
    $password = mysqli_real_escape_string($connect, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($connect, $_POST['confirm_password']);

    // Handle file upload for profile picture
    $profile_picture = $_FILES['profile_picture']['name'];
    if ($profile_picture) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($profile_picture);
        move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_file);
    } else {
        $target_file = 'uploads/default-profile.png'; // Default profile picture
    }

    // Check if passwords match
    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match.');</script>";
    } else {
        // Insert doctor into the database
        $query = "INSERT INTO doctors (name, specialty, dob, country_of_origin, phone, email, hospital_id, password, profile_picture, created_at, password_changed) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), 0)";
        $stmt = mysqli_prepare($connect, $query);

        // Bind parameters: "sssssssss" means 8 strings and 1 integer
        mysqli_stmt_bind_param($stmt, "sssssssss", $name, $specialty, $dob, $country_of_origin, $phone, $email, $hospital_id, $password, $target_file);

        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Doctor added successfully!');</script>";
            echo "<script>window.location.href='doctor_login.php';</script>"; // Redirect to doctor login page
            exit();
        } else {
            echo "<script>alert('Error adding doctor: " . mysqli_error($connect) . "');</script>";
        }
    }
}

// Fetch all hospitals for the dropdown
$hospitalsQuery = "SELECT id, name FROM hospitals";
$hospitalsResult = mysqli_query($connect, $hospitalsQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Doctor</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
</head>
<body class="bg-gray-100">
    <!-- Sidebar -->
    <div class="flex">
        <?php require "./public/include/sidebar_admin.php"; ?>
        
        <!-- Main Content -->
        <div class="w-4/5 p-8">
            <div class="container max-w-2xl p-6 mx-auto bg-white rounded-lg shadow-lg">
                <h1 class="mb-6 text-3xl font-bold text-center text-gray-800">Add New Doctor</h1>

                <form action="add_doctor.php" method="POST" enctype="multipart/form-data" class="space-y-4">
                    <div>
                        <label for="name" class="block text-gray-700">Name</label>
                        <input type="text" name="name" id="name" required class="w-full p-2 border border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label for="specialty" class="block text-gray-700">Specialty</label>
                        <input type="text" name="specialty" id="specialty" required class="w-full p-2 border border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label for="dob" class="block text-gray-700">DOB</label>
                        <input type="date" name="dob" id="dob" required class="w-full p-2 border border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label for="country_of_origin" class="block text-gray-700">Country of Origin</label>
                        <input type="text" name="country_of_origin" id="country_of_origin" required class="w-full p-2 border border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label for="phone" class="block text-gray-700">Phone</label>
                        <input type="text" name="phone" id="phone" required class="w-full p-2 border border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label for="email" class="block text-gray-700">Email</label>
                        <input type="email" name="email" id="email" required class="w-full p-2 border border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label for="hospital_id" class="block text-gray-700">Hospital</label>
                        <select name="hospital_id" id="hospital_id" required class="w-full p-2 border border-gray-300 rounded-md">
                            <option value="">Select Hospital</option>
                            <?php while ($hospital = mysqli_fetch_assoc($hospitalsResult)): ?>
                                <option value="<?php echo htmlspecialchars($hospital['id']); ?>"><?php echo htmlspecialchars($hospital['name']); ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div>
                        <label for="password" class="block text-gray-700">Password</label>
                        <input type="password" name="password" id="password" required class="w-full p-2 border border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label for="confirm_password" class="block text-gray-700">Confirm Password</label>
                        <input type="password" name="confirm_password" id="confirm_password" required class="w-full p-2 border border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label for="profile_picture" class="block text-gray-700">Profile Picture</label>
                        <input type="file" name="profile_picture" id="profile_picture" accept="image/*" class="w-full p-2 border border-gray-300 rounded-md">
                    </div>
                    <button type="submit" class="w-full p-2 text-white bg-blue-500 rounded-md hover:bg-blue-600">Add Doctor</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
