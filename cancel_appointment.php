<?php
session_start();
require "./public/include/connect.php";

if (isset($_GET['appointment_id'])) {
    $appointment_id = intval($_GET['appointment_id']);

    // Cancel the appointment
    $query = "DELETE FROM appointments WHERE id = ? AND patient_id = ?";
    $stmt = mysqli_prepare($connect, $query);
    mysqli_stmt_bind_param($stmt, "ii", $appointment_id, $_SESSION['patient_id']);
    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Appointment canceled successfully.'); window.location.href='patient_dashboard.php';</script>";
    } else {
        echo "<script>alert('Error canceling appointment.'); window.location.href='patient_dashboard.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request.'); window.location.href='patient_dashboard.php';</script>";
}

mysqli_close($connect);
?>