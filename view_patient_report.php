<?php 
require "./public/include/connect.php";
?>

<!DOCTYPE html>
<html>
<?php include "./public/include/head.php" ?>
  <body class="">
  <div class="mx-auto bg-grey-400">
    <!--Screen-->
    <div class="min-h-screen flex flex-col">
        <!--Header Section Starts Here-->
    <?php
        require "./public/include/header.php";
    ?>
        <!--/Header-->

        <div class="flex flex-1">
            <!--Sidebar-->
      <?php
          require "./public/include/sidebar.php";
      ?>

      <div class="w-full px-6 py-6 mx-auto">
        <!-- Patient Details -->
        <div class="flex flex-wrap my-6 -mx-3">
          <!-- card 1 -->
          <div class="w-full max-w-full px- mt-0 mb-6 md:mb-0 border lg:flex-none">
            <div class="border-black/12.5 shadow-soft-xl relative flex min-w-0 flex-col break-words rounded-2xl w-full border-0 border-solid bg-clip-border">
              <div class="border-black/12.5 mb-0 rounded-t-2xl w-full border-0  border-solid bg-gray-400 py-6 ">
                <div class="flex flex-wrap mt-0 -mx-3">
                  <div class="flex-none w-full px-3 mt-0 lg:w-full">
                    <h6 class="text-center text-white font-extrabold  uppercase">View Referred Patient Details</h6>
                  </div>
                </div>
              </div>
              <div class="flex-auto p-6">
                <div class="overflow-x-auto">
                  <table class="items-center w-full responsive mb-0 align-top  border-gray-200 text-slate-500">
                    <tbody class="">
                      <?php
                      if(isset($_GET['viewid'])){
                        $viewid = $_GET['viewid'];
                        $q = mysqli_query($connect, "SELECT * FROM patient_report WHERE id = '$viewid'");
                        if($data = mysqli_fetch_assoc($q)) { ?>
                          <tr class=" ">
                            <th style="font-size: 11px;"  class="px-6 py-3 tracking-normal text-left uppercase align-middle bg-transparent border-b text-sm whitespace-nowrap font-extrabold text-slate-500">Patient's Name</th>
                            <td class='p-2 align-middle text-sm bg-transparent border-b whitespace-nowrap shadow-transparent text-right px-8'><?php echo isset($data['name']) ? $data['name'] : ''; ?></td>
                          </tr>
                          <tr class="">
                            <th style="font-size: 11px;"  class="px-6 py-3 tracking-normal text-left uppercase align-middle bg-transparent border-b text-sm whitespace-nowrap font-extrabold text-slate-500">Illness</th>
                            <td class='p-2 align-middle text-sm bg-transparent border-b whitespace-nowrap shadow-transparent text-right px-8'><?php echo isset($data['illness']) ? $data['illness'] : ''; ?></td>
                          </tr>
                          <tr>
                            <th style="font-size: 11px;"  class="px-6 py-3 tracking-normal text-left uppercase align-middle bg-transparent border-b text-sm whitespace-nowrap font-extrabold text-slate-500">Patient's Contact</th>
                            <td class='p-2 align-middle text-sm bg-transparent border-b whitespace-nowrap shadow-transparent text-right px-8'><?php echo isset($data['patient_contact']) ? $data['patient_contact'] : ''; ?></td>
                          </tr>
                          <tr>
                            <th style="font-size: 11px;"  class="px-6 py-3 tracking-normal text-left uppercase align-middle bg-transparent border-b text-sm whitespace-nowrap font-extrabold text-slate-500">Referral Doctor's Name</th>
                            <td class='p-2 align-middle text-sm bg-transparent border-b whitespace-nowrap shadow-transparent text-right px-8'><?php echo isset($data['ref_doctor_name']) ? $data['ref_doctor_name'] : ''; ?></td>
                          </tr>
                          <tr>
                            <th style="font-size: 11px;"  class="px-6 py-3 tracking-normal text-left uppercase align-middle bg-transparent border-b text-sm whitespace-nowrap font-extrabold text-slate-500">Referral Hospital</th>
                            <td class='p-2 align-middle text-sm bg-transparent border-b whitespace-nowrap shadow-transparent text-right px-8'><?php echo isset($data['ref_hospital']) ? $data['ref_hospital'] : ''; ?></td>
                          </tr>

                          <tr>
                            <th style="font-size: 11px;"  class="px-6 py-3 tracking-normal text-left uppercase align-middle bg-transparent border-b text-sm whitespace-nowrap font-extrabold text-slate-500">Referral Doctor's Contact</th>
                            <td class='p-2 align-middle text-sm bg-transparent border-b whitespace-nowrap shadow-transparent text-right px-8'><?php echo isset($data['ref_doctor_contact']) ? $data['ref_doctor_contact'] : ''; ?></td>
                          </tr>

                          <tr>
                            <th style="font-size: 11px;"  class="px-6 py-3 tracking-normal text-left uppercase align-middle bg-transparent border-b text-sm whitespace-nowrap font-extrabold text-slate-500">Referral Hospital Location</th>
                            <td class='p-2 align-middle text-sm bg-transparent border-b whitespace-nowrap shadow-transparent text-right px-8'><?php echo isset($data['ref_hospital_location']) ? $data['ref_hospital_location'] : ''; ?></td>
                          </tr>

                          <tr>
                            <th style="font-size: 11px;"  class="px-6 py-3 tracking-normal text-left uppercase align-middle bg-transparent border-b text-sm whitespace-nowrap font-extrabold text-slate-500">Location Of Hospital Referred To</th>
                            <td class='p-2 align-middle text-sm bg-transparent border-b whitespace-nowrap shadow-transparent text-right px-8'><?php echo isset($data['location_hosp_referred']) ? $data['location_hosp_referred'] : ''; ?></td>
                          </tr>

                          <tr>
                            <th style="font-size: 11px;"  class="px-6 py-3 tracking-normal text-left uppercase align-middle bg-transparent border-b text-sm whitespace-nowrap font-extrabold text-slate-500">Name Of Hospital Referred To</th>
                            <td class='p-2 align-middle text-sm bg-transparent border-b whitespace-nowrap shadow-transparent text-right px-8'><?php echo isset($data['name_hosp_referred']) ? $data['name_hosp_referred'] : ''; ?></td>
                          </tr>

                          <tr>
                                 <td colspan="2" class="text-center my-6 py-6">
                                      <a href="download.php?viewid=<?php echo $data['id']; ?>" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                          Download PDF
                                      </a>
                                  </td>
                                  </tr>
                        <?php }
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- end Patient Details -->
      </div>
    </main>
 <!--Footer-->
 <?php require "./public/include/footer.php" ?>
        <!--/footer-->
    <script src="./main.js"></script>
  </body>
 
</html>
