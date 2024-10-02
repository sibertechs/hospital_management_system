<?php
session_start();
require "./public/include/connect.php";

$patient_id = $_SESSION['patient_id'] ?? null;
$biodata = $appointments = $transactions = [];

if ($patient_id) {
    // Fetch biodata
    $patient_query = "SELECT * FROM patient_registration WHERE id = ?";
    $stmt = mysqli_prepare($connect, $patient_query);
    mysqli_stmt_bind_param($stmt, "i", $patient_id);
    mysqli_stmt_execute($stmt);
    $patient_result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($patient_result) == 0) {
        echo "<script>alert('Patient not found.'); window.location.href='login.php';</script>";
        exit;
    }

    $biodata = mysqli_fetch_assoc($patient_result);

    // Fetch booked appointments
    $appointments_query = "SELECT a.*, d.name AS doctor_name FROM appointments a
                           JOIN doctors d ON a.doctor_id = d.id
                           WHERE a.patient_id = ?";
    $stmt = mysqli_prepare($connect, $appointments_query);
    mysqli_stmt_bind_param($stmt, "i", $patient_id);
    mysqli_stmt_execute($stmt);
    $appointments_result = mysqli_stmt_get_result($stmt);
    $appointments = mysqli_fetch_all($appointments_result, MYSQLI_ASSOC);

    // Fetch transactions
    $transactions_query = "SELECT * FROM transactions WHERE patient_id = ?";
    $stmt = mysqli_prepare($connect, $transactions_query);
    mysqli_stmt_bind_param($stmt, "i", $patient_id);
    mysqli_stmt_execute($stmt);
    $transactions_result = mysqli_stmt_get_result($stmt);
    $transactions = mysqli_fetch_all($transactions_result, MYSQLI_ASSOC);
} else {
    echo "<script>alert('Patient ID is not set.'); window.location.href='patient_login.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }
        .bg-custom {
            background-color: #f3f4f6; /* Light gray background */
        }
        .card {
            background-color: #ffffff; /* White card background */
            border-radius: 0.5rem; /* Rounded corners */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); /* Soft shadow */
        }
        .btn-primary {
            background-color: #4f46e5; /* Indigo background */
            color: white;
        }
        .btn-primary:hover {
            background-color: #4338ca; /* Darker indigo on hover */
        }
        .table-header {
            background-color: #e5e7eb; /* Light gray for table header */
        }
        .table-row:hover {
            background-color: #f9fafb; /* Light hover effect */
        }
    </style>
    <script>
        function handleProfilePicChange(event) {
            const file = event.target.files[0];
            if (file) {
                const formData = new FormData();
                formData.append('profile_picture', file);
                formData.append('patient_id', <?php echo json_encode($patient_id); ?>);
                
                fetch('update_profile_picture.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('profilePic').src = data.new_image_url;
                        alert('Profile picture updated successfully.');
                    } else {
                        alert('Failed to update profile picture.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while updating the profile picture.');
                });
            }
        }

        function viewTransactionDetails(transactionId) {
            fetch('get_transaction_details.php?transaction_id=' + transactionId)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const details = data.transaction;
                        document.getElementById('transactionDetails').innerHTML = `
                            <p><strong>Date:</strong> ${details.transaction_date}</p>
                            <p><strong>Amount:</strong> ₵${details.amount}</p>
                            <p><strong>Type:</strong> ${details.type}</p>
                            <p><strong>Drug:</strong> ${details.drug_id}</p>
                            <p><strong>Price:</strong> ₵${details.drug_price}</p>
                            <p><strong>Description:</strong> ${details.description}</p>
                        `;
                        document.getElementById('transactionModal').style.display = 'block';
                    } else {
                        alert('Failed to load transaction details.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while loading transaction details.');
                });
        }

        function closeModal() {
            document.getElementById('transactionModal').style.display = 'none';
        }
    </script>


    <!-- Change Password Modal -->
    <script>
document.getElementById('changePasswordForm').addEventListener('submit', function(e) {
  e.preventDefault();

  const currentPassword = document.getElementById('currentPassword').value;
  const newPassword = document.getElementById('newPassword').value;
  const confirmNewPassword = document.getElementById('confirmNewPassword').value;

  if (newPassword !== confirmNewPassword) {
    alert('New passwords do not match.');
    return;
  }

  // Send the password change request via AJAX
  const xhr = new XMLHttpRequest();
  xhr.open('POST', 'change_patient_password.php', true); // Changed to change_patient_password.php
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xhr.onload = function() {
    if (this.status === 200) {
      const response = JSON.parse(this.responseText);
      if (response.success) {
        alert('Password changed successfully.');
        // Optionally, log out the user to re-login with the new password
        window.location.href = 'login.php';
      } else {
        alert(response.message);
      }
    }
  };

  xhr.send(`currentPassword=${currentPassword}&newPassword=${newPassword}`);
});

</script>
</head>
<body class="bg-custom">

<div class="grid grid-cols-1 gap-4 p-4 md:grid-cols-4">
    <!-- Sidebar -->
    <aside class="col-span-1 p-4 bg-white shadow-lg">
        <?php require "./public/include/sidebar_patient.php"; ?>
    </aside>

    <!-- Main Content -->
    <main class="col-span-3 p-6 mt-4 card">
        <h1 class="mb-4 text-3xl font-bold text-gray-800">Patient Dashboard</h1>


<section class="mb-6">
    <h2 class="mb-2 text-2xl font-semibold text-gray-700">Biodata</h2>
    <?php if ($biodata): ?>
        <div class="flex flex-col items-center md:flex-row md:items-start">
            <?php
            $profile_picture_path = 'uploads/' . htmlspecialchars($biodata['profile_picture'] ?? 'default-profile.png');
            if (!file_exists($profile_picture_path)) {
                $profile_picture_path = 'uploads/default-profile.png';
            }
            ?>
            <img id="profilePic" src="<?php echo $profile_picture_path; ?>" alt="Profile Picture" class="w-32 h-32 mb-4 border-2 border-gray-300 rounded-full shadow-lg md:w-40 md:h-40 md:mb-0 md:mr-6">
            <div class="flex flex-col">
                <p class="text-gray-600"><strong>Name:</strong> <?php echo htmlspecialchars($biodata['name'] ?? 'N/A'); ?></p>
                <p class="text-gray-600"><strong>Phone:</strong> <?php echo htmlspecialchars($biodata['phone'] ?? 'N/A'); ?></p>
                <p class="text-gray-600"><strong>Email:</strong> <?php echo htmlspecialchars($biodata['email'] ?? 'N/A'); ?></p>
                <p class="text-gray-600"><strong>Date of Birth:</strong> <?php echo htmlspecialchars($biodata['dob'] ?? 'N/A'); ?></p>
                <p class="text-gray-600"><strong>Country of Origin:</strong> <?php echo htmlspecialchars($biodata['country_of_origin'] ?? 'N/A'); ?></p>
                <p class="text-gray-600"><strong>Insurance Memb. ID No.:</strong> <?php echo htmlspecialchars($biodata['membership_id'] ?? 'N/A'); ?></p>
                <p class="text-gray-600"><strong>Date Issued:</strong> <?php echo htmlspecialchars($biodata['issued_date'] ?? 'N/A'); ?></p>
                <p class="text-gray-600"><strong>Expiry Date:</strong> <?php echo htmlspecialchars($biodata['expiry_date'] ?? 'N/A'); ?></p>
                <input type="file" id="profilePicInput" class="p-2 mt-2 border border-gray-300 rounded" accept="image/*" onchange="handleProfilePicChange(event)">
            </div>
        </div>
    <?php else: ?>
        <p>No biodata found for this patient.</p>
    <?php endif; ?>
</section>


        <!-- Appointments Section -->
        <section class="mb-6">
            <h2 class="mb-2 text-2xl font-semibold text-gray-700">Appointments</h2>
            <?php if ($appointments): ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border-collapse shadow-lg">
                        <thead>
                            <tr class="table-header">
                                <th class="px-4 py-2 border">Appointment ID</th>
                                <th class="px-4 py-2 border">Doctor</th>
                                <th class="px-4 py-2 border">Date</th>
                                <th class="px-4 py-2 border">Status</th>
                                <th class="px-4 py-2 border">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($appointments as $appointment): ?>
                                <tr class="table-row">
                                    <td class="px-4 py-2 border"><?php echo htmlspecialchars($appointment['id']); ?></td>
                                    <td class="px-4 py-2 border"><?php echo htmlspecialchars($appointment['doctor_name']); ?></td>
                                    <td class="px-4 py-2 border"><?php echo htmlspecialchars($appointment['appointment_date']); ?></td>
                                    <td class="px-4 py-2 border"><?php echo htmlspecialchars($appointment['status']); ?></td>
                                    <td class="px-4 py-2 border">
                                        <button onclick="cancelAppointment(<?php echo htmlspecialchars($appointment['id']); ?>)" class="text-red-500 hover:underline">Cancel</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p>No appointments found for this patient.</p>
            <?php endif; ?>
        </section>

        <!-- Transactions Section -->
        <section>
            <h2 class="mb-2 text-2xl font-semibold text-gray-700">Transactions</h2>
            <?php if ($transactions): ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border-collapse shadow-lg">
                        <thead>
                            <tr class="table-header">
                                <th class="px-4 py-2 border">Transaction ID</th>
                                <th class="px-4 py-2 border">Date</th>
                                <th class="px-4 py-2 border">Amount</th>
                                <th class="px-4 py-2 border">Type</th>
                                <th class="px-4 py-2 border">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($transactions as $transaction): ?>
                                <tr class="table-row">
                                    <td class="px-4 py-2 border"><?php echo htmlspecialchars($transaction['id']); ?></td>
                                    <td class="px-4 py-2 border"><?php echo htmlspecialchars($transaction['transaction_date']); ?></td>
                                    <td class="px-4 py-2 border">₵<?php echo htmlspecialchars($transaction['amount']); ?></td>
                                    <td class="px-4 py-2 border"><?php echo htmlspecialchars($transaction['type']); ?></td>
                                    <td class="px-4 py-2 border">
                                        <button onclick="viewTransactionDetails(<?php echo htmlspecialchars($transaction['id']); ?>)" class="text-blue-500 hover:underline">View</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p>No transactions found for this patient.</p>
            <?php endif; ?>
        </section>

        <div class="flex justify-between mt-6">
            <a href="patient_dashboard.php" class="px-4 py-2 transition duration-200 rounded btn-primary hover:bg-blue-600">
                Back to Patient Dashboard
            </a>
        </div>
    </main>
</div>

<!-- Transaction Details Modal -->
<div id="transactionModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50" style="display: none;">
    <div class="w-11/12 p-6 bg-white rounded-lg shadow-lg md:w-1/2">
        <h3 class="mb-4 text-2xl font-semibold">Transaction Details</h3>
        <div id="transactionDetails"></div>
        <button onclick="closeModal()" class="px-4 py-2 mt-4 text-white bg-blue-500 rounded hover:bg-blue-600">Close</button>
    </div>
</div>

<script>
    function cancelAppointment(appointmentId) {
        if (confirm('Are you sure you want to cancel this appointment?')) {
            window.location.href = 'cancel_appointment.php?appointment_id=' + appointmentId;
        }
    }
</script>



</body>
</html>

<?php
mysqli_close($connect);
?>
