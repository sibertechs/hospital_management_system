<?php
// Include your database connection here
require "./public/include/connect.php";

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data safely
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;

    // Check if fields are filled
    if (empty($email) || empty($password)) {
        die("Both fields are required.");
    }

    // Prepare SQL statement
    $stmt = $connect->prepare("SELECT * FROM lab_staff WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the user exists
    if ($result->num_rows > 0) {
        $_SESSION['email'] = $email; // Store email in session
        header("Location: lab_dashboard.php"); // Redirect to lab dashboard
        exit();
    } else {
        $error = "Invalid email or password.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Lab Login</title>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="p-8 bg-white rounded-lg shadow-md w-96">
        <h2 class="mb-6 text-2xl font-bold text-center">Lab Login</h2>
        <?php if (isset($error)): ?>
            <div class="mb-4 text-center text-red-500"><?php echo $error; ?></div>
        <?php endif; ?>
        <form action="lab_login.php" method="POST">
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" required class="block w-full p-2 mt-1 border border-gray-300 rounded-md">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="password" required class="block w-full p-2 mt-1 border border-gray-300 rounded-md">
            </div>
            <button type="submit" class="w-full py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600">Login</button>
        </form>
        <p class="mt-4 text-center">
            Don't have an account? <a href="lab_register.php" class="text-blue-500">Register here</a>
        </p>
    </div>
</body>
</html>
