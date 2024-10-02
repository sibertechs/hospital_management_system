<?php
require "./public/include/connect.php";
session_start();

if (isset($_GET['deleteid'])) {
    $id = mysqli_real_escape_string($connect, $_GET['deleteid']);
    $q = mysqli_query($connect, "DELETE FROM patient_report WHERE id = '$id'");

    if ($q) {
        echo "<script>alert('Record deleted successfully');</script>";
    } else {
        echo "<script>alert('Failed to delete the record');</script>";
    }

    echo "<script>window.location.href='reports_table.php';</script>";
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
        <header class="bg-nav">
            <div class="flex justify-between">
                <div class="p-1 mx-3 inline-flex items-center">
                    <i class="fas fa-bars pr-2 text-white" onclick="sidebarToggle()"></i>
                    <h1 class="text-white p-2">Logo</h1>
                </div>
                <div class="p-1 flex flex-row items-center">
                    <a href="login.php" class="text-white p-2 mr-2 no-underline hidden md:block lg:block">Logout</a>
                </div>
            </div>
        </header>
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
                                <div class="font-bold text-xl">Pateints Report Table</div>
                            </div>
                            <div class="table-responsive">
                                <table class="table text-grey-darkest overflow-auto">
                                    <thead class="bg-grey-dark text-white text-normal">
                                    <tr class="" style=" font-size: 12px;">
                                        <th scope="col">#</th>
                                        <th scope="col" class="" style="font-size: 10px;">Patient Name</th>
                                        <th scope="col" class="" style="font-size: 10px;">Illnes</th>
                                        <th scope="col" class="" style="font-size: 10px;">Patient Contact</th>
                                        <th scope="col" class="" style="font-size: 10px;">Referral Doctor Name</th>
                                        <th scope="col" class="" style="font-size: 10px;">Referral Hospital</th>
                                        <th scope="col" class="" style="font-size: 10px;">Referral Doctor Contact</th>
                                        <th scope="col" class="" style="font-size: 10px;">Referral Hospital's Location</th>
                                        <th scope="col" class="" style="font-size: 10px;">Name of Referred Hospital</th>
                                        <th scope="col" class="" style="font-size: 10px;">Location of the referred Hospital</th>
                                        <th scope="col" class="text-center " style="font-size: 10px;">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $count = 1;
                                    $sql = mysqli_query($connect, "SELECT * FROM patient_report");
                                    while ($data = mysqli_fetch_assoc($sql)) { ?>
                                        <tr class="w-full" style=" font-size: 12px;">
                                            <td style="font-size: 10px;"  class=""><?php echo $count; ?></td>
                                            <td style="font-size: 10px;"  class=""><?php echo $data['name']; ?></td>
                                            <td style="font-size: 10px;"  class=""><?php echo $data['illness']; ?></td>
                                            <td style="font-size: 10px;"  class=""><?php echo $data['patient_contact']; ?></td>
                                            <td style="font-size: 10px;"  class=""><?php echo $data['ref_doctor_name']; ?></td>
                                            <td style="font-size: 10px;"  class=""><?php echo $data['ref_hospital']; ?></td>
                                            <td style="font-size: 10px;"  class=""><?php echo $data['ref_doctor_contact']; ?></td>
                                            <td style="font-size: 10px;"  class=""><?php echo $data['ref_hospital_location']; ?></td>
                                            <td style="font-size: 10px;"  class=""><?php echo $data['location_hosp_referred']; ?></td>
                                            <td style="font-size: 10px;"  class=""><?php echo $data['name_hosp_referred']; ?></td>
                                            <td style="font-size: 10px;"  class="flex">
                                                <a href="view_patient_report.php?viewid=<?php echo $data['id']; ?>" class="bg-yellow-400 py-1 px-6 text-white font-bold rounded-8"><i class="fa fa-eye"></i></a>
                                                <a href="update_patient_report.php?updateid=<?php echo $data['id']; ?>" class="mx-2 bg-green-400 py-1 px-6 text-white font-bold rounded-8"><i class="fa fa-keyboard"></i></a>
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
<script scr="./all.js"></script>
</body>
</html>
