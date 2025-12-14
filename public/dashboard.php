
<?php include "../config/config.php";
if(!isset($_SESSION['admin'])) header("Location: login.php");
?>
<h1>Dashboard</h1>
<a href="customers.php">Customers</a> |
<a href="invoices.php">Invoices</a> |
<a href="logout.php">Logout</a>
