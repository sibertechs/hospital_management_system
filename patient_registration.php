<?php
session_start();
require "./public/include/connect.php";

// Check if the user is logged in and has admin role
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: admin_login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get patient details from the form
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $dob = $_POST['dob'];
    $country_of_origin = $_POST['country_of_origin'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $profile_picture = $_FILES['profile_picture']['name'];
    
    // Health insurance fields
    $membership_id = $_POST['membership_id'];
    $issued_date = $_POST['issued_date'];
    $expiry_date = $_POST['expiry_date'];

    // Handle file upload
    if ($profile_picture) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($profile_picture);
        move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_file);
    } else {
        $target_file = 'uploads/default-profile.png'; // Default profile picture
    }

    // Check if the passwords match
    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match.');</script>";
    } else {
        // Check if the email already exists
        $checkEmailQuery = "SELECT * FROM patient_registration WHERE email = ?";
        $stmt = mysqli_prepare($connect, $checkEmailQuery);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $checkEmailResult = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($checkEmailResult) > 0) {
            echo "<script>alert('This email is already registered.');</script>";
        } else {
            // Insert patient into the database without hashing the password
            $query = "INSERT INTO patient_registration (name, phone, email, dob, country_of_origin, password, profile_picture, membership_id, issued_date, expiry_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($connect, $query);
            mysqli_stmt_bind_param($stmt, "ssssssssss", $name, $phone, $email, $dob, $country_of_origin, $password, $target_file, $membership_id, $issued_date, $expiry_date);

            if (mysqli_stmt_execute($stmt)) {
                echo "<script>alert('Patient registered successfully.');</script>";
                echo "<script>window.location.href='patient_login.php';</script>";
            } else {
                echo "<script>alert('Error: " . mysqli_error($connect) . "');</script>";
            }
        }
    }
}

$connect->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Patient</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
</head>
<body class="flex bg-gray-100">
    <!-- Sidebar -->
    <?php require "./public/include/sidebar_admin.php"; ?>

    <!-- Main Content -->
    <div class="w-full p-8 ml-8">
        <div class="container p-8 bg-white rounded-lg shadow-lg">
            <h1 class="mb-8 text-3xl font-bold text-gray-800">Patient Registration</h1>
            <form action="" method="POST" enctype="multipart/form-data" class="space-y-6">
                <div>
                    <label for="name" class="block mb-2 text-lg font-medium text-gray-700">Name</label>
                    <input type="text" name="name" id="name" placeholder="Enter your name" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div>
                    <label for="phone" class="block mb-2 text-lg font-medium text-gray-700">Phone</label>
                    <input type="text" name="phone" id="phone" placeholder="Enter your phone number" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div>
                    <label for="email" class="block mb-2 text-lg font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" placeholder="Enter your email" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div>
                    <label for="dob" class="block mb-2 text-lg font-medium text-gray-700">Date of Birth</label>
                    <input type="date" name="dob" id="dob" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div>
                    <label for="password" class="block mb-2 text-lg font-medium text-gray-700">Password</label>
                    <input type="password" name="password" id="password" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div>
                    <label for="confirm_password" class="block mb-2 text-lg font-medium text-gray-700">Confirm Password</label>
                    <input type="password" name="confirm_password" id="confirm_password" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div>
                    <label for="country_of_origin" class="block mb-2 text-lg font-medium text-gray-700">Country of Origin</label>
                    <input type="text" name="country_of_origin" id="country_of_origin" placeholder="Enter your country of origin" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div>
                    <label for="profile_picture" class="block mb-2 text-lg font-medium text-gray-700">Profile Picture</label>
                    <input type="file" name="profile_picture" id="profile_picture" accept="image/*" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label for="membership_id" class="block mb-2 text-lg font-medium text-gray-700">Health Insurance Membership ID</label>
                    <input type="text" name="membership_id" id="membership_id" placeholder="Enter Membership ID" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div>
                    <label for="issued_date" class="block mb-2 text-lg font-medium text-gray-700">Issued Date</label>
                    <input type="date" name="issued_date" id="issued_date" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div>
                    <label for="expiry_date" class="block mb-2 text-lg font-medium text-gray-700">Expiry Date</label>
                    <input type="date" name="expiry_date" id="expiry_date" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <button type="submit" class="w-full p-3 text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:ring-4 focus:ring-blue-300">Register</button>
            </form>
        </div>
    </div>
</body>
</html>
