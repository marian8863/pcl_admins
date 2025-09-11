<?php
include '../config.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $passenger_name       = $_POST['passenger_name'];
    $trip_date            = date('Y-m-d', strtotime($_POST['trip_date']));
    $pickup_time          = date('H:i:s', strtotime($_POST['pickup_time']));
    $pickup_location      = $_POST['pickup_location'];
    $pickup_description   = $_POST['pickup_description'];
    $dropoff_location     = $_POST['dropoff_location'];
    $dropoff_description  = $_POST['dropoff_description'];
    $booked_by            = $_SESSION['user']['id'];
    $booked_by_username   = $_SESSION['user']['username'];
    $user_type            = $_SESSION['user']['user_type'];

    // Optional fields
    $contact_number = $_POST['contact_number'] ?? null;
    $price          = $_POST['price'] ?? null;
    $options        = $_POST['options'] ?? null;

    // Calculate end_time (+30 minutes)
    $pickup_dt = new DateTime("$trip_date $pickup_time");
    $pickup_dt->modify('+30 minutes');
    $end_time = $pickup_dt->format('H:i:s');

if (!empty($_POST['id']) && is_numeric($_POST['id'])) {
    // --- UPDATE mode ---

    $booking_id = (int)$_POST['id'];

    // Fetch existing booking's unavailability_id and status
    $stmtOld = $con->prepare("SELECT unavailability_id, status FROM flight_passenger WHERE id = ?");
    $stmtOld->bind_param("i", $booking_id);
    $stmtOld->execute();
    $stmtOld->bind_result($old_unavailability_id, $current_status);
    $stmtOld->fetch();
    $stmtOld->close();

    // If current status is 'waiting reply', set it to 'pending'
    if ($current_status === 'waiting reply') {
        $stmtStatus = $con->prepare("UPDATE flight_passenger SET status='pending' WHERE id=?");
        $stmtStatus->bind_param("i", $booking_id);
        if (!$stmtStatus->execute()) {
            die("Status update failed: " . $stmtStatus->error);
        }
        $stmtStatus->close();
    }

    // Update flight_passenger with new data (keep status unless above changed it)
    $stmt = $con->prepare("
        UPDATE flight_passenger
        SET passenger_name=?, contact_number=?, trip_date=?, pickup_time=?, 
            pickup_location=?, pickup_description=?, dropoff_location=?, dropoff_description=?, 
            price=?, options=?, booked_by=?
        WHERE id=?
    ");
    $stmt->bind_param(
        "ssssisssdsii", 
        $passenger_name, $contact_number, $trip_date, $pickup_time,
        $pickup_location, $pickup_description, $dropoff_location, $dropoff_description,
        $price, $options, $booked_by, $booking_id
    );
    if (!$stmt->execute()) {
        die("Booking update failed: " . $stmt->error);
    }
    $stmt->close();

    // Update booking_unavailability for user type 'user' if unavailability_id exists
    if ($user_type === 'user' && $old_unavailability_id) {
        $stmtUpdate = $con->prepare("
            UPDATE booking_unavailability
            SET start_date=?, end_date=?, start_time=?, end_time=?, reason='user booked',
                created_by=?, created_by_username=?
            WHERE id=?
        ");
        $stmtUpdate->bind_param(
            "ssssssi",
            $trip_date, $trip_date, $pickup_time, $end_time,
            $booked_by, $booked_by_username, $old_unavailability_id
        );
        if (!$stmtUpdate->execute()) {
            die("Unavailability update failed: " . $stmtUpdate->error);
        }
        $stmtUpdate->close();
    }

}else {
        // --- INSERT mode ---

        // Insert booking without unavailability_id first (NULL)
        $stmt = $con->prepare("
            INSERT INTO flight_passenger
            (passenger_name, contact_number, trip_date, pickup_time, 
             pickup_location, pickup_description, dropoff_location, dropoff_description,
             price, options, booked_by, unavailability_id)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NULL)
        ");
        $stmt->bind_param(
            "ssssisssdsi", 
            $passenger_name, $contact_number, $trip_date, $pickup_time,
            $pickup_location, $pickup_description, $dropoff_location, $dropoff_description,
            $price, $options, $booked_by
        );
        if (!$stmt->execute()) {
            die("Booking insert failed: " . $stmt->error);
        }
        $new_booking_id = $stmt->insert_id;
        $stmt->close();

        if ($user_type === 'user') {
            // Insert corresponding booking_unavailability
            $stmtInsert = $con->prepare("
                INSERT INTO booking_unavailability
                (start_date, end_date, start_time, end_time, reason, created_by, created_by_username)
                VALUES (?, ?, ?, ?, 'user booked', ?, ?)
            ");
            $stmtInsert->bind_param(
                "ssssss",
                $trip_date, $trip_date, $pickup_time, $end_time,
                $booked_by, $booked_by_username
            );
            if (!$stmtInsert->execute()) {
                die("Unavailability insert failed: " . $stmtInsert->error);
            }
            $new_unavailability_id = $stmtInsert->insert_id;
            $stmtInsert->close();

            // Update flight_passenger with new unavailability_id
            $stmtUpdate = $con->prepare("UPDATE flight_passenger SET unavailability_id = ? WHERE id = ?");
            $stmtUpdate->bind_param("ii", $new_unavailability_id, $new_booking_id);
            if (!$stmtUpdate->execute()) {
                die("Failed to update booking with unavailability_id: " . $stmtUpdate->error);
            }
            $stmtUpdate->close();
        }
    }

    header("Location: view_flight_booking_form?success=1");
    exit;
}
?>
