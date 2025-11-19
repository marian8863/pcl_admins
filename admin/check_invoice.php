<?php
include "../config.php";


$p_id = isset($_POST['p_id']) ? (int)$_POST['p_id'] : 0;
$response = ['exists' => false];

if ($p_id > 0) {
    $stmt = $con->prepare("SELECT invoice_id FROM invoices WHERE p_id = ? LIMIT 1");
    $stmt->bind_param("i", $p_id);
    $stmt->execute();
    $stmt->bind_result($invoice_id);

    if ($stmt->fetch()) {
        $response['exists'] = true;
        $response['invoice_id'] = $invoice_id;
    }

    $stmt->close();
}

header('Content-Type: application/json');
echo json_encode($response);
?>