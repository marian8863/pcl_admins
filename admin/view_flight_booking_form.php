<!-- BLOCK#1 START DON'T CHANGE THE ORDER-->
<?php
$title = "Home | SLGTI";

include_once("head.php");
include_once("menu.php");

$u_n = $_SESSION['user']['username'];
$u_t = $_SESSION['user']['user_type'];
$u_p = $_SESSION['user']['profile'];



?>
<!--END DON'T CHANGE THE ORDER-->

<?php

?>

<!-- Delete Modal -->
<div id="deleteModal" style="display:none;">
    <form id="deleteForm" method="post" action="flight_delete_booking">
        <input type="hidden" name="booking_id" id="delete_booking_id">
        <label for="delete_reason">Why are you deleting this booking?</label>
        <textarea name="reason" id="delete_reason" class="form-control" required></textarea>
        <br>
        <button type="submit" class="btn btn-danger">Confirm Delete</button>
        <button type="button" onclick="closeDeleteModal()" class="btn btn-secondary">Cancel</button>
    </form>
</div>

<script>
function openDeleteModal(btn) {
    const id = btn.getAttribute('data-id');
    document.getElementById('delete_booking_id').value = id;
    document.getElementById('deleteModal').style.display = 'block';
}

function closeDeleteModal() {
    document.getElementById('deleteModal').style.display = 'none';
}
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
            <h1 class="m-0 text-dark">View Booking</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item ">View Booking
              <?php
                  // echo  $Sdate = new DateTime("now", new DateTimeZone('Asia/Colombo'));
                  // date_default_timezone_set('UTC');

                  // // Get the current date and time
                  // $currentDateTime = date('Y-m-d H:i:s');
                  
                  // // Display the current date and time
                  // echo "Current Date and Time: " . $currentDateTime;
              ?>
              </li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

  <!-- Main content -->
                  
  <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <!-- <div class="card-header">
                <h3 class="card-title">DataTable with minimal features & hover style</h3>
              </div> -->
              <!-- /.card-header -->

              <div class="card-body">
              <div class="row">
                <div class="col-9">
                </div>
                <!-- /.col -->
                <div class="col-3">
                    <a href="flight_booking_form" class="btn btn-primary btn-block"> + Create Booking</a>

                </div>
                </div>
                <br>
<?php


// Example: $_SESSION['user']['user_type'] = 'admin'; // or 'ADM' or 'user'
// Example: $_SESSION['user']['id'] = 1;

$user_type = $_SESSION['user']['user_type'] ?? '';
$user_id   = $_SESSION['user']['id'] ?? 0;

$query = "
SELECT 
    f.id,
    f.passenger_name,
    f.trip_date,
    f.pickup_time,
    pl.name AS pickup_name,
    dl.name AS dropoff_name,
    f.status,
    f.change_reason
FROM 
    flight_passenger f
JOIN flight_locations pl ON f.pickup_location = pl.id
JOIN flight_locations dl ON f.dropoff_location = dl.id
ORDER BY f.id DESC 
";
$result = $con->query($query);
?>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Passenger</th>
            <th>Trip Date</th>
            <th>Pickup Time</th>
            <th>Pickup</th>
            <th>Drop-off</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['passenger_name']) ?></td>
            <td><?= $row['trip_date'] ?></td>
            <td><?= $row['pickup_time'] ?></td>
            <td><?= htmlspecialchars($row['pickup_name']) ?></td>
            <td><?= htmlspecialchars($row['dropoff_name']) ?></td>
            <td><span class="badge bg-info"><?= $row['status'] ?></span></td>
            <td>
                <?php if (in_array($user_type, ['admin', 'ADM'])): ?>
                    <?php if ($row['status'] == 'pending'): ?>
                        <button class="btn btn-sm btn-success" onclick="updateStatus(<?= $row['id'] ?>,'confirm')">Confirm Booking</button>
                        <button class="btn btn-sm btn-danger" onclick="openCancelModal(<?= $row['id'] ?>)">Cancel Booking</button>
                    <?php elseif ($row['status'] == 'confirm'): ?>
                        <button class="btn btn-sm btn-warning" onclick="updateStatus(<?= $row['id'] ?>,'finished ride')">Ride Ready</button>
                    <?php elseif ($row['status'] == 'finished ride'): ?>
                        <button class="btn btn-sm btn-primary">Create Invoice</button>
                    <?php elseif ($row['status'] == 'need to change'): ?>
                        <button class="btn btn-sm btn-secondary" onclick="updateStatus(<?= $row['id'] ?>,'waiting reply')">Waiting Reply</button>
                    <?php elseif ($row['status'] == 'waiting reply'): ?>
                    <button class="btn btn-sm btn-danger" onclick="openNoResponseModal(<?= $row['id'] ?>)">No Response</button>                    
                    <?php endif; ?>

                <?php elseif ($user_type == 'user'): ?>
                    <?php if ($row['status'] == 'pending'): ?>
                        <a href="flight_booking_form?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                        <button class="btn btn-sm btn-danger" onclick="openDeleteModal(<?= $row['id'] ?>)">Delete</button>
                    <?php elseif ($row['status'] == 'need to change'): ?>
                        <a href="flight_booking_form?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                  <?php elseif ($row['status'] == 'finished ride'): ?>
                      <?php if ($row['status'] == 'invoice release'): ?>
                          <a href="invoice.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-info">View Invoice</a>
                      <?php else: ?>
                          <button class="btn btn-sm btn-info" onclick="alert('Admin has not created the invoice yet.')">Loading Invoice</button>
                      <?php endif; ?>
                    <?php elseif ($row['status'] == 'waiting reply'): ?>
                        <a href="flight_booking_form?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                    <?php endif; ?>
                <?php endif; ?>
            </td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>

<div class="modal fade" id="noResponseModal" tabindex="-1" aria-labelledby="noResponseModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="noResponseForm" method="POST" action="update_status">
      <input type="hidden" name="id" id="noResponseId" value="">
      <input type="hidden" name="status" value="ride cancel">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="noResponseModalLabel">No Response - Cancel Booking</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <label for="delete_reason">Please enter reason for ride cancellation:</label>
          <textarea name="delete_reason" id="delete_reason" class="form-control" required></textarea>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-danger">Confirm Cancel</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </form>
  </div>
</div>

<div class="modal" id="deleteModal">
    <div class="modal-dialog">
        <form id="deleteForm" method="POST" action="delete_booking">
            <input type="hidden" name="id" id="delete_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Delete Booking</h5>
                </div>
                <div class="modal-body">
                    <textarea name="reason" class="form-control" placeholder="Reason for delete" required></textarea>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger">Delete</button>
                </div>
            </div>
        </form>
    </div>
</div>


<!-- Cancel Modal -->
<div class="modal" id="cancelModal">
    <div class="modal-dialog">
        <form id="cancelForm" method="POST" action="update_status">
            <input type="hidden" name="id" id="cancel_id">
            <input type="hidden" name="status" value="waiting reply">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Cancel Booking</h5>
                </div>
                <div class="modal-body">
                    <textarea name="change_reason" class="form-control" placeholder="Reason for change" required></textarea>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Delete Modal -->


<script>
function updateStatus(id, status) {
    if(confirm("Are you sure to update status to " + status + "?")) {
        window.location.href = "update_status?id=" + id + "&status=" + status;
    }
}

function openCancelModal(id) {
    document.getElementById("cancel_id").value = id;
    document.getElementById("cancelModal").style.display = "block";
}

function openDeleteModal(id) {
    document.getElementById("delete_id").value = id;
    document.getElementById("deleteModal").style.display = "block";
}

function openNoResponseModal(id) {
    var noResponseIdInput = document.getElementById('noResponseId');
    noResponseIdInput.value = id;
    var noResponseModal = new bootstrap.Modal(document.getElementById('noResponseModal'));
    noResponseModal.show();
}

</script>






  
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
    <!-- /.content -->
  </div>

    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- /.content-wrapper -->

	<!-- END DELETE MODEL -->

<!--BLOCK#2 end YOUR CODE HERE -->


<!--BLOCK#3 START DON'T CHANGE THE ORDER-->
<?php include_once("footer.php"); ?>
<!--END DON'T CHANGE THE ORDER-->