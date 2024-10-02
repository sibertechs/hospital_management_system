<?php
session_start();
require "./public/include/connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patient_id = $_POST['patient_id'] ?? null;
    if (!$patient_id) {
        echo json_encode(['success' => false, 'message' => 'Patient ID is missing.']);
        exit;
    }

    if (isset($_FILES['profile_picture'])) {
        $file = $_FILES['profile_picture'];
        if ($file['error'] === UPLOAD_ERR_OK) {
            $upload_dir = 'uploads/';
            $file_name = basename($file['name']);
            $file_path = $upload_dir . $file_name;

            if (move_uploaded_file($file['tmp_name'], $file_path)) {
                $update_query = "UPDATE patient_registration SET profile_picture = ? WHERE id = ?";
                $stmt = mysqli_prepare($connect, $update_query);
                mysqli_stmt_bind_param($stmt, "si", $file_name, $patient_id);
                mysqli_stmt_execute($stmt);

                echo json_encode([
                    'success' => true,
                    'new_image_url' => $file_path
                ]);
            } else {
                echo json_encode(['success' => false, 'message' => 'File upload failed.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'No file uploaded or file error.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'No file uploaded.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}

mysqli_close($connect);
?>
