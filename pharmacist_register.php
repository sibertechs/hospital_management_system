<?php
session_start();
require "./public/include/connect.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Insert into the database
    $query = "INSERT INTO pharmacists (name, email, password) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($connect, $query);
    mysqli_stmt_bind_param($stmt, "sss", $name, $email, $password);
    
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success_message'] = "Registration successful! You can now log in.";
        header("Location: pharmacist_login.php");
        exit();
    } else {
        $error_message = "Registration failed: " . mysqli_error($connect);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pharmacist Registration</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
</head>
<body class="bg-gray-100">
    <div class="flex items-center justify-center min-h-screen">
        <form class="p-6 bg-white rounded-lg shadow-md w-96" method="POST" action="">
            <h2 class="mb-6 text-2xl font-bold text-center">Register as Pharmacist</h2>
            <?php if (isset($error_message)) : ?>
                <div class="mb-4 text-red-600"><?php echo $error_message; ?></div>
            <?php endif; ?>
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium">Name</label>
                <input type="text" name="name" id="name" required class="block w-full mt-1 border-b rounded-md shadow-sm outline-none">
            </div>
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium">Email</label>
                <input type="email" name="email" id="email" required class="block w-full mt-1 border-b rounded-md shadow-sm outline-none">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium">Password</label>
                <input type="password" name="password" id="password" required class="block w-full mt-1 border-b rounded-md shadow-sm outline-none">
            </div>
            <button type="submit" class="w-full py-2 text-white bg-blue-600 rounded-md">Register</button>
            <p class="mt-4 text-center">Already have an account? <a href="pharmacist_login.php" class="text-blue-600">Login</a></p>
        </form>
    </div>
</body>
</html>
