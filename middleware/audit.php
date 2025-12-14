
<?php
function audit($conn,$admin,$action){
 $conn->query("INSERT INTO audit_logs(admin_id,action)
 VALUES($admin,'$action')");
}
?>
