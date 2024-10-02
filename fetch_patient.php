<?php
require "./public/include/connect.php";

if (isset($_POST['patient_id'])) {
    $patient_id = mysqli_real_escape_string($connect, $_POST['patient_id']);

    // Query to fetch patient name
    $query = "SELECT name FROM patient_registration WHERE id = '$patient_id'";
    $result = mysqli_query($connect, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        echo $row['name'];  // Return the patient's name
    } else {
        echo 'Patient not found';
    }
}
?>
