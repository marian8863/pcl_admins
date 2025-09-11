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

// Fetch locations
$locations = [];
$result = $con->query("SELECT id, name FROM flight_locations ORDER BY name ASC");
while ($row = $result->fetch_assoc()) {
    $locations[] = $row;
}

// Default empty booking (Add Mode)
$booking = [
    'passenger_name' => '',
    'contact_number' => '',
    'trip_date' => '',
    'pickup_time' => '',
    'pickup_location' => '',
    'pickup_description' => '',
    'dropoff_location' => '',
    'dropoff_description' => '',
    'price' => '',
    'options' => ''
];
$is_update = false;

// Update mode
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $is_update = true;
    $stmt = $con->prepare("SELECT * FROM flight_passenger WHERE id = ?");
    if (!$stmt) {
        die("Prepare failed: " . $con->error);
    }
    $stmt->bind_param("i", $_GET['id']);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res->num_rows > 0) {
        $booking = $res->fetch_assoc();
    } else {
        die("Booking not found.");
    }
}


// Fetch blocked times from DB
$blocked_slots = [];
$res = $con->query("SELECT start_date, start_time, end_time FROM booking_unavailability");
if ($res) {
    while ($row = $res->fetch_assoc()) {
        $blocked_slots[] = $row;
    }
}
$blocked_json = json_encode($blocked_slots);
?>

<link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet"/>
<style>
  .time-slot {
    margin: 5px 5px 5px 0;
    cursor: pointer;
    padding: 8px 12px;
    border: 1px solid #007bff;
    border-radius: 4px;
    display: inline-block;
    color: #007bff;
    user-select: none;
  }
  .time-slot.selected {
    background-color: #007bff;
    color: white;
  }
  .time-slot.disabled {
    border-color: #ccc;
    color: #ccc;
    cursor: not-allowed;
    user-select: none;
  }
</style>

<div class="container mt-4">
<title><?= $is_update ? "Update" : "Add" ?> Booking</title>
  <form method="post" action="flight_submit_booking">

    <?php if ($is_update): ?>
    <input type="hidden" name="id" value="<?= (int)$booking['id'] ?>">
  <?php endif; ?>
    
    <div class="mb-3">
      <label>Passenger Name</label>
        <input type="text" name="passenger_name" class="form-control" 
                   value="<?= htmlspecialchars($booking['passenger_name']) ?>" required>
    </div>

    <div class="mb-3">
            <label>Contact Number</label><br>
            <input type="radio" name="enable_contact" 
                   onclick="document.getElementById('contact_number').disabled=false;"
                   <?= !empty($booking['contact_number']) ? 'checked' : '' ?>> On
            <input type="radio" name="enable_contact" 
                   onclick="document.getElementById('contact_number').disabled=true;"
                   <?= empty($booking['contact_number']) ? 'checked' : '' ?>> Off
            <input type="text" name="contact_number" id="contact_number" class="form-control mt-2" 
                   value="<?= htmlspecialchars($booking['contact_number']) ?>" 
                   <?= empty($booking['contact_number']) ? 'disabled' : '' ?>>
    </div>

    <div class="mb-3">
      <label for="trip_date">Select Date</label>
      <input type="text" id="trip_date" name="trip_date" value="<?= htmlspecialchars($booking['trip_date']) ?>" class="form-control" autocomplete="off" required>
    </div>

    <div class="mb-3">
      <label>Select Time Slot</label>
      <div id="time_slots" class="d-flex flex-wrap"></div>
      <input type="hidden" name="pickup_time" value="<?= htmlspecialchars($booking['pickup_time']) ?>" id="pickup_time" required>
    </div>

        <!-- Pickup Location -->
        <div class="mb-3">
            <label>Pickup Location</label>
            <select name="pickup_location" id="pickup_location" class="form-select" required>
                <option value="">-- Select --</option>
                <?php foreach ($locations as $loc): ?>
                    <option value="<?= $loc['id'] ?>" <?= ($loc['id'] == $booking['pickup_location']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($loc['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <textarea name="pickup_description" id="pickup_desc" class="form-control mt-2" 
                      placeholder="Pickup Description" 
                      style="<?= $booking['pickup_location'] ? '' : 'display:none;' ?>"><?= htmlspecialchars($booking['pickup_description']) ?></textarea>
        </div>

        <!-- Dropoff Location -->
        <div class="mb-3">
            <label>Drop-off Location</label>
            <select name="dropoff_location" id="dropoff_location" class="form-select" required>
                <option value="">-- Select --</option>
                <?php foreach ($locations as $loc): ?>
                    <option value="<?= $loc['id'] ?>" <?= ($loc['id'] == $booking['dropoff_location']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($loc['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <textarea name="dropoff_description" id="dropoff_desc" class="form-control mt-2" 
                      placeholder="Drop-off Description" 
                      style="<?= $booking['dropoff_location'] ? '' : 'display:none;' ?>"><?= htmlspecialchars($booking['dropoff_description']) ?></textarea>
        </div>

        <div class="mb-3">
            <label>Price</label><br>
            <input type="radio" name="enable_price" 
                   onclick="document.getElementById('price').disabled=false;"
                   <?= !empty($booking['price']) ? 'checked' : '' ?>> On
            <input type="radio" name="enable_price" 
                   onclick="document.getElementById('price').disabled=true;"
                   <?= empty($booking['price']) ? 'checked' : '' ?>> Off
            <input type="number" step="0.01" name="price" id="price" class="form-control mt-2"
                   value="<?= htmlspecialchars($booking['price']) ?>" 
                   <?= empty($booking['price']) ? 'disabled' : '' ?>>
        </div>

        <div class="mb-3">
            <label>Options</label><br>
            <input type="radio" name="enable_option" 
                   onclick="document.getElementById('options').disabled=false;"
                   <?= !empty($booking['options']) ? 'checked' : '' ?>> On
            <input type="radio" name="enable_option" 
                   onclick="document.getElementById('options').disabled=true;"
                   <?= empty($booking['options']) ? 'checked' : '' ?>> Off
            <textarea name="options" id="options" class="form-control mt-2" rows="3"
                      <?= empty($booking['options']) ? 'disabled' : '' ?>><?= htmlspecialchars($booking['options']) ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">
            <?= $is_update ? 'Update Booking' : 'Submit Booking' ?>
        </button>
     </form>
</div>


<script>
  document.getElementById('pickup_location').addEventListener('change', function () {
    document.getElementById('pickup_desc').style.display = this.value ? 'block' : 'none';
  });
  document.getElementById('dropoff_location').addEventListener('change', function () {
    document.getElementById('dropoff_desc').style.display = this.value ? 'block' : 'none';
  });

  function syncDropdowns() {
      const pickupSelect = document.getElementById('pickup_location');
      const dropoffSelect = document.getElementById('dropoff_location');
      const selectedPickup = pickupSelect.value;
      const selectedDropoff = dropoffSelect.value;

      for (let option of dropoffSelect.options) {
          if (option.value) {
              option.disabled = (option.value === selectedPickup);
              option.classList.toggle("text-muted", option.disabled);
          }
      }
      for (let option of pickupSelect.options) {
          if (option.value) {
              option.disabled = (option.value === selectedDropoff);
              option.classList.toggle("text-muted", option.disabled);
          }
      }
      if (selectedPickup === selectedDropoff && selectedPickup) {
          dropoffSelect.value = "";
      }
  }
  document.getElementById('pickup_location').addEventListener('change', syncDropdowns);
  document.getElementById('dropoff_location').addEventListener('change', syncDropdowns);
  window.addEventListener('DOMContentLoaded', syncDropdowns);
</script>


<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
const blockedSlots = <?= $blocked_json ?>;
const blockedByDate = {};
blockedSlots.forEach(slot => {
  const date = slot.start_date;
  if (!blockedByDate[date]) blockedByDate[date] = [];
  blockedByDate[date].push({ start: slot.start_time, end: slot.end_time });
});

const tripDateInput = document.getElementById('trip_date');
const timeSlotsContainer = document.getElementById('time_slots');
const pickupTimeInput = document.getElementById('pickup_time');
const SLOT_MINUTES = 30;

function toMinutes(t) {
  const [h, m] = t.split(':').map(Number);
  return h * 60 + m;
}
function fromMinutes(m) {
  const h = Math.floor(m / 60);
  const min = m % 60;
  return (h < 10 ? '0' : '') + h + ":" + (min < 10 ? '0' : '') + min;
}
function generateAllSlots() {
  let slots = [];
  for (let time = 0; time < 24 * 60; time += SLOT_MINUTES) {
    slots.push(time);
  }
  return slots;
}
function isSlotBlocked(slotStart, blockedIntervals) {
  for (const blocked of blockedIntervals) {
    const bStart = toMinutes(blocked.start);
    const bEnd = toMinutes(blocked.end || blocked.start);
    if (slotStart >= bStart && slotStart < bEnd) return true;
  }
  return false;
}
function isDateFullyBlocked(date) {
  if (!blockedByDate[date]) return false;
  return blockedByDate[date].some(blocked => {
    const bStart = toMinutes(blocked.start);
    const bEnd = toMinutes(blocked.end || blocked.start);
    return bStart <= 0 && bEnd >= 24 * 60;
  });
}
function renderSlots(allSlots, blockedIntervals) {
  timeSlotsContainer.innerHTML = "";
  let anyAvailable = false;
  allSlots.forEach(slotStart => {
    const slotText = fromMinutes(slotStart);
    const div = document.createElement('div');
    div.classList.add('time-slot');
    div.textContent = slotText;
    div.setAttribute('data-time', slotText);
    if (isSlotBlocked(slotStart, blockedIntervals)) {
      div.classList.add('disabled');
    } else {
      anyAvailable = true;
      div.addEventListener('click', () => {
        document.querySelectorAll('.time-slot.selected').forEach(el => el.classList.remove('selected'));
        div.classList.add('selected');
        pickupTimeInput.value = slotText;
      });
    }
    timeSlotsContainer.appendChild(div);
  });
  if (!anyAvailable) {
    timeSlotsContainer.innerHTML = "<div class='text-danger'>No available time slots for this date.</div>";
    pickupTimeInput.value = "";
  }
}

flatpickr(tripDateInput, {
  dateFormat: "Y-m-d",
  disable: [
    function(date) {
      return isDateFullyBlocked(date.toISOString().slice(0, 10));
    }
  ],
  onChange: function(selectedDates, dateStr) {
    const blockedForDate = blockedByDate[dateStr] || [];
    renderSlots(generateAllSlots(), blockedForDate);
  }
});
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