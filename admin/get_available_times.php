<?php
include '../config.php';

if (!isset($_GET['date'])) {
    echo json_encode([]);
    exit;
}

$date = $_GET['date'];
$BLOCK_DURATION_MINUTES = 30;

// Generate all 24 hours in 30-min increments
$all_times = [];
for ($h = 0; $h < 24; $h++) {
    foreach ([0, 30] as $m) {
        $all_times[] = sprintf("%02d:%02d", $h, $m);
    }
}

// 1️⃣ Get blocked times from booking_unavailability
$blocked = [];
$q1 = $con->prepare("
    SELECT start_time, end_time
    FROM booking_unavailability
    WHERE start_date = ?
");
$q1->bind_param("s", $date);
$q1->execute();
$r1 = $q1->get_result();
while ($row = $r1->fetch_assoc()) {
    if ($row['start_time'] === null && $row['end_time'] === null) {
        // Full day block → all times blocked
        $blocked = $all_times;
        break;
    }
    $start = strtotime($row['start_time']);
    $end   = strtotime($row['end_time']);
    for ($t = $start; $t < $end; $t += $BLOCK_DURATION_MINUTES * 60) {
        $blocked[] = date("H:i", $t);
    }
}

// 2️⃣ Get blocked times from flight_passenger (user bookings)
$q2 = $con->prepare("
    SELECT pickup_time
    FROM flight_passenger
    WHERE trip_date = ?
");
$q2->bind_param("s", $date);
$q2->execute();
$r2 = $q2->get_result();
while ($row = $r2->fetch_assoc()) {
    $start = strtotime($row['pickup_time']);
    $end   = $start + $BLOCK_DURATION_MINUTES * 60;
    for ($t = $start; $t < $end; $t += $BLOCK_DURATION_MINUTES * 60) {
        $blocked[] = date("H:i", $t);
    }
}

// Remove duplicates & calculate available times
$blocked = array_unique($blocked);
$available = array_values(array_diff($all_times, $blocked));

header('Content-Type: application/json');
echo json_encode([
    'available' => $available,
    'blocked'   => array_values($blocked)
]);
