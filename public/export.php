
<?php include "../config/config.php";
header("Content-Type:text/csv");
header("Content-Disposition:attachment;filename=invoices.csv");
$o=fopen("php://output","w");
$r=$conn->query("SELECT * FROM invoices");
while($d=$r->fetch_assoc()) fputcsv($o,$d);
