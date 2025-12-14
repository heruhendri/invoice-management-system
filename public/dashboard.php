
<?php include "../config/config.php";
if(!isset($_SESSION['admin'])) exit;
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<div class="container mt-4">
<h4>Dashboard (<?= $_SESSION['admin']['role']?>)</h4>
<a href="customers.php">Customers</a> |
<a href="invoices.php">Invoices</a> |
<a href="export.php">Export</a> |
<a href="logout.php">Logout</a>
</div>
