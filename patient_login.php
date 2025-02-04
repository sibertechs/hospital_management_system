<?php
session_start();
require "./public/include/connect.php";

$error_message = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($connect, $_POST['email']);
    $password = mysqli_real_escape_string($connect, $_POST['password']);

    // Fetch patient data
    $query = "SELECT * FROM patient_registration WHERE email = ?";
    $stmt = mysqli_prepare($connect, $query);
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $patient = mysqli_fetch_assoc($result);

    if ($patient) {
        // Check if the password matches
        if ($password === $patient['password']) {  // Check against the database-stored password
            $_SESSION['patient_id'] = $patient['id'];
            $_SESSION['role'] = 'patient';

            // Check if the password has been changed
            if ($patient['password_changed'] == 0) {
                $_SESSION['change_password'] = true; // Set session variable to show modal
                header("Location: patient_dashboard.php"); // Redirect to dashboard
                exit();
            } else {
                // Normal login flow
                header("Location: patient_dashboard.php");
                exit();
            }
        } else {
            $error_message = "Invalid email or password.";
        }
    } else {
        $error_message = "No account found with that email.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
</head>
<body class="flex items-center justify-center h-screen bg-gray-100">
    <div class="w-full max-w-md p-8 bg-white rounded-lg shadow-lg">
        <h1 class="mb-4 text-2xl font-bold text-center">Patient Login</h1>
        
        <?php if (isset($error_message)): ?>
            <div class="p-4 mb-6 text-red-800 bg-red-100 rounded">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>
        
        <form action="" method="POST">
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email</label>
                <input type="email" name="email" id="email" placeholder="Email" class="w-full p-2 border-b border-gray-300 rounded outline-none" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700">Password</label>
                <input type="password" name="password" id="password" placeholder="Password" class="w-full p-2 border-b border-gray-300 rounded outline-none" required>
            </div>
            <button type="submit" class="w-full p-2 text-white bg-blue-500 rounded hover:bg-blue-600">Login</button>
        </form>
    </div>
</body>
</html>
