<?php
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
?>