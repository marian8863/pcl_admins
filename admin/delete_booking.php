<?php
session_start();
include '../config.php';

$user_type = $_SESSION['user']['user_type'] ?? '';
$user_id = $_SESSION['user']['id'] ?? 0;

$id = intval($_POST['id'] ?? 0);
$status = $_POST['status'] ?? '';
$delete_reason = $_POST['delete_reason'] ?? '';

if ($id && $status === 'pending' && in_array($user_type, ['user']) && !empty($delete_reason)) {


    // 2. Re-select the updated booking details
    $stmt = $con->prepare("SELECT id, passenger_name, trip_date, pickup_time, pickup_location, dropoff_location, status 
                           FROM flight_passenger WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result  = $stmt->get_result();
    $booking = $result->fetch_assoc();
    $stmt->close();

    // 3. Insert into flight_passenger_deletes (with updated status)
    if ($booking) {
        $stmtInsert = $con->prepare("
            INSERT INTO flight_passenger_deletes
            (booking_id, passenger_name, trip_date, pickup_time, pickup_location, dropoff_location, status, deleted_by, delete_reason, deleted_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
        ");
        $stmtInsert->bind_param(
            "issssssis",
            $booking['id'], $booking['passenger_name'], $booking['trip_date'],
            $booking['pickup_time'], $booking['pickup_location'], $booking['dropoff_location'],
            $booking['status'], $user_id, $delete_reason
        );
        $stmtInsert->execute();
        $stmtInsert->close();

        // 4. Delete from flight_passenger
        $stmtDelete = $con->prepare("DELETE FROM flight_passenger WHERE id = ?");
        $stmtDelete->bind_param("i", $id);
        $stmtDelete->execute();
        $stmtDelete->close();
    }
}

header("Location: view_flight_booking_form");
exit;
