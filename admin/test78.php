<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Pickup & Dropoff</title>
  <style>
    .text-muted {
      color: #999;
    }
  </style>
</head>
<body>
  <label for="pickup_location">Pickup Location:</label>
  <select id="pickup_location">
    <option value="">-- Select Pickup --</option>
    <option value="GARE DU NORD">GARE DU NORD</option>
    <option value="ST. LAZARE">ST. LAZARE</option>
    <option value="CHARLES DE GAULLE">CHARLES DE GAULLE</option>
  </select>

  <br><br>

  <label for="dropoff_location">Drop-off Location:</label>
  <select id="dropoff_location">
    <option value="">-- Select Drop-off --</option>
    <option value="GARE DU NORD">GARE DU NORD</option>
    <option value="ST. LAZARE">ST. LAZARE</option>
    <option value="CHARLES DE GAULLE">CHARLES DE GAULLE</option>
  </select>

  <script>
  const pickupSelect = document.getElementById('pickup_location');
  const dropoffSelect = document.getElementById('dropoff_location');

  let pickupClicked = 0;
  let dropoffClicked = 0;

  function enableAllOptions(select) {
    for (let option of select.options) {
      option.disabled = false;
      option.classList.remove("text-muted");
    }
  }

  function syncDropdowns() {
    const pickupVal = pickupSelect.value;
    const dropoffVal = dropoffSelect.value;

    enableAllOptions(pickupSelect);
    enableAllOptions(dropoffSelect);

    // Disable the same value in opposite dropdown
    for (let option of dropoffSelect.options) {
      if (option.value === pickupVal && option.value !== "") {
        option.disabled = true;
        option.classList.add("text-muted");
      }
    }

    for (let option of pickupSelect.options) {
      if (option.value === dropoffVal && option.value !== "") {
        option.disabled = true;
        option.classList.add("text-muted");
      }
    }
  }

  pickupSelect.addEventListener('mousedown', () => {
    pickupClicked++;
    if (pickupClicked > 1) {
      enableAllOptions(dropoffSelect); // only after first click
    }
  });

  dropoffSelect.addEventListener('mousedown', () => {
    dropoffClicked++;
    if (dropoffClicked > 1) {
      enableAllOptions(pickupSelect); // only after first click
    }
  });

  pickupSelect.addEventListener('change', syncDropdowns);
  dropoffSelect.addEventListener('change', syncDropdowns);

  window.addEventListener('DOMContentLoaded', syncDropdowns);
</script>

</body>
</html>
