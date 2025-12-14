
<?php
include "../config/config.php";
$r=$conn->query("SELECT invoices.*,customers.phone,DATEDIFF(due_date,CURDATE()) d
FROM invoices JOIN customers ON customers.id=invoices.customer_id
WHERE status='UNPAID'");
while($i=$r->fetch_assoc()){
 if($i['d'] IN (3,1,0)){
  echo "Reminder {$i['d']} days: https://wa.me/{$i['phone']}\n";
 }
 if($i['d']<0){
  $conn->query("UPDATE invoices SET status='OVERDUE' WHERE id={$i['id']}");
 }
}
