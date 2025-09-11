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





<!--BLOCK#2 START YOUR CODE HERE -->
  <!-- Content Wrapper. Contains page content -->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

  <div>
    <!-- Content Header (Page header) -->
         <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <!-- <h1 class="m-0 text-dark">Create Job Detail</h1> -->
          </div><!-- /.col -->
          <div class="col-sm-6">
            <!-- <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Create Job Detail
              <php
                  // echo  $Sdate = new DateTime("now", new DateTimeZone('Asia/Colombo'));
                  // date_default_timezone_set('Asia/Colombo');
                  // $date = date('d-m-y h:i:s');
                  // echo $date;
              ?>
              </li>
            </ol> -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

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


              <?php




// if (!$u_id || !in_array($u_t, ['admin','ADM','Admin'])) {
//     echo "Access denied.";
//     exit;
// }

$flash = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['dates']) && is_array($_POST['dates'])) {
        $dates = $_POST['dates'];
        $times_start = $_POST['times_start'] ?? [];
        $times_end = $_POST['times_end'] ?? [];
        $reasons = $_POST['reasons'] ?? [];

        $stmt = $con->prepare("INSERT INTO booking_unavailability 
            (start_date, end_date, start_time, end_time, reason, created_by, created_by_username)
            VALUES (?, ?, ?, ?, ?, ?, ?)");
        if (!$stmt) {
            $flash = "Prepare failed: " . $con->error;
        } else {
            $count = 0;
            for ($i = 0; $i < count($dates); $i++) {
                $d = trim($dates[$i]);
                if (!$d) continue;

                $ts = trim($times_start[$i] ?? '');
                $te = trim($times_end[$i] ?? '');
                $r = trim($reasons[$i] ?? '');

                // Validate date format
                $dateObj = DateTime::createFromFormat('Y-m-d', $d);
                if (!$dateObj) continue;

                $start_date = $dateObj->format('Y-m-d');
                $end_date = $start_date;

                // Validate time format or set null
                $start_time = null;
                if ($ts) {
                    $tobj = DateTime::createFromFormat('H:i', $ts) ?: DateTime::createFromFormat('H:i:s', $ts);
                    $start_time = $tobj ? $tobj->format('H:i:s') : null;
                }
                $end_time = null;
                if ($te) {
                    $tobj = DateTime::createFromFormat('H:i', $te) ?: DateTime::createFromFormat('H:i:s', $te);
                    $end_time = $tobj ? $tobj->format('H:i:s') : null;
                }

                $stmt->bind_param("sssssis", $start_date, $end_date, $start_time, $end_time, $r, $u_id, $u_n);
                if ($stmt->execute()) $count++;
            }
            $flash = "Saved $count unavailable slot(s).";
        }
    } elseif (isset($_POST['delete_id'])) {
        $del_id = intval($_POST['delete_id']);
        $stmt = $con->prepare("DELETE FROM booking_unavailability WHERE id = ?");
        $stmt->bind_param("i", $del_id);
        if ($stmt->execute()) {
            $flash = "Deleted entry #$del_id.";
        } else {
            $flash = "Delete failed: " . $stmt->error;
        }
    }
}

// Fetch all existing unavailability
$res = $con->query("SELECT * FROM booking_unavailability ORDER BY start_date DESC, start_time DESC, id DESC");
$existing = $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
?>

<link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet"/>
<style>
.container { max-width: 900px; margin-top: 30px; }
.availability-row > * { margin-right: 10px; }
.availability-row { display: flex; align-items: center; margin-bottom: 10px; }
.availability-row input { max-width: 150px; }
.availability-row button.remove-row { margin-left: 10px; }
</style>

<div class="container">
    <h2>Booking Availability Management (Admin / ADM)</h2>
    <?php if ($flash): ?>
        <div class="alert alert-info"><?= htmlspecialchars($flash) ?></div>
    <?php endif; ?>

    <form method="post" id="availabilityForm">
        <div id="availability-list">
            <div class="availability-row">
                <input type="text" name="dates[]" class="date-picker form-control" placeholder="Date (YYYY-MM-DD)" required />
                <input type="text" name="times_start[]" class="time-picker form-control" placeholder="Start Time (HH:MM)" />
                <input type="text" name="times_end[]" class="time-picker form-control" placeholder="End Time (HH:MM)" />
                <input type="text" name="reasons[]" class="form-control" placeholder="Reason (optional)" />
                <button type="button" class="btn btn-danger remove-row" title="Remove row">&times;</button>
            </div>
        </div>
        <button type="button" class="btn btn-secondary mb-3" id="add-row-btn">Add Unavailable Slot</button>
        <br />
        <button type="submit" class="btn btn-primary">Save Unavailability</button>
    </form>

    <hr />

    <h4>Existing Unavailable Slots</h4>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Time</th>
                <th>Reason</th>
                <th>Added By</th>
                <th>Created At</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
        <?php if (count($existing) === 0): ?>
            <tr><td colspan="7" class="text-center">No unavailable slots.</td></tr>
        <?php else: foreach ($existing as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['id']) ?></td>
                <td><?= htmlspecialchars($row['start_date']) ?></td>
                <td>
                    <?php
                    if ($row['start_time']) {
                        if ($row['end_time'] && $row['end_time'] !== $row['start_time']) {
                            echo htmlspecialchars(substr($row['start_time'],0,5) . " - " . substr($row['end_time'],0,5));
                        } else {
                            echo htmlspecialchars(substr($row['start_time'],0,5));
                        }
                    } else {
                        echo "<em>All day</em>";
                    }
                    ?>
                </td>
                <td><?= htmlspecialchars($row['reason'] ?: '-') ?></td>
                <td><?= htmlspecialchars($row['created_by_username'] ?: $row['created_by']) ?></td>
                <td><?= htmlspecialchars($row['created_at']) ?></td>
                <td>
                    <form method="post" onsubmit="return confirm('Delete this slot?');">
                        <input type="hidden" name="delete_id" value="<?= (int)$row['id'] ?>" />
                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; endif; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
function initPickers(context=document) {
    flatpickr(context.querySelectorAll('.date-picker'), {
        dateFormat: "Y-m-d",
        allowInput: true
    });
    flatpickr(context.querySelectorAll('.time-picker'), {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true,
        allowInput: true
    });
}

document.getElementById('add-row-btn').addEventListener('click', () => {
    const container = document.getElementById('availability-list');
    const newRow = document.createElement('div');
    newRow.className = 'availability-row';
    newRow.innerHTML = `
        <input type="text" name="dates[]" class="date-picker form-control" placeholder="Date (YYYY-MM-DD)" required />
        <input type="text" name="times_start[]" class="time-picker form-control" placeholder="Start Time (HH:MM)" />
        <input type="text" name="times_end[]" class="time-picker form-control" placeholder="End Time (HH:MM)" />
        <input type="text" name="reasons[]" class="form-control" placeholder="Reason (optional)" />
        <button type="button" class="btn btn-danger remove-row" title="Remove row">&times;</button>
    `;
    container.appendChild(newRow);
    initPickers(newRow);
});

document.getElementById('availability-list').addEventListener('click', (e) => {
    if (e.target.classList.contains('remove-row')) {
        e.target.closest('.availability-row').remove();
    }
});

// Initialize first row date/time pickers
initPickers();
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