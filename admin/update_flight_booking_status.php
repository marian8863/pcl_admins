<?php
session_start();
include '../config.php';

if (!isset($_SESSION['user']) || !in_array($_SESSION['user']['user_type'], ['admin','ADM'])) {
    die("Unauthorized");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $status = $_POST['status'] ?? '';
    $reason = trim($_POST['reason'] ?? '');

    if (!in_array($status, ['confirmed', 'needs_change'])) {
        die("Invalid status");
    }

    if ($status === 'needs_change' && empty($reason)) {
        die("Reason is required when booking needs change.");
    }

    $stmt = $con->prepare("UPDATE flight_passenger SET status = ?, change_reason = ? WHERE id = ?");
    $stmt->bind_param("ssi", $status, $reason, $id);

    if ($stmt->execute()) {
        header("Location: booking_list.php?status_updated=1");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
