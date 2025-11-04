<?php
use Dompdf\Dompdf;
use Dompdf\Options;

// Include DOM Pdf autoload file
require_once 'dompdf/autoload.inc.php';
include '../config.php';

$invoice_id = (int)($_GET['invoice_id'] ?? 0);
if ($invoice_id <= 0) die("Invoice ID missing.");

$p_id = (int)($_GET['get_id'] ?? 0);
if ($p_id <= 0) die("Passenger ID missing.");

// --- Fetch Passenger Info ---
$passenger_sql = "
SELECT 
    p.passager_principal,
    p.date_de_prise_en_charge,
    p.Time,
    p.pickup_location,
    p.dropoff_location,
    ppd.ppd_desc AS pick_desc,
    pdd.pdd_desc AS drop_desc,
    pickup.name AS pickup_adr,
    dropoff.name AS dropoff_adr
FROM passenger p
LEFT JOIN flight_locations pickup ON p.pickup_location = pickup.id
LEFT JOIN flight_locations dropoff ON p.dropoff_location = dropoff.id
LEFT JOIN passenger_pickup_desc ppd ON p.p_id = ppd.p_id
LEFT JOIN passenger_dropoff_desc pdd ON p.p_id = pdd.p_id
WHERE p.p_id = $p_id
LIMIT 1
";

$passenger_result = mysqli_query($con, $passenger_sql);
if (!$passenger_result || mysqli_num_rows($passenger_result) == 0) die("Passenger not found.");
$passenger = mysqli_fetch_assoc($passenger_result);

// --- Fetch Invoice Info ---
$invoice_sql = "SELECT * FROM invoices WHERE id = $invoice_id LIMIT 1";
$invoice_result = mysqli_query($con, $invoice_sql);
if (!$invoice_result || mysqli_num_rows($invoice_result) === 0) die("Invoice not found.");
$invoice = mysqli_fetch_assoc($invoice_result);

// --- Extract Data ---
$passager_principal = $passenger['passager_principal'];
$date_de_prise_en_charge = $passenger['date_de_prise_en_charge'];
$Time = $passenger['Time'];

// Handle pickup/dropoff
if ($passenger['pickup_location'] === 'others') {
    $pickup_location = $passenger['pick_desc'];
} else {
    $pickup_location = $passenger['pickup_adr'];
}

if ($passenger['dropoff_location'] === 'others') {
    $dropoff_location = $passenger['drop_desc'];
} else {
    $dropoff_location = $passenger['dropoff_adr'];
}

// Client name only if company
$client_name = '';
if ($invoice['has_company'] == 'yes' && !empty($invoice['company_name'])) {
    $client_name = $invoice['company_name'];
}

$total_ht   = number_format((float)$invoice['total_price_ht'], 2, ',', ' ');
$tva        = number_format((float)$invoice['tva'], 2, ',', ' ');
$total_ttc  = number_format((float)$invoice['total_ttc'], 2, ',', ' ');
$unit_price = number_format((float)$invoice['unit_price'], 2, ',', ' ');
$qty        = (int)$invoice['qty'];

// --- Build HTML ---
// --- Build HTML ---
// --- Build HTML ---
$html = '
<style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #000; }
    .header {  margin-bottom: 20px; }
    .logo img { width: 130px; margin-bottom: 5px; }
    .company-info { line-height: 1.5;  }
    .company-info .name { font-size: 15px; font-weight: bold; }
    .client-info { margin-top: 10px; margin-bottom: 25px; line-height: 1.4; }
    table { border-collapse: collapse; width: 100%; margin-top: 10px; }
    th, td { border: 1px solid #000; padding: 6px; text-align: center; font-size: 10px; }
    th { background: #f2f2f2; }
    .no-border td { border: none; text-align: right; font-weight: bold; padding-right: 10px; font-size: 10px; }
    .footer { text-align: center; font-size: 11px; margin-top: 40px; color: #555; }
</style>

<div class="header">
    <div class="logo">
        <img src="dist/img/logo_pdf.png" alt="Paris Cab Limousine Logo">
    </div>
    <div class="company-info">
        <div class="name">Paris Cab Limousine</div>
        44 Avenue Albert Sarraut<br>
        95190 GOUSSAINVILLE, France<br>
        Tel: +336 660 763 235<br>
        Email: pariscablimo@gmail.com<br>
        Siret: 84005602200014 - APE: 4932Z<br>
        TVA: FR20840056022 - Capital: 1,500.00 €<br>
    </div>
</div>

<div class="client-info">
    <b>Company:</b> '.htmlspecialchars($passager_principal).'<br>';
if (!empty($client_name)) {
    $html .= '<b>Client:</b> '.htmlspecialchars($client_name).'<br>';
}
$html .= '
</div>

<h2 style="text-align:center;">INVOICE</h2>

<table>
    <tr>
        <th>Date</th>
        <th>Time</th>
        <th>Service</th>
        <th>Qty</th>
        <th>Unit Price HT</th>
        <th>Total Price HT</th>
    </tr>
    <tr>
        <td>'.htmlspecialchars($date_de_prise_en_charge).'</td>
        <td>'.htmlspecialchars($Time).'</td>
        <td>'.htmlspecialchars($pickup_location).' >>> '.htmlspecialchars($dropoff_location).'</td>
        <td>'.$qty.'</td>
        <td>'.$unit_price.' €</td>
        <td>'.$total_ht.' €</td>
    </tr>
    <tr class="no-border">
        <td colspan="4"></td>
        <td>Taxable Subtotal:</td>
        <td>'.$total_ht.' €</td>
    </tr>
    <tr class="no-border">
        <td colspan="4"></td>
        <td>TVA 10%:</td>
        <td>'.$tva.' €</td>
    </tr>
    <tr class="no-border">
        <td colspan="4"></td>
        <td>Total TTC:</td>
        <td>'.$total_ttc.' €</td>
    </tr>
</table>

<div class="footer">
    Thank you for your business — Paris Cab Limousine
</div>
';



// --- Generate PDF ---
$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

$filename = 'Invoice_'.$invoice_id.'.pdf';
$dompdf->stream($filename, ["Attachment" => true]);
exit;
?>
