
<?php include "../config/config.php";
if(!isset($_SESSION['admin'])) exit;
if($_POST){
$conn->query("INSERT INTO invoices(customer_id,amount,due_date)
VALUES('{$_POST['customer']}','{$_POST['amount']}','{$_POST['due']}')");
}
$cs=$conn->query("SELECT * FROM customers");
$iv=$conn->query("SELECT invoices.*, customers.name FROM invoices
JOIN customers ON customers.id=invoices.customer_id");
?>
<h2>Invoices</h2>
<form method="post">
<select name="customer">
<?php while($c=$cs->fetch_assoc()): ?>
<option value="<?= $c['id'] ?>"><?= $c['name'] ?></option>
<?php endwhile; ?>
</select>
<input name="amount" placeholder="Amount">
<input name="due" type="date">
<button>Add</button>
</form>
<ul>
<?php while($i=$iv->fetch_assoc()): ?>
<li><?= $i['name'] ?> | <?= $i['amount'] ?> | <?= $i['status'] ?></li>
<?php endwhile; ?>
</ul>
