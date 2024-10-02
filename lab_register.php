<?php 
session_start();
require "./public/include/connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data safely
    $name = $_POST['name'] ?? null;
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;

    // Check if fields are filled
    if (empty($name) || empty($email) || empty($password)) {
        die("All fields are required.");
    }

    // Prepare SQL statement to insert new lab staff
    $stmt = $connect->prepare("INSERT INTO lab_staff (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $password);

    // Execute and check for errors
    if ($stmt->execute()) {
        // Get the last inserted ID and set session variable
        $_SESSION['lab_staff_id'] = $connect->insert_id; // Set session variable with the new lab staff ID
        
        header("Location: lab_login.php"); // Redirect to login page after successful registration
        exit();
    } else {
        $error = "Error: " . $stmt->error; // Capture any error during insertion
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
    <title>Lab Register</title>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="p-8 bg-white rounded-lg shadow-md w-96">
        <h2 class="mb-6 text-2xl font-bold text-center">Lab Register</h2>
        <?php if (isset($error)): ?>
            <div class="mb-4 text-center text-red-500"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form action="lab_register.php" method="POST">
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name" id="name" required class="block w-full p-2 mt-1 border border-gray-300 rounded-md">
            </div>
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" required class="block w-full p-2 mt-1 border border-gray-300 rounded-md">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="password" required class="block w-full p-2 mt-1 border border-gray-300 rounded-md">
            </div>
            <button type="submit" class="w-full py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600">Register</button>
        </form>
        <p class="mt-4 text-center">
            Already have an account? <a href="lab_login.php" class="text-blue-500">Login here</a>
        </p>
    </div>
</body>
</html>