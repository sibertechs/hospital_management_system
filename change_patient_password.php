<?php
session_start();
require "./public/include/connect.php";

// Fetch the logged-in patient's ID
if (!isset($_SESSION['patient_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit;
}

$patient_id = $_SESSION['patient_id']; // Assuming the patient ID is stored in the session

// Get the POSTed data
$currentPassword = $_POST['currentPassword'];
$newPassword = $_POST['newPassword'];

// Fetch the current password hash from the database
$sql = "SELECT password FROM patient_registration WHERE id = ?";
$stmt = $connect->prepare($sql);
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$result = $stmt->get_result();
$patient = $result->fetch_assoc();

// Verify the current password
if (!password_verify($currentPassword, $patient['password'])) {
    echo json_encode(['success' => false, 'message' => 'Current password is incorrect.']);
    exit;
}

// Hash the new password
$newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);

// Update the password in the database
$sql = "UPDATE patient_registration SET password = ? WHERE id = ?";
$stmt = $connect->prepare($sql);
$stmt->bind_param("si", $newPasswordHash, $patient_id);
if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update password.']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
</head>
<body class="flex bg-gray-100">
    <div class="w-full p-8">
        <div class="container p-8 bg-white rounded-lg shadow-lg">
            <h1 class="mb-8 text-3xl font-bold text-gray-800">Change Password</h1>
            <form action="" method="POST" class="space-y-6">
                <div>
                    <label for="currentPassword" class="block mb-2 text-lg font-medium text-gray-700">Current Password</label>
                    <input type="password" name="currentPassword" id="currentPassword" placeholder="Enter your current password" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div>
                    <label for="newPassword" class="block mb-2 text-lg font-medium text-gray-700">New Password</label>
                    <input type="password" name="newPassword" id="newPassword" placeholder="Enter your new password" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <button type="submit" class="w-full p-3 text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:ring-4 focus:ring-blue-300">Change Password</button>
            </form>
        </div>
    </div>
</body>
</html>
