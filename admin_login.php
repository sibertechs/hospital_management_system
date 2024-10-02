<?php
require "./public/include/connect.php";
session_start();

// Handle form submission
if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($connect, $_POST['email']);
    $password = mysqli_real_escape_string($connect, $_POST['password']);

    // Check for default credentials
    if ($email === 'admin@gmail.com' && $password === 'admin123') {
        // Regenerate session ID to prevent session fixation
        session_regenerate_id(true);
        $_SESSION['role'] = 'admin';
        $_SESSION['email'] = $email;
        echo "<script>alert('Login Successful');</script>";
        echo "<script>window.location.href='admin_dashboard.php';</script>";
        exit();
    }

    // Prepared statement to prevent SQL injection
    $stmt = $connect->prepare("SELECT * FROM user_registration WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Debugging: Check what user data is retrieved
    if ($user) {
        // Check if user exists and password matches
        if ($password === $user['password']) { // No hashing, direct comparison
            // Regenerate session ID to prevent session fixation
            session_regenerate_id(true);
            $_SESSION['role'] = $user['role']; // Assuming role is stored in the user_registration table
            $_SESSION['email'] = $user['email'];
            echo "<script>alert('Login Successful');</script>";
            echo "<script>window.location.href='admin_dashboard.php';</script>";
        } else {
            echo "<script>alert('Invalid Email or Password');</script>";
        }
    } else {
        echo "<script>alert('Invalid Email or Password');</script>";
    }

    $stmt->close();
    $connect->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
</head>
<body class="flex items-center justify-center h-screen bg-gray-100">
    <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-md">
        <h2 class="mb-4 text-2xl font-bold">Admin Login</h2>
        <form method="POST">
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password" class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm" required>
            </div>
            <button type="submit" name="submit" class="w-full py-2 text-white bg-blue-500 rounded-md">Login</button>
        </form>
    </div>
</body>
</html>