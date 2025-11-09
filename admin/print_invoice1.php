<?php
use Dompdf\Dompdf;
use Dompdf\Options;

require_once 'dompdf/autoload.inc.php';
include '../config.php';

if(isset($_GET['get_id'])){
    $pid = (int)$_GET['get_id']; // sanitize input
    $pdfType = $_GET['type'] ?? 'billing'; // default billing

    // Fetch booking info for PDF name
    $stmt = $con->prepare("SELECT passenger.date_de_prise_en_charge, type_mission.type_m 
                           FROM passenger 
                           JOIN type_mission ON type_mission.tm_id = passenger.tm_id 
                           WHERE passenger.p_id = ?");
    $stmt->bind_param("i", $pid);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if(!$row){
        die("No data found for this ID.");
    }

    $date_de_prise_en_charge = $row['date_de_prise_en_charge'];
    $type_m = $row['type_m'];

    // Instead of calling public URL, include pdf_print PHP directly
    // Capture its output with output buffering
    ob_start();
    $_GET['get_id'] = $pid;    // simulate GET variable for pdf_print
    $_GET['type'] = $pdfType;  // simulate type
    include 'pdf_print.php';   // your existing PDF HTML template
    $html = ob_get_clean();

    // Initialize DOMPDF
    $dompdf = new Dompdf();
    $options = $dompdf->getOptions();
    $options->setDefaultFont('Courier');
    $options->setIsRemoteEnabled(true);
    $dompdf->setOptions($options);

    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    // Sanitize filename
    $filename = preg_replace('/[^A-Za-z0-9_\-]/', '_', "({$date_de_prise_en_charge})-{$type_m}");
    
    // Output PDF for browser (mobile share safe)
    $dompdf->stream($filename, ["Attachment" => 0]);
    exit;
}
?>
