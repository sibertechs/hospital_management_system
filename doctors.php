<?php
require "./public/include/connect.php";
session_start(); 

// Handle form submission for adding a doctor
if(isset($_POST['submit'])) {
    $doctor_name = mysqli_real_escape_string($connect, $_POST['doctor_name']);
    $doctor_phone = mysqli_real_escape_string($connect, $_POST['doctor_phone']);

    // Insert doctor into the database
    $exe = mysqli_query($connect, "INSERT INTO doctors (doctor_name, doctor_phone) VALUES ('$doctor_name', '$doctor_phone')");

    if($exe) {
        echo "<script>alert('Doctor added successfully!');</script>";
    } else {
        echo "<script>alert('Error adding doctor. Please try again.');</script>";
    }
}

// Fetch all doctors
function fetchDoctors() {
    global $connect;
    $doctors = [];
    $query = "SELECT * FROM doctors";
    $result = mysqli_query($connect, $query);
    while($row = mysqli_fetch_assoc($result)) {
        $doctors[] = $row;
    }
    return $doctors;
}

$doctors = fetchDoctors();
?>

<!DOCTYPE html>
<html lang="en">
<?php require "./public/include/head.php"; ?>
<body class="bg-gray-100">

    <!-- Sidebar -->
    <div class="flex">
    <?php require "./public/include/sidebar.php"; ?>

        <!-- Main Content -->
        <div class="w-4/5 p-8">
            <div class="container mx-auto bg-white p-8 rounded-lg shadow-lg max-w-2xl">
                <h1 class="text-3xl font-bold text-center mb-8 text-gray-800">Manage Doctors</h1>

                <!-- Add Doctor Form -->
                <form action="doctors.php" method="POST" class="space-y-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <input type="text" name="doctor_name" placeholder="Doctor's Name" required class="p-2 block w-full border border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div>
                            <input type="text" name="doctor_phone" placeholder="Doctor's Phone" required class="p-2 block w-full border border-gray-300 rounded-md shadow-sm">
                        </div>
                    </div>
                    <div>
                        <input type="submit" name="submit" value="Add Doctor" class="w-full p-3 mt-6 bg-indigo-600 text-white font-bold rounded-md hover:bg-indigo-700 cursor-pointer">
                    </div>
                </form>

                <!-- List of Doctors -->
                <h2 class="text-xl font-semibold mt-10 mb-4 text-gray-700">List of Doctors</h2>
                <table class="table-auto w-full">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">S/N</th>
                            <th class="px-4 py-2">Doctor's Name</th>
                            <th class="px-4 py-2">Doctor's Phone</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($doctors as $doctor): ?>
                        <tr>
                            <td class="border px-4 py-2"><?= $doctor['id']; ?></td>
                            <td class="border px-4 py-2"><?= $doctor['doctor_name']; ?></td>
                            <td class="border px-4 py-2"><?= $doctor['doctor_phone']; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>
