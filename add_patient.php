<?php
require "./public/include/connect.php";

session_start();

if (isset($_POST['submit'])) {
    $firstname = mysqli_real_escape_string($connect, $_POST['firstname']);
    $middlename = mysqli_real_escape_string($connect, $_POST['middlename']);
    $lastname = mysqli_real_escape_string($connect, $_POST['lastname']);
    $gender = mysqli_real_escape_string($connect, $_POST['gender']);
    $dob = mysqli_real_escape_string($connect, $_POST['dob']);
    $location = mysqli_real_escape_string($connect, $_POST['location']);
    $complain = mysqli_real_escape_string($connect, $_POST['complain']);
    $conditions = mysqli_real_escape_string($connect, $_POST['conditions']);

    // Check if patient already exists
    $query = "SELECT id, visits FROM patients WHERE firstname='$firstname' AND middlename='$middlename' AND lastname='$lastname' AND dob='$dob'";
    $result = mysqli_query($connect, $query);

    if (mysqli_num_rows($result) > 0) {
        // Patient exists, update the visits count
        $row = mysqli_fetch_assoc($result);
        $new_visits = $row['visits'] + 1;

        $update_query = "UPDATE patients SET visits='$new_visits', gender='$gender', location='$location', complain='$complain', conditions='$conditions' WHERE id='" . $row['id'] . "'";
        $exe = mysqli_query($connect, $update_query);

        if ($exe) {
            echo "<script>alert('Record Updated Successfully');</script>";
            echo "<script>window.location.href='patients.php';</script>";
        } else {
            echo "<script>alert('Record Not Updated');</script>";
        }
    } else {
        // New patient, insert the record
        $insert_query = "INSERT INTO patients (firstname, middlename, lastname, gender, dob, location, complain, conditions, visits) 
                         VALUES ('$firstname', '$middlename', '$lastname', '$gender', '$dob', '$location', '$complain', '$conditions', 1)";
        $exe = mysqli_query($connect, $insert_query);

        if ($exe) {
            echo "<script>alert('Record Saved Successfully');</script>";
            echo "<script>window.location.href='patients.php';</script>";
        } else {
            echo "<script>alert('Record Not Saved');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php
require "./public/include/head.php";
?>
<body class="h-screen font-sans login bg-cover">

     <!--Header Section Starts Here-->
     <?php
     require "./public/include/navbar.php";
     ?>
     <!--/Header-->

<div class="flex">
    <?php
    require "./public/include/sidebar.php";
    ?>
    <div class="container mx-auto h-full flex flex-1 justify-center items-center">
        <div class="w-full max-w-lg">
            <div class="leading-loose">
                <form class="max-w-xl m-4 p-10 bg-white rounded shadow-xl w-full" method="POST">
                    <p class="text-gray-800 text-xxl text-center font-bold">Add Patient</p>
                    <div class="">
                        <input class="w-full px-5 py-2 text-gray-700 bg-gray-200 rounded outline-none" name="firstname" type="text" required="" placeholder="First Name" aria-label="Name">
                    </div>
                    <div class="mt-2">
                        <input class="w-full px-5 py-2 text-gray-700 bg-gray-200 rounded outline-none" name="middlename" type="text" placeholder="Middle Name (Optional)" aria-label="Middle Name">
                    </div>
                    <div class="mt-2">
                        <input class="w-full px-5 py-2 text-gray-700 bg-gray-200 rounded outline-none" name="lastname" type="text" required="" placeholder="Last Name" aria-label="Last Name">
                    </div>
                    <div class="mt-2">
                        <select class="block text-sm text-gray-600 w-full px-5 py-2 outline-none border" name="gender">
                            <option value="" class="w-full text-gray-700 bg-gray-200 border rounded">Select Gender</option>
                            <option value="Male" class="w-full text-gray-700 bg-gray-200 rounded">Male</option>
                            <option value="Female" class="w-full outline-none text-gray-700 bg-gray-200 rounded">Female</option>
                        </select>
                    </div>
                    <div class="mt-2">
                        <input class="w-full px-5 py-2 text-gray-700 bg-gray-200 rounded outline-none" name="dob" type="date" required="" placeholder="DOB" aria-label="dob">
                    </div>
                    <div class="mt-2">
                        <input class="w-full px-2 py-2 text-gray-700 bg-gray-200 rounded outline-none" name="location" type="text" required="" placeholder="Location" aria-label="Location">
                    </div>
                    <div class="mt-2">                              
                       <textarea class="block text-sm text-gray-600 w-full px-5 py-2 outline-none border" name="complain" placeholder="Complain" required="" cols="" rows="3"></textarea>
                    </div>
                    <div class="mt-2">
                        <input class="w-full px-2 py-2 text-gray-700 bg-gray-200 rounded outline-none" name="conditions" type="text" required="" placeholder="Condition" aria-label="Condition">
                    </div>

                    <div class="mt-4">
                        <button class="px-4 py-1 text-white font-bold text-lg tracking-wider bg-gray-900 rounded w-full" type="submit" name="submit">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

 <!--Footer-->
 <?php require "./public/include/footer.php"; ?>
 <!--/footer-->
<script src="main.js"></script>
<script scr="all.js"></script>
</body>
</html>
