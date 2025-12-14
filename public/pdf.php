
<?php
require "../vendor/autoload.php";
use Dompdf\Dompdf;
include "../config/config.php";
$id=$_GET['id'];
$d=$conn->query("SELECT invoices.*,customers.name FROM invoices
JOIN customers ON customers.id=invoices.customer_id WHERE invoices.id=$id")->fetch_assoc();
$html="<h1>Invoice</h1><p>{$d['name']}<br>{$d['currency']} {$d['amount']}</p>";
$dompdf=new Dompdf();
$dompdf->loadHtml($html);
$dompdf->render();
$dompdf->stream("invoice.pdf");
