<?php
require "./public/include/connect.php";
session_start(); 

// Handle form submission for adding a hospital
if(isset($_POST['submit'])) {
    $hospital_name = mysqli_real_escape_string($connect, $_POST['hospital_name']);
    $hospital_location = mysqli_real_escape_string($connect, $_POST['hospital_location']);

    // Insert doctor into the database
    $exe = mysqli_query($connect, "INSERT INTO hospitals (hospital_name, hospital_location) VALUES ('$hospital_name', '$hospital_location')");

    if($exe) {
        echo "<script>alert('Doctor added successfully!');</script>";
    } else {
        echo "<script>alert('Error adding doctor. Please try again.');</script>";
    }
}

// Fetch all hospitals
function fetchHospitals() {
    global $connect;
    $hospitals = [];
    $query = "SELECT * FROM hospitals"; // Ensure these are valid column names
    $result = mysqli_query($connect, $query);
    while($row = mysqli_fetch_assoc($result)) {
        $hospitals[] = $row;
    }
    return $hospitals;
}

$hospitals = fetchHospitals();
?>

<!DOCTYPE html>
<html lang="en">
<?php require "./public/include/head.php"; ?>
<body class="bg-gray-100">

    <!-- Include Header -->
    <?php require "./public/include/header.php"; ?>

    <div class="flex">
        <!-- Include Sidebar -->
        <?php require "./public/include/sidebar.php"; ?>

        <!-- Main Content -->
        <div class="flex-1 p-8">
            <div class="container mx-auto bg-white p-8 rounded-lg shadow-lg max-w-2xl">
                <h1 class="text-3xl font-bold text-center mb-8 text-gray-800">Manage Hospitals</h1>

                <!-- Add Hospital Form -->
                <form action="hospitals.php" method="POST" class="space-y-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <input type="text" name="hospital_name" placeholder="Hospital Name" required class="p-2 block w-full border border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div>
                            <input type="text" name="hospital_location" placeholder="Location" required class="p-2 block w-full border border-gray-300 rounded-md shadow-sm">
                        </div>
                    </div>
                    <div>
                        <input type="submit" name="submit" value="Add Hospital" class="w-full p-3 mt-6 bg-indigo-600 text-white font-bold rounded-md hover:bg-indigo-700 cursor-pointer">
                    </div>
                </form>

                <!-- List of Hospitals -->
                <h2 class="text-xl font-semibold mt-10 mb-4 text-gray-700">List of Hospitals</h2>
                <table class="table-auto w-full">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">Hospital Name</th>
                            <th class="px-4 py-2">Location</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($hospitals as $hospital): ?>
                        <tr>
                            <td class="border px-4 py-2"><?= $hospital['hospital_name']; ?></td> <!-- Ensure column name matches -->
                            <td class="border px-4 py-2"><?= $hospital['hospital_location']; ?></td> <!-- Ensure column name matches -->
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>
