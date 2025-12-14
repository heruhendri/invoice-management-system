
<?php include "../config/config.php";
if ($_POST) {
    $u = $_POST['username'];
    $p = $_POST['password'];
    $q = $conn->prepare("SELECT * FROM admins WHERE username=?");
    $q->bind_param("s",$u);
    $q->execute();
    $r = $q->get_result()->fetch_assoc();
    if ($r && password_verify($p,$r['password'])) {
        $_SESSION['admin']=$u;
        header("Location: dashboard.php");
    } else $err="Login gagal";
}
?>
<form method="post">
<h2>Admin Login</h2>
<?= $err ?? '' ?>
<input name="username" placeholder="Username"><br>
<input name="password" type="password" placeholder="Password"><br>
<button>Login</button>
</form>
