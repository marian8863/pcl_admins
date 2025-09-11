<?php

include '../config.php';

$id = intval($_POST['id'] ?? $_GET['id']);
$status = $_POST['status'] ?? $_GET['status'] ?? '';
$reason = $_POST['change_reason'] ?? null;

if ($id && $status) {
    if ($reason) {
        $stmt = $con->prepare("UPDATE flight_passenger SET status=?, change_reason=? WHERE id=?");
        $stmt->bind_param("ssi", $status, $reason, $id);
    } else {
        $stmt = $con->prepare("UPDATE flight_passenger SET status=? WHERE id=?");
        $stmt->bind_param("si", $status, $id);
    }
    $stmt->execute();
}
header("Location: view_flight_booking_form.php");
