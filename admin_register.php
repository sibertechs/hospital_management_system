<?php
require "./public/include/connect.php";
session_start();

// Check if the user is logged in as admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // If not logged in as admin, redirect to admin login page
    header('Location: admin_login.php');
    exit();
}

// Handle form submission
if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($connect, $_POST['name']);
    $email = mysqli_real_escape_string($connect, $_POST['email']);
    $password = mysqli_real_escape_string($connect, $_POST['password']);
    $phone = mysqli_real_escape_string($connect, $_POST['phone']);
    $dob = mysqli_real_escape_string($connect, $_POST['dob']);
    $country_of_origin = mysqli_real_escape_string($connect, $_POST['country_of_origin']);
    $bio = mysqli_real_escape_string($connect, $_POST['bio']);
    $is_approved = 1; // Set default approval status

    // Handle file upload
    $profile_picture = '';
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
        $target_dir = "uploads/"; // Ensure this directory exists and is writable
        $target_file = $target_dir . basename($_FILES["profile_picture"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if file is an image
        $check = getimagesize($_FILES["profile_picture"]["tmp_name"]);
        if ($check !== false) {
            // Move the uploaded file to the target directory
            if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
                $profile_picture = mysqli_real_escape_string($connect, $target_file);
            } else {
                echo "<script>alert('Error uploading file.');</script>";
            }
        } else {
            echo "<script>alert('File is not an image.');</script>";
        }
    }

    // Insert into the database
    $query = "INSERT INTO user_registration (name, email, password, is_approved, phone, dob, country_of_origin, bio, profile_picture) 
              VALUES ('$name', '$email', '$password', '$is_approved', '$phone', '$dob', '$country_of_origin', '$bio', '$profile_picture')";
    
    if (mysqli_query($connect, $query)) {
        echo "<script>alert('User Registered Successfully');</script>";
        echo "<script>window.location.href='admin_dashboard.php';</script>";
    } else {
        echo "<script>alert('Error registering user');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php require "./public/include/head.php"; ?>
<body class="flex items-center justify-center h-screen bg-gray-100">
    <div class="max-w-md w-full bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4">Register New User</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" id="name" name="name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm" required>
            </div>
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm" required>
            </div>
            <div class="mb-4">
                <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                <input type="text" id="phone" name="phone" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm" required>
            </div>
            <div class="mb-4">
                <label for="dob" class="block text-sm font-medium text-gray-700">Date of Birth</label>
                <input type="date" id="dob" name="dob" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm" required>
            </div>
            <div class="mb-4">
                <label for="country_of_origin" class="block text-sm font-medium text-gray-700">Country of Origin</label>
                <input type="text" id="country_of_origin" name="country_of_origin" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm" required>
            </div>
            <div class="mb-4">
                <label for="bio" class="block text-sm font-medium text-gray-700">Bio</label>
                <textarea id="bio" name="bio" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm" rows="3" required></textarea>
            </div>
            <div class="mb-4">
                <label for="profile_picture" class="block text-sm font-medium text-gray-700">Profile Picture</label>
                <input type="file" id="profile_picture" name="profile_picture" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm" accept="image/*" required>
            </div>
            <button type="submit" name="submit" class="w-full bg-blue-500 text-white py-2 rounded-md">Register</button>
        </form>
    </div>
</body>
</html>
