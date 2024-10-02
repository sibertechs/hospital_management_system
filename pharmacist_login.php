<?php 
session_start();
require "./public/include/connect.php"; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data safely
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;

    // Check if fields are filled
    if (empty($email) || empty($password)) {
        $error = "Both fields are required.";
    } else {
        // Prepare SQL statement to check credentials
        $stmt = $connect->prepare("SELECT * FROM pharmacists WHERE email = ? AND password = ?");
        $stmt->bind_param("ss", $email, $password); // Directly compare passwords without hashing
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if the user exists
        if ($result->num_rows > 0) {
            $pharmacist = $result->fetch_assoc();
            $_SESSION['pharmacist_id'] = $pharmacist['id']; // Set session variable
            $_SESSION['role'] = 'pharmacist'; // Set role for access control

            header("Location: pharmacist_dashboard.php"); // Redirect to dashboard
            exit();
        } else {
            $error = "Invalid email or password.";
        }
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <title>Pharmacist Login</title>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="p-8 bg-white rounded-lg shadow-md w-96">
        <h2 class="mb-6 text-2xl font-bold text-center">Pharmacist Login</h2>
        <?php if (isset($error)): ?>
            <div class="mb-4 text-center text-red-500"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form action="pharmacist_login.php" method="POST">
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" required class="block w-full p-2 mt-1 border border-gray-300 rounded-md">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="password" required class="block w-full p-2 mt-1 border border-gray-300 rounded-md">
            </div>
            <button type="submit" class="w-full py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600">Login</button>
            <p class="mt-4 text-center">Don't have an account? <a href="pharmacist_register.php" class="text-blue-500">Register here</a></p>
        </form>
    </div>
</body>
</html>