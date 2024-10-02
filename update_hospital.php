<?php
// Include your database connection file
include('./public/include/connect.php');

// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the posted data
    $id = $_POST['id'];
    $name = mysqli_real_escape_string($connect, $_POST['name']);
    $address = mysqli_real_escape_string($connect, $_POST['address']);
    $phone = mysqli_real_escape_string($connect, $_POST['phone']);

    // Prepare and execute the update query
    $sql = "UPDATE hospitals SET name = ?, address = ?, phone = ? WHERE id = ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("sssi", $name, $address, $phone, $id);

    if ($stmt->execute()) {
        // Return success response
        echo json_encode(["success" => true]);
    } else {
        // Return failure response
        echo json_encode(["success" => false]);
    }

    $stmt->close();
}

$connect->close();
?>