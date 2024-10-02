<?php
    require "./public/include/connect.php";

    session_start();

    if(isset($_POST['submit'])){
        $id = $_POST['updateid'];
        $drug_name = mysqli_real_escape_string($connect, $_POST['drug_name']);
        $drug_type = mysqli_real_escape_string($connect, $_POST['drug_type']);
        $illness = mysqli_real_escape_string($connect, $_POST['illness']);
        $dossage = mysqli_real_escape_string($connect, $_POST['dossage']);
        $expiry_date = mysqli_real_escape_string($connect, $_POST['expiry_date']);
       


      
            $exe = mysqli_query($connect, "UPDATE  drugs SET drug_name = '$drug_name', drug_type = '$drug_type', illness =  '$illness', dossage =  '$dossage', expiry_date =  '$expiry_date' WHERE id = '$id'");

            if($exe){
                echo "<script>alert('Record Updated Successfully');</script>";
                echo "<script>window.location.href='drugs.php';</script>";
            }else{
                echo "<script>alert('Record Not Updated');</script>";
            }
        }

        if(isset($_GET['updateid'])){
            $id = $_GET['updateid'];

            $data = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM drugs WHERE id = '$id'"));
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
            <form class="max-w-xl m-4 p-10 bg-white rounded shadow-xl  w-full" method="POST">
                <p class="text-gray-800 text-xxl text-center font-bold">Update Drugs</p>

                <div class="">
                    <input class="w-full px-5 py-2 text-gray-700 bg-gray-200 rounded outline-none" id="cus_name" name="updateid" type="hidden" value="<?php echo $data['id'] ?>" required="" placeholder="" aria-label="Name">
                </div>
                <div class="mt-2">
                    <select class="block text-sm text-gray-600 w-full px-5 py-2 outline-none border" name="drug_name" for="cus_email">
                        <option value="" class="w-full text-gray-700 bg-gray-200 border rounded">Select Drug</option>
                        <option value="Paracetamol" class="w-full text-gray-700 bg-gray-200 rounded" <?php if ($data['drug_name'] == 'Paracetamol') echo 'selected'; ?>>Paracetamol</option>
                        <option value="Zubes" class="w-full outline-none text-gray-700 bg-gray-200 rounded" <?php if ($data['drug_name'] == 'Zubes') echo 'selected'; ?>>Zubes</option>
                    </select>
                </div>

                <div class="mt-2">
                    <select class="block text-sm text-gray-600 w-full px-5 py-2 outline-none border" name="drug_type" for="cus_email">
                        <option value="" class="w-full text-gray-700 bg-gray-200 border rounded">Select Type</option>
                        <option value="Pills" class="w-full text-gray-700 bg-gray-200 rounded" <?php if ($data['drug_type'] == 'Pills') echo 'selected'; ?>>Pills</option>
                        <option value="Syrup" class="w-full outline-none text-gray-700 bg-gray-200 rounded" <?php if ($data['drug_type'] == 'Syrup') echo 'selected'; ?>>Syrup</option>
                        <option value="Tablet" class="w-full outline-none text-gray-700 bg-gray-200 rounded" <?php if ($data['drug_type'] == 'Tablet') echo 'selected'; ?>>Tablet</option>
                    </select>
                </div>
                <div class="mt-2">
                    <input class="w-full px-5  py-2 text-gray-700 bg-gray-200 rounded outline-none" id="illness" value="<?php echo $data['illness'] ?>" name="illness" type="text" placeholder="Illness" aria-label="Illness">
                </div>
                <div class="mt-2">
                    <input class="w-full px-5  py-2 text-gray-700 bg-gray-200 rounded outline-none" id="dossage" value="<?php echo $data['dossage'] ?>" name="dossage" type="text" required="" placeholder="Dossage" aria-label="Dossage">
                </div>
              

                <div class="mt-2">
                    <input class="w-full px-5  py-2 text-gray-700 bg-gray-200 rounded outline-none" id="expiry_date" value="<?php echo $data['expiry_date'] ?>" name="expiry_date" type="text" required="" placeholder="Expiry Date " aria-label="Expiry Date">
                </div>
                <div class="mt-4">
                    <button class="px-4 py-1 text-white font-bold  text-lg tracking-wider bg-gray-900 rounded w-full" type="submit" name="submit">Update</button>
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