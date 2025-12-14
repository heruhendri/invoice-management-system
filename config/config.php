
<?php
session_start();
$host = "localhost";
$user = "db_user";
$pass = "db_pass";
$db   = "db_name";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("DB Connection Failed");
}
?>
