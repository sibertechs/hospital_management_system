<?php
require "./public/include/connect.php";
session_start();

if (isset($_GET['deleteid'])) {
    $id = mysqli_real_escape_string($connect, $_GET['deleteid']);
    $q = mysqli_query($connect, "DELETE FROM drugs WHERE id = '$id'");

    if ($q) {
        echo "<script>alert('Record deleted successfully');</script>";
    } else {
        echo "<script>alert('Failed to delete the record');</script>";
    }

    echo "<script>window.location.href='drugs.php';</script>";
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
      <?php require "./public/include/navbar.php"; ?>
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
                    <div class="flex flex-1 flex-col md:flex-row lg:flex-row mx-2">
                        <!-- card -->
                        <div class="rounded overflow-hidden shadow bg-white mx-2 w-full">
                            <div class="px-6 py-2 border-b border-light-grey">
                                <div class="font-bold text-xl">Drugs Table</div>
                            </div>
                            <div class="table-responsive">
                                <table class="table text-grey-darkest overflow-auto">
                                    <thead class="bg-grey-dark text-white text-normal">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col" class="text-sm">Drug Name</th>
                                        <th scope="col" class="text-sm">Drug Type</th>
                                        <th scope="col" class="text-sm">Illness</th>
                                        <th scope="col" class="text-sm">Dossage</th>
                                        <th scope="col" class="text-sm">Expiry Date</th>
                                        <th scope="col" class="text-center text-sm">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $count = 1;
                                    $sql = mysqli_query($connect, "SELECT * FROM drugs");
                                    while ($data = mysqli_fetch_assoc($sql)) { ?>
                                        <tr>
                                            <td><?php echo $count; ?></td>
                                            <td><?php echo $data['drug_name']; ?></td>
                                            <td><?php echo $data['drug_type']; ?></td>
                                            <td><?php echo $data['illness']; ?></td>
                                            <td><?php echo $data['dossage']; ?></td>
                                            <td><?php echo $data['expiry_date']; ?></td>
                                            <td class="flex">
                                                <a href="viewdrug.php?viewid=<?php echo $data['id']; ?>" class="bg-yellow-100 py-1 px-6 text-white font-bold rounded-8"><a href="viewpatient.php?viewid=<?php echo $data['id']; ?>" class="bg-yellow-400 py-1 px-6 text-white text-center font-bold rounded-8"><i class="fa fa-eye text-center"></i></a>                                                </a>
                                                <a href="updatedrug.php?updateid=<?php echo $data['id']; ?>" class="mx-2 bg-green-400 py-1 px-6 text-white font-bold rounded-8"><i class="fa fa-keyboard"></i></a>
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
         <!--Footer-->
         <?php require "./public/include/footer.php" ?>
        <!--/footer-->
    </div>
</div>
<script src="./main.js"></script>
</body>
</html>
