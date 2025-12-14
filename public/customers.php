
<?php include "../config/config.php";
if(!isset($_SESSION['admin'])) exit;
if($_POST){
$conn->query("INSERT INTO customers(name,phone,address)
VALUES('{$_POST['name']}','{$_POST['phone']}','{$_POST['address']}')");
}
$data=$conn->query("SELECT * FROM customers");
?>
<h2>Customers</h2>
<form method="post">
<input name="name" placeholder="Name">
<input name="phone" placeholder="Phone">
<textarea name="address" placeholder="Address"></textarea>
<button>Add</button>
</form>
<ul>
<?php while($c=$data->fetch_assoc()): ?>
<li><?= $c['name'] ?> - 
<a target="_blank" href="https://wa.me/<?= $c['phone'] ?>">WA</a>
</li>
<?php endwhile; ?>
</ul>
