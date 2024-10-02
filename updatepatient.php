<?php
    require "./public/include/connect.php";
    session_start();

    // Check if the form is submitted
    if (isset($_POST['submit'])) {
        // Retrieve and sanitize form data
        $id = mysqli_real_escape_string($connect, $_POST['updateid']);
        $firstname = mysqli_real_escape_string($connect, $_POST['firstname']);
        $middlename = mysqli_real_escape_string($connect, $_POST['middlename']);
        $lastname = mysqli_real_escape_string($connect, $_POST['lastname']);
        $gender = mysqli_real_escape_string($connect, $_POST['gender']);
        $dob = mysqli_real_escape_string($connect, $_POST['dob']);
        $location = mysqli_real_escape_string($connect, $_POST['location']);
        $complain = mysqli_real_escape_string($connect, $_POST['complain']);
        $conditions = mysqli_real_escape_string($connect, $_POST['conditions']);

        // Update the record using prepared statements
        $stmt = $connect->prepare("UPDATE patients SET firstname=?, middlename=?, lastname=?, gender=?, dob=?, location=?, complain=?, conditions=? WHERE id=?");
        $stmt->bind_param("ssssssssi", $firstname, $middlename, $lastname, $gender, $dob, $location, $complain, $conditions, $id);

        if ($stmt->execute()) {
            echo "<script>alert('Record Updated Successfully');</script>";
            echo "<script>window.location.href='patients.php';</script>";
        } else {
            echo "<script>alert('Record Not Updated');</script>";
        }
        $stmt->close();
    }

    // Retrieve patient data for the update form
    if (isset($_GET['updateid'])) {
        $id = mysqli_real_escape_string($connect, $_GET['updateid']);
        $result = $connect->query("SELECT * FROM patients WHERE id='$id'");

        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
        } else {
            echo "<script>alert('No patient found with the provided ID.');</script>";
            echo "<script>window.location.href='patients.php';</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<?php require "./public/include/head.php"; ?>
<body class="h-screen font-sans login bg-cover">
    <div class="container mx-auto h-full flex flex-1 justify-center items-center">
        <div class="w-full max-w-lg">
            <div class="leading-loose">
                <form class="max-w-xl m-4 p-10 bg-white rounded shadow-xl w-full" method="POST">
                    <p class="text-gray-800 text-xxl text-center font-bold">Update Patient</p>

                    <input type="hidden" name="updateid" value="<?php echo htmlspecialchars($data['id']); ?>" required>

                    <div class="mt-2">
                        <input class="w-full px-5 py-2 text-gray-700 bg-gray-200 rounded outline-none" name="firstname" type="text" value="<?php echo htmlspecialchars($data['firstname']); ?>" required placeholder="First Name">
                    </div>
                    <div class="mt-2">
                        <input class="w-full px-5 py-2 text-gray-700 bg-gray-200 rounded outline-none" name="middlename" type="text" value="<?php echo htmlspecialchars($data['middlename']); ?>" placeholder="Middle Name (Optional)">
                    </div>
                    <div class="mt-2">
                        <input class="w-full px-5 py-2 text-gray-700 bg-gray-200 rounded outline-none" name="lastname" type="text" value="<?php echo htmlspecialchars($data['lastname']); ?>" required placeholder="Last Name">
                    </div>
                    <div class="mt-2">
                        <select class="block text-sm text-gray-600 w-full px-5 py-2 outline-none border" name="gender" required>
                            <option value="">Select Gender</option>
                            <option value="Male" <?php if ($data['gender'] == 'Male') echo 'selected'; ?>>Male</option>
                            <option value="Female" <?php if ($data['gender'] == 'Female') echo 'selected'; ?>>Female</option>
                        </select>
                    </div>
                    <div class="mt-2">
                        <input class="w-full px-5 py-2 text-gray-700 bg-gray-200 rounded outline-none" name="dob" type="date" value="<?php echo htmlspecialchars($data['dob']); ?>" required placeholder="DOB">
                    </div>
                    <div class="mt-2">
                        <input class="w-full px-2 py-2 text-gray-700 bg-gray-200 rounded outline-none" name="location" type="text" value="<?php echo htmlspecialchars($data['location']); ?>" required placeholder="Location">
                    </div>
                    <div class="mt-2">
                        <textarea class="block text-sm text-gray-600 w-full px-5 py-2 outline-none border" name="complain" required cols="30" rows="3" placeholder="Complain"><?php echo htmlspecialchars($data['complain']); ?></textarea>
                    </div>
                    <div class="mt-2">
                        <input class="w-full px-2 py-2 text-gray-700 bg-gray-200 rounded outline-none" name="conditions" type="text" value="<?php echo htmlspecialchars($data['conditions']); ?>" required placeholder="Condition">
                    </div>
                    <div class="mt-4">
                        <button class="px-4 py-1 text-white font-bold text-lg tracking-wider bg-gray-900 rounded w-full" type="submit" name="submit">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--Footer-->
    <?php require "./public/include/footer.php"; ?>
    <!--/footer-->
</body>
</html>
