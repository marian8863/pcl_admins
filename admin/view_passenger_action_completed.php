<!-- BLOCK#1 START DON'T CHANGE THE ORDER-->
<?php
$title = "Home | SLGTI";

include_once("head.php");
include_once("menu.php");

$u_n = $_SESSION['user']['username'];
$u_t = $_SESSION['user']['user_type'];
$u_p = $_SESSION['user']['profile'];

$required_menu_name = 'view_passenger_action_completed'; // ✅ MUST be defined before include
// echo "Checking menu: " . $required_menu_name;
 include 'auth_check.php'; 

?>
<!--END DON'T CHANGE THE ORDER-->




<!--BLOCK#2 START YOUR CODE HERE -->
  <!-- Content Wrapper. Contains page content -->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Jobs Completed Detail</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Jobs Completed Detail
              <?php
                  // echo  $Sdate = new DateTime("now", new DateTimeZone('Asia/Colombo'));
                 // date_default_timezone_set('Asia/Colombo');
                  // $date = date('d-m-y h:i:s');
                  // echo $date;
              ?>
              </li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

  <!-- Main content -->
                  



                <?php
// Assuming you've already established a mysqli connection

// Execute the SELECT query
$query = "SELECT distinct passenger.`p_id`,passenger.`passager_principal`,DATE_FORMAT(passenger.`date_de_prise_en_charge`, '%d-%b,%Y') AS formatted_date ,passenger.`Time`,passenger.`Tarif`,type_mission.`type_m`,users.`username`,passenger.`Create_job_action` 
FROM passenger ,type_mission,users where passenger.`tm_id`=type_mission.`tm_id` and passenger.`user_id`=users.`id` and  passenger.`Create_job_action`='completed'   ORDER BY passenger.`date_de_prise_en_charge` desc";
$result = mysqli_query($con, $query);

if ($result) {
    $previous_date = null;
    while ($row = mysqli_fetch_assoc($result)) {
        $current_date = $row['formatted_date'];
        
        // If the date changes, start a new table
        if ($current_date !== $previous_date) {
            if ($previous_date !== null) {
                echo "</table>"; // Close previous table
                ?>
                </div>
             <!-- /.card-body -->
           </div>
           <!-- /.card -->

       
         </div>
         <!-- /.col -->
       </div>
       <!-- /.row -->
     </div>
     <!-- /.container-fluid -->
   </section>
   <?php
            }
            
            // echo "$current_date";
        ?>
          <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header" style="background-color:#f4f6f9">
                <h2 class="card-title"><?php echo "$current_date"; ?></h2>
              </div>

              <div class="card-body">
                <table   class="example3 table table-bordered table-striped">
                  <thead>
                  <tr>
                  
                    <th>Référence</th>
                    <th>Passager Principal</th>
                    <th>Time</th>
                    <th>Type de Mission</th>
                  
                    <th>Tarif</th>
                    <th>Action</th>
                  
                  </tr>
                  </thead>
                  <tbody>
        <?php
        }
        ?>
        
                    <tr>
                        <td><a href="create_passenger_action.php?get_id=<?= $row["p_id"]?>"><?= "PCL1000".$row['p_id']?></td>
                        <td><?= $row['passager_principal']?></td>
                        <td><?= $row['Time']?></td>
                        <td><?= $row['type_m']?></td>
                        <!-- <td>< $row['passager_principal']?></td> -->
                        <td><?= $row['Tarif']?></td>
                        <td>
                            <a href="create_booking.php?get_id=<?= $row["p_id"]?>" class="btn btn-info"><i class="fas fa-edit"></i></a>
                            <a href="print_invoice1.php?get_id=<?=$row["p_id"]?>" target="_blank" class="btn btn-success"><i class="fas fa-download"></i></a> 
                            <button  class="btn btn-danger" data-href="?delete_id=<?=$row["p_id"]?>" data-toggle="modal" data-target="#confirm-delete-passenger"><i class="fas fa-trash"></i></button>
                        </td>

                        <!--  -->
                    </tr>
                    
                  
        <?php
        $previous_date = $current_date;
    }
    
    // Close the last table
    echo "</tbody>";
    echo "</tfoot>";
    echo "</table>";
    
    mysqli_free_result($result);
    ?>
                 </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

        
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <?php
} else {
    echo "Error: " . mysqli_error($con);
}

// Close the mysqli connection
mysqli_close($con);
?>


                
                
  
 
    <!-- /.content -->
  </div>

 
  <!-- /.content-wrapper -->

  <!-- /.content-wrapper -->



<!--BLOCK#2 end YOUR CODE HERE -->


<!--BLOCK#3 START DON'T CHANGE THE ORDER-->
<?php include_once("footer.php"); ?>
<!--END DON'T CHANGE THE ORDER-->