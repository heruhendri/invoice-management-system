
<?php
function allow($menu){
 if($_SESSION['admin']['role']=='SUPER') return true;
 return false;
}
?>
