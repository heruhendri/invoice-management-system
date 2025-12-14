
<?php include "../config/config.php";
if(!isset($_SESSION['admin'])) exit;
if($_POST){
$conn->query("INSERT INTO invoices(customer_id,amount,currency,due_date)
VALUES('{$_POST['customer']}','{$_POST['amount']}','{$_POST['currency']}','{$_POST['due']}')");
}
$c=$conn->query("SELECT * FROM customers");
$i=$conn->query("SELECT invoices.*,customers.name,customers.phone FROM invoices
JOIN customers ON customers.id=invoices.customer_id");
?>
<div class="container">
<h3>Invoices</h3>
<form method="post">
<select name="customer">
<?php while($x=$c->fetch_assoc()): ?>
<option value="<?= $x['id']?>"><?= $x['name']?></option>
<?php endwhile; ?>
</select>
<input name="amount">
<select name="currency"><option>IDR</option><option>USD</option></select>
<input type="date" name="due">
<button>Add</button>
</form>
<ul>
<?php while($v=$i->fetch_assoc()): ?>
<li><?= $v['name']?> <?= $v['currency']?><?= $v['amount']?> 
<a href="https://wa.me/<?= $v['phone']?>">WA</a>
<a href="pdf.php?id=<?= $v['id']?>">PDF</a>
</li>
<?php endwhile; ?>
</ul>
</div>
