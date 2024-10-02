<?php
require "./public/include/connect.php";
session_start();

// Check if the user is logged in as admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
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

    // Check if 'bio' is set, otherwise use an empty string
    $bio = isset($_POST['bio']) ? mysqli_real_escape_string($connect, $_POST['bio']) : '';

    $is_approved = 1; // Set default approval status

    // Handle profile picture upload
    $profilePicture = 'uploads/default-profile.png'; // Default image if no upload
    $uploadDir = './uploads/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true); // Ensure upload directory exists
    }

    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['profile_picture']['tmp_name'];
        $fileName = $_FILES['profile_picture']['name'];
        $fileSize = $_FILES['profile_picture']['size'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Define allowed file extensions and size limit
        $allowedExts = ['jpg', 'jpeg', 'png'];
        $maxSize = 5 * 1024 * 1024; // 5MB

        if (in_array($fileExtension, $allowedExts) && $fileSize <= $maxSize) {
            $filePath = $uploadDir . uniqid() . '.' . $fileExtension;

            if (move_uploaded_file($fileTmpPath, $filePath)) {
                $profilePicture = $filePath; // Assign uploaded file path
            } else {
                echo "<script>alert('Error uploading file.');</script>";
            }
        } else {
            echo "<script>alert('Error: Invalid file type or size.');</script>";
        }
    }

    // Check if email already exists
    $emailCheckQuery = "SELECT COUNT(*) FROM user_registration WHERE email = ?";
    $stmt = mysqli_prepare($connect, $emailCheckQuery);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $count);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if ($count > 0) {
        echo "<script>alert('Error: Email already exists.');</script>";
    } else {
        // Insert new admin into the database using prepared statement
        $query = "INSERT INTO user_registration (name, phone, dob, country_of_origin, email, password, profile_picture, bio, role) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'admin')";

        $stmt = mysqli_prepare($connect, $query);
        mysqli_stmt_bind_param($stmt, "ssssssss", $name, $phone, $dob, $country_of_origin, $email, $password, $profilePicture, $bio);

        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Admin Registered Successfully');</script>";
            echo "<script>window.location.href='admin_login.php';</script>";
        } else {
            echo "<script>alert('Admin Not Registered Successfully');</script>";
        }

        mysqli_stmt_close($stmt);
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
</head>
<body class="bg-gray-100">
    <div class="flex">
        <!-- Sidebar -->
        <?php require "./public/include/sidebar_admin.php"; ?>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            <div class="max-w-4xl p-6 mx-auto mt-10 bg-white rounded-lg shadow-md">
                <h1 class="mb-4 text-2xl font-bold">Add New Admin</h1>
                <form action="add_admin.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Full Name:</label>
                        <input type="text" id="name" name="name" class="w-full p-2 border-b border-gray-300 outline-none" required>
                    </div>
                    <div class="mb-4">
                        <label for="phone" class="block text-sm font-medium text-gray-700">Phone:</label>
                        <input type="text" id="phone" name="phone" class="w-full p-2 border-b border-gray-300 outline-none">
                    </div>
                    <div class="mb-4">
                        <label for="dob" class="block text-sm font-medium text-gray-700">Date of Birth:</label>
                        <input type="date" id="dob" name="dob" class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div class="mb-4">
                        <label for="country_of_origin" class="block text-sm font-medium text-gray-700">Country of Origin:</label>
                        <input type="text" id="country_of_origin" name="country_of_origin" class="w-full p-2 border-b border-gray-300 outline-none">
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email:</label>
                        <input type="email" id="email" name="email" class="w-full p-2 border-b border-gray-300 outline-none" required>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password:</label>
                        <input type="password" id="password" name="password" class="w-full p-2 border-b border-gray-300 outline-none" required>
                    </div>
                    <button type="submit" name="submit" class="px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600">Add Admin</button>
                </form>
            </div>
        </main>
    </div>
</body>
</html>