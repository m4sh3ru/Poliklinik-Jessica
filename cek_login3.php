<?php include('Connections/koneksi.php'); ?>
<?php
mysql_select_db('poliklinik');
$user=$_POST['username'];
$pass=md5($_POST['password']);

$query="select * from login where user='$user'and pass='$pass'";
$login=mysql_query($query) or die(mysql_error());
$row_login=mysql_fetch_assoc($login);
$num_login=mysql_num_rows($login);

if($num_login>0) {
session_start();
$_SESSION['user']=$row_login['user'];
$_SESSION['tipe_user']=$row_login['tipe_user'];

header('location:dashboard.php');

}else{
session_destroy();
header('location:login_poliklinik.php');
}

?>