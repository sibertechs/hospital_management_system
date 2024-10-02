<?php
require "./public/include/connect.php";

if (isset($_GET['id'])) {
    $patientId = mysqli_real_escape_string($connect, $_GET['id']);

    // Fetch patient details by ID
    $query = "SELECT firstname, middlename, lastname, gender, dob, location, complain, conditions FROM patients WHERE id = $patientId";
    $result = mysqli_query($connect, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        echo "<p><strong>Name:</strong> " . htmlspecialchars($row['firstname']) . " " . htmlspecialchars($row['middlename']) . " " . htmlspecialchars($row['lastname']) . "</p>";
        echo "<p><strong>Date of Birth:</strong> " . htmlspecialchars($row['dob']) . "</p>";
        echo "<p><strong>Gender:</strong> " . htmlspecialchars($row['gender']) . "</p>";
        echo "<p><strong>Location:</strong> " . htmlspecialchars($row['location']) . "</p>";
        echo "<p><strong>Complaints:</strong> " . htmlspecialchars($row['complain']) . "</p>";
        echo "<p><strong>Conditions:</strong> " . htmlspecialchars($row['conditions']) . "</p>";
    } else {
        echo "<p>No records found for this patient.</p>";
    }
} else {
    echo "<p>Invalid request.</p>";
}
