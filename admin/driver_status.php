<!-- BLOCK#1 START DON'T CHANGE THE ORDER-->
<?php
$title = "Home | SLGTI";

include_once("head.php");
include_once("menu.php");

$u_id = $_SESSION['user']['id'];
$u_n = $_SESSION['user']['username'];
$u_t = $_SESSION['user']['user_type'];
$u_p = $_SESSION['user']['profile'];


$required_menu_name = 'driver_status'; // ✅ MUST be defined before include
// echo "Checking menu: " . $required_menu_name;
 include 'auth_check.php'; 

?>
<!--END DON'T CHANGE THE ORDER-->

<?php

if(isset($_GET['get_id'])){
    $did=$_GET['get_id'];
}
?>


<!--BLOCK#2 START YOUR CODE HERE -->
  <!-- Content Wrapper. Contains page content -->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Driver Status</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Driver Status
              <?php
              $actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; 
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
                  
    <section class="content mb-2">
      <div class="container-fluid">
        <div class="row">
          <div class="col-9">
          </div>
                <!-- /.col -->
          <div class="col-3">
              <!-- <a href="create_booking" class="btn btn-primary btn-block"> + Add</a> -->
          </div>
        </div>
      </div>
    </section>


                <?php


if (isset($_POST['update_status'])) {
    $p_id = (int)$_POST['p_id'];
    $status = $_POST['status'];

    // check if this status was already updated for this ride
    $check = $con->prepare("SELECT 1 FROM ride_status_history WHERE p_id = ? AND status = ?");
    $check->bind_param("is", $p_id, $status);
    $check->execute();
    $check->store_result();

    if ($check->num_rows == 0) {
        // Insert into history
        $stmt = $con->prepare("INSERT INTO ride_status_history (p_id, status) VALUES (?, ?)");
        $stmt->bind_param("is", $p_id, $status);
        if ($stmt->execute()) {
            echo '<script>
                Swal.fire({
                    icon: "success",
                    title: "Status updated: '.$status.'",
                    timer: 1200,
                    showConfirmButton: false
                }).then(function(){
                    window.location.href = "driver_status";
                });
            </script>';
        } else {
            echo "Error: " . $con->error;
        }
        $stmt->close();
    }
    $check->close();
}





// Assuming you've already established a mysqli connection
   $u_id = $_SESSION['user']['id'] ?? 0;
$query = "
SELECT 
    p.p_id,
    p.passager_principal,
    DATE_FORMAT(p.date_de_prise_en_charge, '%d-%b,%Y') AS formatted_date,
    p.Time,
    tm.type_m
FROM passenger p
JOIN users u ON p.user_id = u.id
JOIN type_mission tm ON p.tm_id = tm.tm_id
WHERE u.id =? AND p.Create_job_action='created'  
ORDER BY p.date_de_prise_en_charge, p.Time
";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $u_id);
$stmt->execute();
$result = $stmt->get_result();




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
                    <!-- <th data-visible="false">Id</th> --> 
                    <th>Référence</th>
                    <!-- <th>Date</th> -->
                    <th>Time</th>
                    <th>Type de Mission</th>
                    <th>Passager Principal</th>
                    <th>Action</th>
                  
                    <!-- <th data-visible="false">Create Date</th> -->
                  </tr>
                  </thead>

                  <tbody>
        <?php } ?>
        
                    <tr>
                        <td><a href="create_passenger_action.php?get_id=<?= $row["p_id"]?>"><?= "PCL1000".$row['p_id']?></a></td>
                      
                        <td><?= $row['Time']?></td>
                        <td><?= $row['type_m']?></td>
                        <td><?= $row['passager_principal']?></td>
            

              

<td>
  <?php
  // fetch status history for this ride
  $history = [];
  $hsql = "SELECT status, DATE_FORMAT(updated_at, '%d-%b %Y %H:%i') AS status_time
           FROM ride_status_history 
           WHERE p_id = ".$row['p_id']."
           ORDER BY updated_at ASC";
  $hres = $con->query($hsql);
  if ($hres) {
      while ($hrow = $hres->fetch_assoc()) {
          $history[$hrow['status']] = $hrow['status_time'];
      }
  }

  // all possible statuses
  $statuses = ["going to job","arrived now","pick up","ride completed"];

  // find remaining statuses not yet set
  $remaining = array_diff($statuses, array_keys($history));

  // progress calculation
  $total = count($statuses);
  $done  = count($history);
  $percent = intval(($done / $total) * 100);
  ?>

  <!-- Progress bar -->
  <div class="progress mb-2" style="height: 10px;">
    <div class="progress-bar 
        <?= $percent == 100 ? 'bg-success' : 'bg-info' ?>" 
        role="progressbar" 
        style="width: <?= $percent ?>%;" 
        aria-valuenow="<?= $percent ?>" 
        aria-valuemin="0" 
        aria-valuemax="100">
    </div>
  </div>
  <small><?= $percent ?>% completed</small>

  <?php if (!empty($remaining)): ?>
    <!-- Show dropdown only if some statuses remain -->
    <form method="post" style="margin:6px 0; display:flex; gap:6px;">
      <input type="hidden" name="p_id" value="<?= $row['p_id'] ?>">
      <select name="status" class="form-control form-control-sm" required>
        <option disabled selected>-- select status --</option>
        <?php foreach ($remaining as $st): ?>
          <option value="<?= $st ?>"><?= ucwords($st) ?></option>
        <?php endforeach; ?>
      </select>
      <button type="submit" name="update_status" class="btn btn-sm btn-warning">Update</button>
    </form>
  <?php endif; ?>

  <!-- Show completed statuses -->
  <?php if (!empty($history)): ?>
    <ul style="margin:0; padding-left:15px; font-size:12px; color:#555;">
      <?php foreach ($statuses as $st): ?>
        <?php if (isset($history[$st])): ?>
          <li><b><?= ucwords($st) ?>:</b> <?= $history[$st] ?></li>
        <?php endif; ?>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
</td>



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