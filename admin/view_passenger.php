<!-- BLOCK#1 START DON'T CHANGE THE ORDER-->
<?php
$title = "Home | SLGTI";

include_once("head.php");
include_once("menu.php");

$u_n = $_SESSION['user']['username'];
$u_t = $_SESSION['user']['user_type'];
$u_p = $_SESSION['user']['profile'];


$required_menu_name = 'view_passenger'; // ✅ MUST be defined before include
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
            <h1 class="m-0 text-dark">Jobs Detail</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Jobs Detail
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
     <?php if ($_SESSION['user']['user_type'] == 'admin' || $_SESSION['user']['user_type'] == 'ADM' || $_SESSION['user']['user_type'] == 'user_enties' ) {?>        
    <section class="content mb-2">
      <div class="container-fluid">
        <div class="row">
          <div class="col-9">
          </div>
                <!-- /.col -->
          <div class="col-3">
              <a href="create_booking" class="btn btn-primary btn-block"> + Add</a>
          </div>
        </div>
      </div>
    </section>
    <?php }?>


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
        $status_date = $_POST['status_date'] ?? date('Y-m-d');
$status_time = $_POST['status_time'] ?? date('H:i:s');
$manual_datetime = date('Y-m-d H:i:s', strtotime("$status_date $status_time"));

$stmt = $con->prepare("INSERT INTO ride_status_history (p_id, status, updated_at) VALUES (?, ?, ?)");
$stmt->bind_param("iss", $p_id, $status, $manual_datetime);
        if ($stmt->execute()) {
            echo '<script>
                Swal.fire({
                    icon: "success",
                    title: "Status updated: '.$status.'",
                    timer: 1200,
                    showConfirmButton: false
                }).then(function(){
                    window.location.href = "view_passenger";
                });
            </script>';
        } else {
            echo "Error: " . $con->error;
        }
        $stmt->close();
    }
    $check->close();
}




                // Get all drivers for the dropdown
$userss = [];
$users_result = mysqli_query($con, "SELECT id, username FROM users where user_type IN ('driver','user_enties') ORDER BY username");
if ($users_result) {
    while ($drow = mysqli_fetch_assoc($users_result)) {
        $userss[] = $drow; // each: ['d_id' => ..., 'dname' => ...]
    }
}


// Handle driver update
if (isset($_POST['update_driver'])) {
    $new_driver_id = (int)($_POST['user_id'] ?? 0);
    $passenger_id  = (int)($_POST['p_id'] ?? 0);

    if ($new_driver_id > 0 && $passenger_id > 0) {
        $stmt = $con->prepare("UPDATE passenger SET user_id = ? WHERE p_id = ?");
        $stmt->bind_param("ii", $new_driver_id, $passenger_id);
        if ($stmt->execute()) {
            echo '<script>
                Swal.fire({
                    icon: "success",
                    title: "Driver updated!",
                    timer: 1200,
                    showConfirmButton: false
                }).then(function(){
                    window.location.href = "view_passenger";
                });
            </script>';
        } else {
            echo "Error updating driver: " . $con->error;
        }
        $stmt->close();
    }
}

// Assuming you've already established a mysqli connection


// Get current logged in user
$user_type = $_SESSION['user']['user_type'] ?? '';
$logged_user_id = $_SESSION['user']['id'] ?? 0;

$extra_condition = "";

// Restrict query based on role
if ($user_type === 'driver') {
    // Driver sees his own rides + user_id 53
    $extra_condition = " AND (p.user_id = " . (int)$logged_user_id . " OR p.user_id = 50)";
} elseif ($user_type === 'user_enties') {
    // Normal user sees only his own rides + user_id 53
    $extra_condition = " AND (p.user_id = " . (int)$logged_user_id . " OR p.user_id = 50)";
}

// admin and ADM → see everything, so no condition needed

$query = "
SELECT
    p.p_id,
    p.passager_principal,
    DATE_FORMAT(p.date_de_prise_en_charge, '%d-%b,%Y') AS formatted_date,
    p.Time,
    tm.type_m,
    u.username,
    p.user_id AS current_user_id
FROM passenger p
JOIN type_mission tm ON p.tm_id = tm.tm_id
LEFT JOIN users u ON p.user_id = u.id
WHERE p.Create_job_action = 'created' $extra_condition
ORDER BY p.date_de_prise_en_charge, p.Time
";
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
                    <!-- <th data-visible="false">Id</th> --> 
                    <th>Référence</th>
                    <!-- <th>Date</th> -->
                    <th>Time</th>
                    <th>Type de Mission</th>
                    <th>Passager Principal</th>
                  <?php if (in_array($user_type, ['admin', 'ADM'])): ?>
                      <th>Driver</th>
                      <th>Admin Action</th>
                      <th>Driver Action</th>
                  <?php elseif ($user_type === 'driver'): ?>
                      <th>Action</th>
                      <th>Driver Action</th>
                  
                  <?php elseif ($user_type === 'user_enties'): ?>
                      <th>Action</th>
                  <?php endif; ?>
                    
                    <!-- <th data-visible="false">Create Date</th> -->
                  </tr>
                  </thead>
                  <?php
                    if(isset($_GET['delete_id']))
                    {                
                        $p_id = $_GET['delete_id'];
                        // Start a transaction
                        $con->begin_transaction();

                        // Define an array of table names
                        $tables = ["passenger", "option_desc", "passenger_description", "type_de_mission_desc"];

                        $success = true;

                        // Delete records from each table
                        foreach ($tables as $table) {
                            $sql = "DELETE FROM $table WHERE p_id = $p_id";
                            if ($con->query($sql) !== TRUE) {
                                $success = false;
                                break;
                            }
                        }

                        if ($success) {
                            // All deletes were successful
                            $con->commit(); // Commit the transaction
                            echo '<script>';
                            echo '
                            Swal.fire({
                               position: "top-end",
                           
                               icon: "success",
                               title: "Your Data Deleted!",
                               showConfirmButton: false,
                              
                               timer: 1500
                             }).then(function() {
                               // Redirect the user
                               window.location.href = "view_passenger";
                           
                               });
                            ';
                            echo '</script>';
                        } else {
                            // At least one delete operation failed, so we need to roll back the transaction
                            $con->rollback();
                            echo "Error deleting records from one or more tables: " . $con->error;
                        }

                      
                      }

                    ?>
                  <tbody>
        <?php
        }
        ?>
        
                    <tr>
                        <td><a href="create_passenger_action.php?get_id=<?= $row["p_id"]?>"><?= "PCL1000".$row['p_id']?></a></td>
                      
                        <td><?= $row['Time']?></td>
                        <td><?= $row['type_m']?></td>
                        <td><?= $row['passager_principal']?></td>
                        <?php if (in_array($user_type, ['admin', 'ADM'])): ?>
                        <td style="min-width:280px">
                          
                              <!-- Admin & ADM can assign/change driver -->
                              <form method="post" style="display:flex; align-items:center; gap:6px; margin:0;">
                                <input type="hidden" name="p_id" value="<?= (int)$row['p_id'] ?>">
                                <select name="user_id" class="form-control form-control-sm" required>
                                  <option value="" disabled <?= empty($row['current_user_id']) ? 'selected' : '' ?>>— choose —</option>
                                  <?php foreach ($userss as $drv): ?>
                                    <option value="<?= (int)$drv['id'] ?>"
                                      <?= ((int)$drv['id'] === (int)$row['current_user_id']) ? 'selected' : '' ?>>
                                      <?= htmlspecialchars($drv['username']) ?>
                                    </option>
                                  <?php endforeach; ?>
                                </select>
                                <button type="submit" name="update_driver" class="btn btn-sm btn-primary">Save</button>
                              </form>
                        </td>
                          <?php endif; ?>

                          
                          <td>
                          <?php if (in_array($user_type, ['admin', 'ADM','driver','user_enties'])): ?>
                          <!-- Admin & ADM: Full access -->
                          <a href="create_booking.php?get_id=<?= $row["p_id"]?>" class="btn btn-info">
                            <i class="fas fa-edit"></i>
                          </a>
                          <?php endif; ?>
                          <?php if (in_array($user_type, ['admin', 'ADM','driver' ,'user_enties'])): ?>
<!-- ✅ Download Button -->
<a href="#" 
   onclick="setPDFId(<?= $row['p_id'] ?>)" 
   class="btn btn-success" 
   data-toggle="modal" 
   data-target="#modal-pdf">
   <i class="fas fa-download"></i>
</a>

<!-- ✅ Modal (AdminLTE / Bootstrap 4 style) -->
<div class="modal fade" id="modal-pdf">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-dark text-white">
        <h4 class="modal-title">Choose PDF Type</h4>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body text-center">
        <p>Select the type of PDF you want to generate:</p>
      </div>

      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <div>
          <button type="button" class="btn btn-info" id="passengerBtn">Passenger</button>
          <button type="button" class="btn btn-success" id="billingBtn">Billing</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
let selectedPid = null;

function setPDFId(pid) {
    selectedPid = pid;
}

// Passenger PDF
document.getElementById('passengerBtn').addEventListener('click', function() {
    if (selectedPid) {
        window.open(`print_invoice1.php?get_id=${selectedPid}&type=passenger`, '_blank');
        $('#modal-pdf').modal('hide');
    }
});

// Billing PDF
document.getElementById('billingBtn').addEventListener('click', function() {
    if (selectedPid) {
        window.open(`print_invoice1.php?get_id=${selectedPid}&type=billing`, '_blank');
        $('#modal-pdf').modal('hide');
    }
});
</script>


 
                          <?php endif; ?>
                          <?php if (in_array($user_type, ['admin', 'ADM'])): ?>
                          <button class="btn btn-danger" 
                                  data-href="?delete_id=<?= $row["p_id"]?>" 
                                  data-toggle="modal" 
                                  data-target="#confirm-delete-passenger">
                            <i class="fas fa-trash"></i>
                          </button>
                          <?php endif; ?>         
                    </td>
                   

 <?php if (in_array($user_type, ['admin', 'ADM','driver'])): ?>
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
  $statuses = ["On the way","On Site","On Board","Ride Completed"];

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
<form method="post" style="margin:6px 0; display:flex; flex-wrap:wrap; gap:6px;" class="status-form">
  <input type="hidden" name="p_id" value="<?= $row['p_id'] ?>">

  <select name="status" class="form-control form-control-sm status-select" required>
    <option disabled selected>-- select status --</option>
    <?php foreach ($remaining as $st): ?>
      <option value="<?= $st ?>"><?= ucwords($st) ?></option>
    <?php endforeach; ?>
  </select>

  <?php
  // Set current system date & time as default
  $current_date = date('Y-m-d');
  $current_time = date('H:i');
  ?>

  <!-- Date & time inputs (hidden initially, shown after selecting status) -->
  <input type="date" name="status_date" class="form-control form-control-sm status-date" 
         value="<?= $current_date ?>" style="display:none;" required>
  <input type="time" name="status_time" class="form-control form-control-sm status-time" 
         value="<?= $current_time ?>" style="display:none;" required>

  <button type="submit" name="update_status" class="btn btn-sm btn-warning">Update</button>
</form>

<script>
document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".status-form").forEach(form => {
    const select = form.querySelector(".status-select");
    const dateInput = form.querySelector(".status-date");
    const timeInput = form.querySelector(".status-time");

    select.addEventListener("change", () => {
      // Show date & time fields only after selecting a status
      dateInput.style.display = "block";
      timeInput.style.display = "block";
    });
  });
});
</script>

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

<?php endif; ?>

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