<?php
// Include your database connection file
include('./public/include/connect.php');

// Initialize variables for the form fields
$name = $address = $phone = '';
$errors = [];

// Process the form when it is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate the input
    $name = trim($_POST['name']);
    $address = trim($_POST['address']);
    $phone = trim($_POST['phone']);

    // Validation
    if (empty($name)) {
        $errors['name'] = 'Hospital name is required.';
    }

    if (empty($address)) {
        $errors['address'] = 'Hospital address is required.';
    }

    if (empty($phone)) {
        $errors['phone'] = 'Phone number is required.';
    } elseif (!preg_match("/^[0-9]{10}$/", $phone)) {
        $errors['phone'] = 'Phone number must be 10 digits.';
    }

    // If no errors, check for duplicates
    if (empty($errors)) {
        $checkSql = "SELECT * FROM hospitals WHERE name = ? AND address = ? AND phone = ?";
        $checkStmt = $connect->prepare($checkSql);
        $checkStmt->bind_param("sss", $name, $address, $phone);
        $checkStmt->execute();
        $result = $checkStmt->get_result();

        if ($result->num_rows > 0) {
            $errors['duplicate'] = 'This hospital already exists in the database.';
        } else {
            // If no duplicates, insert the data into the database
            $sql = "INSERT INTO hospitals (name, address, phone, created_at) VALUES (?, ?, ?, NOW())";
            $stmt = $connect->prepare($sql);
            $stmt->bind_param("sss", $name, $address, $phone);

            if ($stmt->execute()) {
                // Success message
                $success_message = "Hospital added successfully!";
                // Reset form fields
                $name = $address = $phone = '';
            } else {
                // Error message
                $errors['db'] = "Failed to add hospital. Please try again.";
            }

            $stmt->close();
        }
        $checkStmt->close();
    }
}

// Fetch all unique hospitals from the database
$hospitalsQuery = "SELECT DISTINCT * FROM hospitals ORDER BY name ASC";
$hospitalsResult = mysqli_query($connect, $hospitalsQuery);

$connect->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Hospital</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script>
        function openEditModal(id, name, address, phone) {
            document.getElementById('editHospitalId').value = id;
            document.getElementById('editName').value = name;
            document.getElementById('editAddress').value = address;
            document.getElementById('editPhone').value = phone;
            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        function updateHospital(event) {
            event.preventDefault(); // Prevent form submission

            const id = document.getElementById('editHospitalId').value;
            const name = document.getElementById('editName').value;
            const address = document.getElementById('editAddress').value;
            const phone = document.getElementById('editPhone').value;

            // AJAX request to update the hospital
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "update_hospital.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Update the table row with the new data
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        const row = document.getElementById(`hospital-${id}`);
                        row.cells[1].innerText = name; // Update name
                        row.cells[2].innerText = address; // Update address
                        row.cells[3].innerText = phone; // Update phone
                        closeEditModal(); // Close the modal
                    } else {
                        alert("Failed to update hospital. Please try again.");
                    }
                }
            };
            xhr.send(`id=${id}&name=${encodeURIComponent(name)}&address=${encodeURIComponent(address)}&phone=${encodeURIComponent(phone)}`);
        }

        function openViewModal(id, name, address, phone, createdAt) {
            document.getElementById('viewHospitalName').innerText = name;
            document.getElementById('viewHospitalAddress').innerText = address;
            document.getElementById('viewHospitalPhone').innerText = phone;
            document.getElementById('viewHospitalCreatedAt').innerText = createdAt;
            document.getElementById('viewModal').classList.remove('hidden');
        }

        function closeViewModal() {
            document.getElementById('viewModal').classList.add('hidden');
        }
    </script>
</head>
<body class="bg-gray-100">
    <div class="flex">
        <!-- Sidebar -->
        <?php require './public/include/sidebar_admin.php'; ?>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            <h1 class="text-3xl font-bold mb-8">Add New Hospital</h1>

            <!-- Success message -->
            <?php if (isset($success_message)): ?>
                <div class="bg-green-100 text-green-800 p-4 rounded mb-6">
                    <?php echo $success_message; ?>
                </div>
            <?php endif; ?>

            <!-- Display Errors -->
            <?php if (!empty($errors)): ?>
                <div class="bg-red-100 text-red-800 p-4 rounded mb-6">
                    <?php foreach ($errors as $error): ?>
                        <p><?php echo $error; ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Form to Add New Hospital -->
            <form action="add_hospital.php" method="POST" class="bg-white p-6 shadow-md rounded mb-8">
                <div class="mb-4">
                    <label for="name" class="block text-gray-700">Hospital Name</label>
                    <input type="text" name="name" id="name" class="border-b border-gray-300 p-2 w-full outline-none" required>
                </div>
                <div class="mb-4">
                    <label for="address" class="block text-gray-700">Address</label>
                    <textarea name="address" id="address" class="border border-gray-300 p-2 w-full outline-none" rows="3" placeholder="Enter hospital address"><?php echo htmlspecialchars($address); ?></textarea>
                </div>
                <div class="mb-4">
                    <label for="phone" class="block text-gray-700">Phone</label>
                    <input type="text" name="phone" id="phone" class="border-b border-gray-300 p-2 w-full outline-none" value="<?php echo htmlspecialchars($phone); ?>">
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Add Hospital</button>
            </form>

            <!-- Hospitals Table -->
            <h2 class="text-2xl mb-4">Hospitals List</h2>
            <table class="table-auto w-full bg-white shadow-md rounded">
                <thead>
                    <tr class="bg-gray-200 text-left">
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Address</th>
                        <th class="px-4 py-2">Phone</th>
                        <th class="px-4 py-2">Created At</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($hospital = mysqli_fetch_assoc($hospitalsResult)) : ?>
                        <tr id="hospital-<?php echo htmlspecialchars($hospital['id']); ?>">
                            <td class="border px-4 py-2"><?php echo htmlspecialchars($hospital['id']); ?></td>
                            <td class="border px-4 py-2"><?php echo htmlspecialchars($hospital['name']); ?></td>
                            <td class="border px-4 py-2"><?php echo htmlspecialchars($hospital['address']); ?></td>
                            <td class="border px-4 py-2"><?php echo htmlspecialchars($hospital['phone']); ?></td>
                            <td class="border px-4 py-2"><?php echo htmlspecialchars($hospital['created_at']); ?></td>
                            <td class="border px-4 py-2">
                                <button onclick="openEditModal(<?php echo htmlspecialchars($hospital['id']); ?>, '<?php echo htmlspecialchars($hospital['name']); ?>', '<?php echo htmlspecialchars($hospital['address']); ?>', '<?php echo htmlspecialchars($hospital['phone']); ?>')" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</button>
                                <a href="delete_hospital.php?id=<?php echo $hospital['id']; ?>" class="bg-red-500 text-white px-2 py-1 rounded">Delete</a>
                                <button onclick="openViewModal(<?php echo htmlspecialchars($hospital['id']); ?>, '<?php echo htmlspecialchars($hospital['name']); ?>', '<?php echo htmlspecialchars($hospital['address']); ?>', '<?php echo htmlspecialchars($hospital['phone']); ?>', '<?php echo htmlspecialchars($hospital['created_at']); ?>')" class="bg-blue-500 text-white px-2 py-1 rounded">View</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </main>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded p-6 w-full max-w-md">
            <h2 class="text-xl font-bold mb-4">Edit Hospital</h2>
            <form onsubmit="updateHospital(event)" id="editForm">
                <input type="hidden" name="id" id="editHospitalId">
                <div class="mb-4">
                    <label for="editName" class="block text-gray-700">Hospital Name</label>
                    <input type="text" name="name" id="editName" class="border-b border-gray-300 p-2 w-full outline-none" required>
                </div>
                <div class="mb-4">
                    <label for="editAddress" class="block text-gray-700">Address</label>
                    <textarea name="address" id="editAddress" class="border border-gray-300 p-2 w-full outline-none" rows="3" required></textarea>
                </div>
                <div class="mb-4">
                    <label for="editPhone" class="block text-gray-700">Phone</label>
                    <input type="text" name="phone" id="editPhone" class="border-b border-gray-300 p-2 w-full outline-none" required>
                </div>
                <div class="flex justify-between">
                    <button type="button" onclick="closeEditModal()" class="bg-gray-300 text-black px-4 py-2 rounded">Cancel</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- View Modal -->
    <div id="viewModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded p-6 w-full max-w-md">
            <h2 class="text-xl font-bold mb-4">Hospital Details</h2>
            <div class="mb-4">
                <p class="font-bold">Name:</p>
                <p id="viewHospitalName"></p>
            </div>
            <div class="mb-4">
                <p class="font-bold">Address:</p>
                <p id="viewHospitalAddress"></p>
            </div>
            <div class="mb-4">
                <p class="font-bold">Phone:</p>
                <p id="viewHospitalPhone"></p>
            </div>
            <div class="mb-4">
                <p class="font-bold">Created At:</p>
                <p id="viewHospitalCreatedAt"></p>
            </div>
            <div class="flex justify-end">
                <button type="button" onclick="closeViewModal()" class="bg-gray-300 text-black px-4 py-2 rounded">Close</button>
            </div>
        </div>
    </div>

    <script>
    function openEditModal(id, name, address, phone) {
            // Populate the form with the hospital's current data
            document.getElementById('editHospitalId').value = id;
            document.getElementById('editName').value = name;
            document.getElementById('editAddress').value = address;
            document.getElementById('editPhone').value = phone;
            // Display the modal
            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeEditModal() {
            // Hide the edit modal
            document.getElementById('editModal').classList.add('hidden');
        }

        function updateHospital(event) {
            event.preventDefault(); // Prevent default form submission

            // Collect form data
            const id = document.getElementById('editHospitalId').value;
            const name = document.getElementById('editName').value;
            const address = document.getElementById('editAddress').value;
            const phone = document.getElementById('editPhone').value;

            // Perform validation or show alerts here if needed
            if (!name || !address || !phone) {
                alert("All fields are required!");
                return;
            }

            // Perform AJAX request to update the hospital
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'update_hospital.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        // Update the table row with the new data
                        const row = document.getElementById(`hospital-${id}`);
                        row.cells[1].innerText = name; // Update name
                        row.cells[2].innerText = address; // Update address
                        row.cells[3].innerText = phone; // Update phone
                        closeEditModal(); // Close the modal
                    } else {
                        alert("Failed to update hospital. Please try again.");
                    }
                }
            };
            // Send data to the server
            xhr.send(`id=${id}&name=${encodeURIComponent(name)}&address=${encodeURIComponent(address)}&phone=${encodeURIComponent(phone)}`);
        }

        function openViewModal(id, name, address, phone, createdAt) {
            // Populate the modal with hospital data
            document.getElementById('viewHospitalName').innerText = name;
            document.getElementById('viewHospitalAddress').innerText = address;
            document.getElementById('viewHospitalPhone').innerText = phone;
            document.getElementById('viewHospitalCreatedAt').innerText = createdAt;
            // Display the view modal
            document.getElementById('viewModal').classList.remove('hidden');
        }

        function closeViewModal() {
            // Hide the view modal
            document.getElementById('viewModal').classList.add('hidden');
        }
    </script>
</body>
</html>
