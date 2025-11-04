<?php
use Dompdf\Dompdf;
use Dompdf\Options;
require_once 'dompdf/autoload.inc.php';

// Include DB config
include '../config.php';

// --- Get IDs from URL ---
$p_id = isset($_GET['get_id']) ? (int)$_GET['get_id'] : 0;
$invoice_id = isset($_GET['invoice_id']) ? (int)$_GET['invoice_id'] : 0;

if ($p_id <= 0 || $invoice_id <= 0) {
    die("Missing required parameters.");
}

// --- Build URL of the template HTML page ---
// $template_url = "http://localhost/pcl_admin/pcl_admins/admin/invoice_pdf1?get_id={$p_id}&invoice_id={$invoice_id}";

$template_url = "https://booking.pariscablimousine.com/admin/invoice_pdf1?get_id={$p_id}&invoice_id={$invoice_id}";

// $url = 'https://booking.pariscablimousine.com/admin/pdf_print?get_id='. urlencode($pid) . '&type=' . urlencode($pdfType);


// --- Fetch the contents of the URL ---
$html = file_get_contents($template_url);

// Optional: check if HTML was retrieved
if (!$html) {
    die("Failed to fetch invoice template HTML.");
}

// --- Generate PDF using Dompdf ---
$options = new Options();
$options->set('isRemoteEnabled', true); // needed if using images/logos
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// --- Stream the PDF to browser ---
$filename = "Invoice_{$p_id}.pdf";
$dompdf->stream($filename, ["Attachment" => 0]);
exit;
?>
