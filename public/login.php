
<?php include "../config/config.php";
if($_POST){
$q=$conn->prepare("SELECT * FROM admins WHERE username=?");
$q->bind_param("s",$_POST['username']);
$q->execute();
$r=$q->get_result()->fetch_assoc();
if($r && password_verify($_POST['password'],$r['password'])){
$_SESSION['admin']=$r;
header("Location: dashboard.php");
}
}
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<div class="container mt-5">
<h3>Login</h3>
<form method="post">
<input class="form-control mb-2" name="username">
<input class="form-control mb-2" type="password" name="password">
<button class="btn btn-primary">Login</button>
</form>
</div>
