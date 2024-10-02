<?php
require "./public/include/connect.php";

session_start();

if(isset($_POST['submit'])){
    $p_name = mysqli_real_escape_string($connect, $_POST['name']);
    $p_illness = mysqli_real_escape_string($connect, $_POST['illness']);
    $p_contact = mysqli_real_escape_string($connect, $_POST['patient_contact']);
    $ref_doctor_name = mysqli_real_escape_string($connect, $_POST['ref_doctor_name']);
    $ref_hospital = mysqli_real_escape_string($connect, $_POST['ref_hospital']);
    $ref_doctor_contact = mysqli_real_escape_string($connect, $_POST['ref_doctor_contact']);
    $ref_hospital_location = mysqli_real_escape_string($connect, $_POST['ref_hospital_location']);
    $location_hosp_referred = mysqli_real_escape_string($connect, $_POST['location_hosp_referred']);
    $name_hosp_referred = mysqli_real_escape_string($connect, $_POST['name_hosp_referred']);

    $sql = "INSERT INTO patient_report 
            (name, illness, patient_contact, ref_doctor_name, ref_hospital, ref_doctor_contact, ref_hospital_location, location_hosp_referred, name_hosp_referred) 
            VALUES 
            ('$p_name', '$p_illness', '$p_contact', '$ref_doctor_name', '$ref_hospital', '$ref_doctor_contact', '$ref_hospital_location', '$location_hosp_referred', '$name_hosp_referred')";

    $exe = mysqli_query($connect, $sql);

    if($exe){
        echo "<script>alert('Record Saved Successfully');</script>";
        echo "<script>window.location.href='reports_table.php';</script>";
    }else{
        echo "<script>alert('Record Not Saved');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php require "./public/include/head.php"; ?>
<body class="h-screen font-sans login bg-cover">
    <?php require "./public/include/navbar.php"; ?>
    <div class="flex">
        <?php require "./public/include/sidebar.php"; ?>
        <div class="container mx-auto h-full flex flex-1 justify-center items-center">
            <div class="w-full max-w-lg">
                <div class="leading-loose">
                    <form class="max-w-xl m-4 p-10 bg-white rounded shadow-xl w-full" method="POST">
                        <p class="text-gray-800 text-xxl text-center font-bold">Patient Report Form</p>
                        <div class="">
                            <input class="w-full px-5 py-2 text-gray-700 bg-gray-200 rounded outline-none" id="cus_name" name="name" type="text" required="" placeholder="Patient Name" aria-label="Name">
                        </div>
                        <div class="mt-2">
                            <input class="w-full px-5 py-2 text-gray-700 bg-gray-200 rounded outline-none" id="illness" name="illness" type="text" placeholder="Illness" required="" aria-label="Illness">
                        </div>
                        <div class="mt-2">
                            <input class="w-full px-5 py-2 text-gray-700 bg-gray-200 rounded outline-none" id="patient_contact" name="patient_contact" type="text" required="" placeholder="Patient Contact" aria-label="Patient Contact">
                        </div>
                        <div class="mt-2">
                            <input class="w-full px-5 py-2 text-gray-700 bg-gray-200 rounded outline-none" id="ref_doctor_name" name="ref_doctor_name" type="text" required="" placeholder="Referral Doctor's Name" aria-label="Referral Doctor's Name">
                        </div>
                        <div class="mt-2">
                            <input class="w-full px-2 py-2 text-gray-700 bg-gray-200 rounded outline-none" id="ref_hospital" name="ref_hospital" type="text" required="" placeholder="Referral Hospital" aria-label="Referral Hospital">
                        </div>
                        <div class="mt-2">
                            <input class="w-full px-2 py-2 text-gray-700 bg-gray-200 rounded outline-none" id="ref_doctor_contact" name="ref_doctor_contact" type="text" required="" placeholder="Referral Doctor's Contact" aria-label="Referral Doctor Contact">
                        </div>
                        <div class="mt-2">
                            <input class="w-full px-2 py-2 text-gray-700 bg-gray-200 rounded outline-none" id="ref_hospital_location" name="ref_hospital_location" type="text" required="" placeholder="Referral Hospital's Location" aria-label="Referral Hospital's Location">
                        </div>
                        <div class="mt-2">
                            <input class="w-full px-2 py-2 text-gray-700 bg-gray-200 rounded outline-none" id="name_hosp_referred" name="name_hosp_referred" type="text" required="" placeholder="Name of Referred Hospital" aria-label="Name of Referred Hospital">
                        </div>
                        <div class="mt-2">
                            <input class="w-full px-2 py-2 text-gray-700 bg-gray-200 rounded outline-none" id="location_hosp_referred" name="location_hosp_referred" type="text" required="" placeholder="Location of the Referred Hospital" aria-label="Location of the Referred Hospital">
                        </div>
                        <div class="mt-4">
                            <button class="px-4 py-1 text-white font-bold text-lg tracking-wider bg-gray-900 rounded w-full" type="submit" name="submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
            <!--Footer-->
      <?php require "./public/include/footer.php" ?>
        <!--/footer-->
    </div>
</body>
</html>
