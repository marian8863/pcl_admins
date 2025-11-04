<?php
include '../config.php';

$p_id = (int)($_POST['p_id'] ?? 0);
if ($p_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Passenger ID missing']);
    exit;
}

$has_company  = $_POST['has_company'] ?? 'no';
$company_name = ($has_company === 'yes') ? ($_POST['company_name'] ?? '') : 'No Company';
$qty          = (int)($_POST['qty'] ?? 1);
$unit_price   = (float)($_POST['unit_price'] ?? 0);
$total_ht     = $qty * $unit_price;
$tva          = $total_ht * 0.10;
$total_ttc    = $total_ht + $tva;

// Insert into invoices
$stmt = $con->prepare("INSERT INTO invoices 
    (p_id, has_company, company_name, qty, unit_price, total_price_ht, tva, total_ttc, created_at)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
$stmt->bind_param("issidddd", $p_id, $has_company, $company_name, $qty, $unit_price, $total_ht, $tva, $total_ttc);
$stmt->execute();

$invoice_id = $stmt->insert_id;
$stmt->close();

// Respond with JSON
header('Content-Type: application/json');
echo json_encode(['success' => true, 'invoice_id' => $invoice_id]);
exit;
?>
