<!-- BLOCK#1 START DON'T CHANGE THE ORDER-->
<?php
$title = "Home | SLGTI";

include_once("head.php");
include_once("menu.php");

$u_n = $_SESSION['user']['username'];
$u_t = $_SESSION['user']['user_type'];
$u_p = $_SESSION['user']['profile'];
$u_id = $_SESSION['user']['id'];
?>
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
?>
<title><?= $is_update ? "Update" : "Add" ?> Booking</title>

<div class="container">
    <h2 class="mb-4"><?= $is_update ? "Update" : "Add" ?> Taxi Booking</h2>

    <form action="flight_submit_booking" method="post">
        <?php if ($is_update): ?>
            <input type="hidden" name="id" value="<?= htmlspecialchars($_GET['id']) ?>">
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
            <label>Date of Trip</label>
            <input type="date" name="trip_date" class="form-control"
                   value="<?= htmlspecialchars($booking['trip_date']) ?>" required>
        </div>

        <div class="mb-3">
            <label>Pickup Time</label>
            <input type="time" name="pickup_time" class="form-control"
                   value="<?= htmlspecialchars($booking['pickup_time']) ?>" required>
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



<!--BLOCK#3 START DON'T CHANGE THE ORDER-->
<?php include_once("footer.php"); ?>
<!--END DON'T CHANGE THE ORDER-->
