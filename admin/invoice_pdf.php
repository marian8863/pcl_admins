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

    $sql="SELECT 

    passenger.date_de_prise_en_charge,passenger.Time,
    who_give_booking.wg_desc,
    type_mission.type_m

    FROM passenger,type_mission,who_give_booking
    WHERE  type_mission.tm_id=passenger.tm_id and  passenger.p_id=who_give_booking.p_id and
    
     passenger.p_id=$p_id";
      $result = mysqli_query($con,$sql);
      if(mysqli_num_rows($result)==1) {       
          $row=mysqli_fetch_assoc($result);

          $date_de_prise_en_charge=$row['date_de_prise_en_charge'];
          $type_m=$row['type_m']; 
          $Time=$row['Time']; 
          $wg_desc=$row['wg_desc'];    
      }



// --- Build URL of the template HTML page ---
// $template_url = "http://localhost/pcl_admin/pcl_admins/admin/invoice_p?get_id={$p_id}&invoice_id={$invoice_id}";

$template_url = "https://booking.pariscablimousine.com/admin/invoice_p?get_id={$p_id}&invoice_id={$invoice_id}";

// $url = 'https://booking.pariscablimousine.com/admin/pdf_print?get_id='. urlencode($pid) . '&type=' . urlencode($pdfType);


// --- Fetch the contents of the URL ---
$html = file_get_contents($template_url);

// Optional: check if HTML was retrieved
if (!$html) {
    die("Failed to  invoice .");
}

// --- Generate PDF using Dompdf ---
$options = new Options();
$options->set('isRemoteEnabled', true); // needed if using images/logos
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// --- Stream the PDF to browser ---
// $filename = "Invoice_{$p_id}.pdf";
// $dompdf->stream($filename, ["Attachment" => 0]);
// exit;

list($hour, $minute) = explode(':', $Time);
$formattedTime = ltrim($hour, '0') . 'h' . $minute;


$filename = 'INVOICE(' . $date_de_prise_en_charge . ') - '  . $formattedTime ;

$filename = preg_replace('/[^A-Za-z0-9_\-\(\)\s]/', '', $filename); 

$dompdf->stream($filename, ["Attachment" => 0]);
exit;
?>
