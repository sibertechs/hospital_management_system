<?php
require "./public/include/connect.php";

session_start();

if(isset($_POST['submit'])){
    $updateid = mysqli_real_escape_string($connect, $_POST['updateid']);
    $p_name = mysqli_real_escape_string($connect, $_POST['name']);
    $p_illness = mysqli_real_escape_string($connect, $_POST['illness']);
    $p_contact = mysqli_real_escape_string($connect, $_POST['patient_contact']);
    $ref_doctor_name = mysqli_real_escape_string($connect, $_POST['ref_doctor_name']);
    $ref_hospital = mysqli_real_escape_string($connect, $_POST['ref_hospital']);
    $ref_doctor_contact = mysqli_real_escape_string($connect, $_POST['ref_doctor_contact']);
    $ref_hospital_location = mysqli_real_escape_string($connect, $_POST['ref_hospital_location']);
    $location_hosp_referred = mysqli_real_escape_string($connect, $_POST['location_hosp_referred']);
    $name_hosp_referred = mysqli_real_escape_string($connect, $_POST['name_hosp_referred']);

    $exe = mysqli_query($connect, 
        "UPDATE patient_report SET 
            name = '$p_name', 
            illness = '$p_illness', 
            patient_contact = '$p_contact', 
            ref_doctor_name = '$ref_doctor_name', 
            ref_hospital = '$ref_hospital', 
            ref_doctor_contact = '$ref_doctor_contact', 
            ref_hospital_location = '$ref_hospital_location', 
            name_hosp_referred = '$name_hosp_referred', 
            location_hosp_referred = '$location_hosp_referred' 
        WHERE id = '$updateid'"
    );

    if($exe){
        echo "<script>alert('Record Updated Successfully');</script>";
        echo "<script>window.location.href='reports_table.php';</script>";
    } else {
        echo "<script>alert('Record Not Updated');</script>";
    }
}

if(isset($_GET['updateid'])){
    $id = mysqli_real_escape_string($connect, $_GET['updateid']);
    $data = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM patient_report WHERE id = '$id'"));
}
?>

<!DOCTYPE html>
<html lang="en">
<?php
    require "./public/include/head.php";
?>
<body class="h-screen font-sans login bg-cover">
<div class="container mx-auto h-full flex flex-1 justify-center items-center">
    <div class="w-full max-w-lg">
        <div class="leading-loose">
            <form class="max-w-xl m-4 p-10 bg-white rounded shadow-xl w-full" method="POST">
                <p class="text-gray-800 text-xxl text-center font-bold">Update Patient Report Form</p>
                <input type="hidden" id="updateid" name="updateid" value="<?php echo $data['id']; ?>" />
                <div>
                    <input value="<?php echo $data['name']; ?>" class="w-full px-5 py-2 text-gray-700 bg-gray-200 rounded outline-none" id="cus_name" name="name" type="text" required="" placeholder="Patient Name" aria-label="Name">
                </div>
                <div class="mt-2">
                    <input value="<?php echo $data['illness']; ?>" class="w-full px-5 py-2 text-gray-700 bg-gray-200 rounded outline-none" id="illness" name="illness" type="text" placeholder="Illness" required="" aria-label="Illness">
                </div>
                <div class="mt-2">
                    <input value="<?php echo $data['patient_contact']; ?>" class="w-full px-5 py-2 text-gray-700 bg-gray-200 rounded outline-none" id="patient_contact" name="patient_contact" type="text" required="" placeholder="Patient Contact" aria-label="Patient Contact">
                </div>
                <div class="mt-2">
                    <input value="<?php echo $data['ref_doctor_name']; ?>" class="w-full px-5 py-2 text-gray-700 bg-gray-200 rounded outline-none" id="ref_doctor_name" name="ref_doctor_name" type="text" required="" placeholder="Referral Doctor's Name" aria-label="Referral Doctor's Name">
                </div>
                <div class="mt-2">
                    <input value="<?php echo $data['ref_hospital']; ?>" class="w-full px-2 py-2 text-gray-700 bg-gray-200 rounded outline-none" id="ref_hospital" name="ref_hospital" type="text" required="" placeholder="Referral Hospital" aria-label="Referral Hospital">
                </div>
                <div class="mt-2">
                    <input value="<?php echo $data['ref_doctor_contact']; ?>" class="w-full px-2 py-2 text-gray-700 bg-gray-200 rounded outline-none" id="ref_doctor_contact" name="ref_doctor_contact" type="text" required="" placeholder="Referral Doctor's Contact" aria-label="Referral Doctor Contact">
                </div>
                <div class="mt-2">
                    <input value="<?php echo $data['ref_hospital_location']; ?>" class="w-full px-2 py-2 text-gray-700 bg-gray-200 rounded outline-none" id="ref_hospital_location" name="ref_hospital_location" type="text" required="" placeholder="Referral Hospital's Location" aria-label="Referral Hospital's Location">
                </div>
                <div class="mt-2">
                    <input value="<?php echo $data['name_hosp_referred']; ?>" class="w-full px-2 py-2 text-gray-700 bg-gray-200 rounded outline-none" id="name_hosp_referred" name="name_hosp_referred" type="text" required="" placeholder="Name of Referred Hospital" aria-label="Name of Referred Hospital">
                </div>
                <div class="mt-2">
                    <input value="<?php echo $data['location_hosp_referred']; ?>" class="w-full px-2 py-2 text-gray-700 bg-gray-200 rounded outline-none" id="location_hosp_referred" name="location_hosp_referred" type="text" required="" placeholder="Location of the referred Hospital" aria-label="Location of the referred Hospital">
                </div>
                <div class="mt-4">
                    <button class="px-4 py-1 text-white font-bold text-lg tracking-wider bg-gray-900 rounded w-full" type="submit" name="submit">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
 <!--Footer-->
 <?php require "./public/include/footer.php" ?>
        <!--/footer-->
</body>
</html>
