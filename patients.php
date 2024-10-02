<?php
require "./public/include/connect.php";
session_start();

if (isset($_GET['deleteid'])) {
    $id = mysqli_real_escape_string($connect, $_GET['deleteid']);
    $q = mysqli_query($connect, "DELETE FROM patients WHERE id = '$id'");

    if ($q) {
        echo "<script>alert('Record deleted successfully');</script>";
    } else {
        echo "<script>alert('Failed to delete the record');</script>";
    }

    echo "<script>window.location.href='patients.php';</script>";
}

if(isset($_POST['submit'])){
   $drugs = mysqli_real_escape_string($connect, $_POST['drugs']);

   $exe = mysqli_query($connect, "INSERT INTO patients VALUES('$drugs')");
   if($exe){
    echo "<script>alert('Record Saved Successfully');</script>";
    echo "<script>window.location.href='patients.php';</script>";
   }else{
    echo "<script>alert('Record Not Saved');</script>";
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php
require "./public/include/head.php";
?>
<body>
<!--Container -->
<div class="mx-auto bg-grey-400">
    <!--Screen-->
    <div class="min-h-screen flex flex-col">
   
        <!--Header Section Starts Here-->
       <?php
           require "./public/include/navbar.php"
       ?>
        <!--/Header-->

        <div class="flex flex-1">
            <!--Sidebar-->
            <?php
            require "./public/include/sidebar.php";
            ?>
            <!--/Sidebar-->
            <!--Main-->
            <main class="bg-white-300 flex-1 p-3 overflow-hidden">
                <div class="flex flex-col">
         
                    <!-- Card Section Starts Here -->
                 
                        <!-- card -->
                        <div class="rounded overflow-hidden shadow bg-white mx-2 w-full">
                            <div class="px-6 py-2 border-b border-light-grey">
                               
                            <div class="table-responsive">
                                <table class="table text-grey-darkest overflow-auto">
                                    <thead class="bg-grey-dark text-white text-normal">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col" class="text-sm">First Name</th>
                                        <th scope="col" class="text-sm">Middle Name</th>
                                        <th scope="col" class="text-sm">Last name</th>
                                        <th scope="col" class="text-sm">Gender</th>
                                        <th scope="col" class="text-sm">DOB</th>
                                        <th scope="col" class="text-sm">Location</th>
                                        <th scope="col" class="text-sm">Complain</th>
                                        <th scope="col" class="text-sm">Condition</th>
                                        <th scope="col" class="text-center text-sm">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $count = 1;
                                    $sql = mysqli_query($connect, "SELECT * FROM patients");
                                    while ($data = mysqli_fetch_assoc($sql)) { ?>
                                        <tr>
                                            <td><?php echo $count; ?></td>
                                            <td><?php echo $data['firstname']; ?></td>
                                            <td><?php echo $data['middlename']; ?></td>
                                            <td><?php echo $data['lastname']; ?></td>
                                            <td><?php echo $data['gender']; ?></td>
                                            <td><?php echo $data['dob']; ?></td>
                                            <td><?php echo $data['location']; ?></td>
                                            <td><?php echo $data['complain']; ?></td>
                                            <td><?php echo $data['conditions']; ?></td>
                                            <td class="flex">
                                                <a href="viewpatient.php?viewid=<?php echo $data['id']; ?>" class="bg-yellow-400 py-1 px-6 text-white font-bold rounded-8"><i class="fa fa-eye"></i></a>
                                                <a href="updatepatient.php?updateid=<?php echo $data['id']; ?>" class="mx-2 bg-green-400 py-1 px-6 text-white font-bold rounded-8"><i class="fa fa-keyboard"></i></a>
                                                <a onclick="return confirm('Are you sure you want to delete this record?')" href="?deleteid=<?php echo $data['id']; ?>" class="mx-2 bg-red-400 py-1 px-6 text-white font-bold rounded-8"><i class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    <?php
                                        $count++;
                                    } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /card -->
                    </div>
                </div>
            </main>
            <!--/Main-->
        </div>
      
    </div>
</div>
<?php require "./public/include/footer.php" ?>
        <!--/footer-->
    <script src="./main.js"></script>
<script src="main.js"></script>
<script scr="all.js"></script>
</body>
</html>
