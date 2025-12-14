
<?php
include "../config/config.php";
$r=$conn->query("SELECT invoices.*,customers.phone FROM invoices
JOIN customers ON customers.id=invoices.customer_id
WHERE due_date=CURDATE() AND status='UNPAID'");
while($d=$r->fetch_assoc()){
echo "https://wa.me/{$d['phone']}?text=Invoice%20jatuh%20tempo\n";
}
