
<?php
include "../config/config.php";
header("Content-Type:application/json");
$r=$conn->query("SELECT * FROM invoices");
echo json_encode($r->fetch_all(MYSQLI_ASSOC));
