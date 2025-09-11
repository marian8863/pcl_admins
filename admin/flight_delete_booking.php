<?php
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $booking_id = $_POST['booking_id'];
    $reason = $_POST['reason'];

    // Fetch the original booking
    $stmt = $con->prepare("SELECT * FROM flight_passenger WHERE id = ?");
    $stmt->bind_param("i", $booking_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $booking = $result->fetch_assoc();

    if ($booking) {
        // Insert into deleted_bookings
        $insert = $con->prepare("
            INSERT INTO flight_deleted_bookings (
                passenger_name, contact_number, trip_date, pickup_time,
                pickup_location, pickup_description, dropoff_location, dropoff_description,
                price, options, booked_by, deleted_reason
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $insert->bind_param("ssssssssssis",
            $booking['passenger_name'],
            $booking['contact_number'],
            $booking['trip_date'],
            $booking['pickup_time'],
            $booking['pickup_location'],
            $booking['pickup_description'],
            $booking['dropoff_location'],
            $booking['dropoff_description'],
            $booking['price'],
            $booking['options'],
            $booking['booked_by'],
            $reason
        );

        if ($insert->execute()) {
            // Delete original record
            $del = $con->prepare("DELETE FROM flight_passenger WHERE id = ?");
            $del->bind_param("i", $booking_id);
            $del->execute();

            echo "Booking deleted successfully.";
        } else {
            echo "Failed to archive booking: " . $insert->error;
        }
    } else {
        echo "Booking not found.";
    }
}
?>
