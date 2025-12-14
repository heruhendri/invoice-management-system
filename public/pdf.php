
<?php
require "../vendor/autoload.php";
use Dompdf\Dompdf;
include "../config/config.php";
$id=$_GET['id'];
$d=$conn->query("SELECT invoices.*,customers.name,companies.logo,companies.name cname
FROM invoices
JOIN customers ON customers.id=invoices.customer_id
JOIN companies ON companies.id=invoices.company_id
WHERE invoices.id=$id")->fetch_assoc();

$html="<img src='../uploads/{$d['logo']}' height='60'>
<h2>{$d['cname']}</h2>
<hr>
Invoice for {$d['name']}<br>
Amount: {$d['currency']} {$d['amount']}";
$dom=new Dompdf();
$dom->loadHtml($html);
$dom->render();
$dom->stream("invoice.pdf");
