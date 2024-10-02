<?php
require "./public/include/connect.php";
session_start();

if(isset($_POST['submit'])){
    $drug_name = mysqli_real_escape_string($connect, $_POST['drug_name']);
    $drug_type = mysqli_real_escape_string($connect, $_POST['drug_type']);
    $illness = mysqli_real_escape_string($connect, $_POST['illness']);
    $dossage = mysqli_real_escape_string($connect, $_POST['dossage']);
    $expiry_date = mysqli_real_escape_string($connect, $_POST['expiry_date']);

    $exe = mysqli_query($connect, "INSERT INTO drugs (drug_name, drug_type, illness, dossage, expiry_date) VALUES('$drug_name', '$drug_type', '$illness', '$dossage', '$expiry_date')");

    if($exe){
        echo "<script>alert('Record Saved Successfully');</script>";
        echo "<script>window.location.href='drugs.php';</script>";
    } else {
        echo "<script>alert('Record Not Saved');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php require "./public/include/head.php"; ?>
<body class="h-screen font-sans login bg-cover flex flex-col">
    <?php require "./public/include/navbar.php"; ?>

<div class="flex flex-1">
    <?php require "./public/include/sidebar.php"; ?>
    <div class="container mx-auto h-full flex flex-1 justify-center items-center">
        <div class="w-full max-w-lg">
            <div class="leading-loose">
                <form class="max-w-xl m-4 p-10 bg-white rounded shadow-xl w-full" method="POST">
                    <p class="text-gray-800 text-xxl text-center font-bold">Add Drug</p>

                    <div class="mt-2">
                        <?php require "./public/include/all_drugs.php"; ?>
                    </div>
                    <div class="mt-2">
                        <?php require "./public/include/drugs_illness.php"; ?>
                    </div>
                    <div class="mt-2">
                        <input type="text" name="dossage" class="block w-full px-5 py-2 text-sm text-gray-600 border outline-none rounded" placeholder="Dosage" required>
                    </div>
                    <div class="mt-2">
                        <input type="date" name="expiry_date" class="block w-full px-5 py-2 text-sm text-gray-600 border outline-none rounded" required>
                    </div>
                    <div class="mt-4">
                        <button type="submit" name="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<?php require "./public/include/footer.php"; ?>
<!--/Footer-->

<script src="./main.js"></script>
</body>
</html>
