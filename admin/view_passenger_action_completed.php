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
<!-- ✅ Single Reusable PDF Modal -->
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
          <button type="button" class="btn btn-success" id="billingBtn">Driver</button>
          <button type="button" class="btn btn-primary" id="invoiceBtn">Invoice</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
let selectedPid = null;

// Called when clicking the green download button
function setPDFId(pid) {
  selectedPid = pid;
}

// One global listener for both buttons
document.addEventListener("DOMContentLoaded", () => {
  const passengerBtn = document.getElementById("passengerBtn");
  const billingBtn = document.getElementById("billingBtn");
  // const invoiceBtn = document.getElementById("invoiceBtn");

  passengerBtn.addEventListener("click", () => {
    if (selectedPid) {
      const url = `print_invoice1.php?get_id=${selectedPid}&type=passenger`;
      window.open(url, "_blank");
      $("#modal-pdf").modal("hide");
    }
  });

  billingBtn.addEventListener("click", () => {
    if (selectedPid) {
      const url = `print_invoice1.php?get_id=${selectedPid}&type=billing`;
      window.open(url, "_blank");
      $("#modal-pdf").modal("hide");
    }
  });
//   invoiceBtn.addEventListener("click", () => {
//   if (selectedPid) {
//     const url = `invoice_pdf?get_id=${selectedPid}&type=invoice`;
//     window.open(url, "_blank");
//     $("#modal-pdf").modal("hide");
//   }
// });
});
</script>
<!-- ✅ Invoice Modal -->
<div class="modal fade" id="modal-invoice">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h4 class="modal-title">Invoice Details</h4>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form id="invoiceForm">
          <!-- 1️⃣ Company Name -->
          <div class="form-group">
            <label>Do you have a Client ?</label><br>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="has_company" id="companyYes" value="yes">
              <label class="form-check-label" for="companyYes">Yes</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="has_company" id="companyNo" value="no" checked>
              <label class="form-check-label" for="companyNo">No</label>
            </div>
          </div>

          <div class="form-group" id="companyNameGroup" style="display:none;">
            <label for="companyName">Company Name</label>
            <input type="text" class="form-control" id="companyName" name="company_name" placeholder="Enter company name">
          </div>

          <!-- 2️⃣ Quantity -->
          <div class="form-group">
            <label for="qty">Quantity (QTY)</label>
            <input type="number" class="form-control" id="qty" name="qty" min="1" value="1" required>
          </div>

          <!-- 3️⃣ Unit Price -->
          <div class="form-group">
            <label for="unitPrice">Unit Price (HT)</label>
            <input type="text" class="form-control" id="unitPrice" name="unit_price" required>
          </div>
        </form>
      </div>

      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="generateInvoiceBtn">Generate Invoice</button>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", () => {
  const invoiceBtn = document.getElementById("invoiceBtn");

  invoiceBtn.addEventListener("click", () => {
    if (selectedPid) {
      // ✅ Close the "Choose PDF Type" modal
      $("#modal-pdf").modal("hide");

      // ✅ Fetch Tarif from PHP (using data-* attribute)
      const tarifValue = document.querySelector(`[data-pid='${selectedPid}']`)?.dataset.tarif || '';

      // ✅ Prefill unit price field
      document.getElementById("unitPrice").value = tarifValue;

      // ✅ Show the new "Invoice" modal
      setTimeout(() => {
        $("#modal-invoice").modal("show");
      }, 300);
    }
  });

  // ✅ Toggle company name input
  document.querySelectorAll("input[name='has_company']").forEach((radio) => {
    radio.addEventListener("change", (e) => {
      const group = document.getElementById("companyNameGroup");
      if (e.target.value === "yes") {
        group.style.display = "block";
      } else {
        group.style.display = "none";
      }
    });
  });

  // ✅ Handle Generate Invoice click
  document.getElementById("generateInvoiceBtn").addEventListener("click", () => {
    const form = document.getElementById("invoiceForm");
    const formData = new FormData(form);
    const params = new URLSearchParams(formData).toString();

    // Open invoice generation in a new tab
    // window.open(`invoice_pdf?get_id=${selectedPid}&type=invoice&${params}`, "_blank");

    // Close modal
    $("#modal-invoice").modal("hide");
  });

  document.getElementById("generateInvoiceBtn").addEventListener("click", () => {
  const form = document.getElementById("invoiceForm");
  const formData = new FormData(form);
  formData.append("p_id", selectedPid);

  fetch("save_invoice", {
    method: "POST",
    body: formData,
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      // Swal.fire({
      //   icon: "success",
      //   title: "Invoice saved!",
      //   timer: 1200,
      //   showConfirmButton: false
      // });

      // After saving → open invoice PDF in new tab
      // const url = `invoice_pdf?get_id=${selectedPid}&type=invoice`;
      // window.open(url, "_blank");
           const url = `invoice_pdf.php?get_id=${selectedPid}&invoice_id=${data.invoice_id}`;
      window.open(url, "_blank");
      $("#modal-invoice").modal("hide");
    } else {
      Swal.fire({ icon: "error", title: "Error saving invoice", text: data.message });
    }
  })
  .catch(err => {
    Swal.fire({ icon: "error", title: "Error", text: err });
  });
});

});

</script>



<!--BLOCK#2 START YOUR CODE HERE -->
  <!-- Content Wrapper. Contains page content -->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark text-red">Jobs Completed Detail</h1>
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
    $extra_condition = " AND (passenger.user_id = " . (int)$logged_user_id . " OR passenger.user_id = 50)";
} elseif ($user_type === 'user_enties') {
    // Normal user sees only his own rides + user_id 53
    $extra_condition = " AND (passenger.user_id = " . (int)$logged_user_id . " OR passenger.user_id = 50)";
}

// admin and ADM → see everything, so no condition needed

$query = "SELECT 
    passenger.p_id,
    passenger.passager_principal,
    passenger.date_de_prise_en_charge,
    passenger.Time,
    passenger.pickup_location,
    passenger.dropoff_location,
    pickup.name  AS pickup_adr,
    dropoff.name AS dropoff_adr,
    passenger.nb_de_passager,
    passenger.user_id as current_user_id,
    passenger.chauffeur_desc,
    users.id AS user_id_ref,
    users.username,
    users.phone,
    users.email,
    users.user_desc,
    users_desc.user_description,
    passenger.Tarif,
    tarif_type.type_tt,
    tarif_type.type_tt_desc,
    select_an_option_desc.tm_id,
    type_mission.type_m,
    option_tel.op_tel_desc,
    option_tel.op_tel_question,
    vehicule.Vehicule_num,
    type_de_mission_desc.type_desc,
    type_de_mission_desc.select_quesntion,
    passenger_description.passenger_select_desc,
    passenger_description.passenger_select_quesntion,
    option_desc.op_desc,
    option_desc.op_question,
    select_an_option_desc.tm_desc,
    who_give_booking.wg_desc,
    who_give_booking.wg_question,
    passenger_pickup_desc.ppd_desc,
    passenger_pickup_desc.ppd_question,
    passenger_dropoff_desc.pdd_desc,
    passenger_dropoff_desc.pdd_question,
    DATE_FORMAT(passenger.date_de_prise_en_charge, '%d-%b,%Y') AS formatted_date
FROM passenger
JOIN option_tel             ON passenger.p_id = option_tel.p_id
JOIN vehicule               ON vehicule.v_id = passenger.Vehicule_num
JOIN type_mission           ON type_mission.tm_id = passenger.tm_id
JOIN type_de_mission_desc   ON type_de_mission_desc.p_id = passenger.p_id
JOIN passenger_description  ON passenger_description.p_id = passenger.p_id
JOIN users                  ON users.id = passenger.user_id
JOIN users_desc             ON users.user_desc = users_desc.user_desc
JOIN tarif_type             ON tarif_type.tt_id = passenger.tt_id
JOIN option_desc            ON option_desc.p_id = passenger.p_id
JOIN select_an_option_desc  ON select_an_option_desc.p_id = passenger.p_id
JOIN who_give_booking       ON passenger.p_id = who_give_booking.p_id
JOIN passenger_pickup_desc  ON passenger_pickup_desc.p_id = passenger.p_id
JOIN passenger_dropoff_desc ON passenger_dropoff_desc.p_id = passenger.p_id
LEFT JOIN flight_locations pickup  
       ON passenger.pickup_location = pickup.id
LEFT JOIN flight_locations dropoff 
       ON passenger.dropoff_location = dropoff.id
WHERE passenger.Create_job_action = 'completed' $extra_condition
ORDER BY 
CASE 
    WHEN YEAR(passenger.date_de_prise_en_charge) = YEAR(CURDATE())
     AND MONTH(passenger.date_de_prise_en_charge) = MONTH(CURDATE())
    THEN 0 
    ELSE 1 
END,
passenger.date_de_prise_en_charge,
passenger.Time
";
$result = mysqli_query($con, $query);

 $passager_principal=$row['passager_principal'];
          $date_de_prise_en_charge=$row['date_de_prise_en_charge'];
          $Time=$row['Time'];

          if ($row['pickup_location'] === 'others') {
    $pickup_location = 'Others';
} else {
    $pickup_location = $row['pickup_adr'];
}

// dropoff
if ($row['dropoff_location'] === 'others') {
    $dropoff_location = 'Others';
} else {
    $dropoff_location = $row['dropoff_adr'];
}

        $ppd_desc     = $row['ppd_desc'];
        $ppd_question = $row['ppd_question'];
        $pdd_desc     = $row['pdd_desc'];
        $pdd_question = $row['pdd_question'];



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
                      <th>Amount</th>
                      <th>Driver</th>
                      <th>Bookiing Provider</th>
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
                        <td><?= $row['Tarif']?></td>
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
                        <td>
                        <?php 
                        if ($row['wg_desc'] === 'No_wgOption') {
                          ?>
                            <p style=" color: red;font-weight: bold;">NO PROVIDER </p>
                            <?php
                        } else {
                          ?>
                            <?= $row['wg_desc']?>
                            <?php
                        }?>
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
   data-target="#modal-pdf"
   data-pid="<?= $row['p_id'] ?>"
   data-tarif="<?= htmlspecialchars($row['Tarif']) ?>">
   <i class="fas fa-download"></i>
</a>

 
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
$remaining = array_diff($statuses, array_keys($history));
$total = count($statuses);
$done  = count($history);
$percent = intval(($done / $total) * 100);
?>

<!-- Progress bar -->
<div class="progress mb-2" style="height: 10px;">
  <div class="progress-bar <?= $percent == 100 ? 'bg-success' : 'bg-info' ?>" 
       role="progressbar" style="width: <?= $percent ?>%;" 
       aria-valuenow="<?= $percent ?>" aria-valuemin="0" aria-valuemax="100">
  </div>
</div>
<small><?= $percent ?>% completed</small>

<?php if (!empty($remaining)): ?>
<!-- Status Form -->
<form method="post" class="status-form" data-ride-date="<?= htmlspecialchars(date('Y-m-d', strtotime($row['date_de_prise_en_charge']))) ?>">
  <input type="hidden" name="p_id" value="<?= $row['p_id'] ?>">
  <select name="status" class="form-control form-control-sm status-select" required>
    <option disabled selected>-- select status --</option>
    <?php foreach ($remaining as $st): ?>
      <option value="<?= $st ?>"><?= ucwords($st) ?></option>
    <?php endforeach; ?>
  </select>
</form>



<script>
$(document).ready(function() {
    $('.status-select').on('change', function() {
        var form = $(this).closest('.status-form');
        var bookingDate = form.data('ride-date'); // get ride date
        var p_id = form.find('input[name="p_id"]').val();
        var status = $(this).val();

        // Set hidden inputs in modal
        $('#modal_p_id').val(p_id);
        $('#modal_status').val(status);

        // ✅ Set date picker to booking date if available
        if (bookingDate) {
            $('#status_date').val(bookingDate);
        } else {
            // fallback to today
            var today = new Date().toISOString().slice(0,10);
            $('#status_date').val(today);
        }

        // Set time picker to current time
        var now = new Date();
        var timeStr = now.getHours().toString().padStart(2,'0') + ':' + now.getMinutes().toString().padStart(2,'0');
        $('#status_time').val(timeStr);

        // Show modal
        $('#statusModal').modal('show');
    });
});

</script>

<?php endif; ?>

<!-- Completed status list -->
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
<!-- Modal -->
<div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form method="post" id="modalStatusForm">
        <div class="modal-header">
          <h5 class="modal-title">Update Status</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="p_id" id="modal_p_id">
          <input type="hidden" name="status" id="modal_status">

          <div class="form-group">
            <label>Date</label>
            <input type="date" name="status_date" id="status_date" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Time</label>
            <input type="time" name="status_time" id="status_time" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="update_status" class="btn btn-warning">Update</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>


<!--BLOCK#3 START DON'T CHANGE THE ORDER-->
<?php include_once("footer.php"); ?>
<!--END DON'T CHANGE THE ORDER-->