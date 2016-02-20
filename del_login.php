<?php require_once('Connections/koneksi.php'); ?>
<?php
if (isset($_GET['id'])) { 
mysql_select_db($database_koneksi, $koneksi);
$id=$_GET['id'];
$qry="DELETE FROM login WHERE id='$id'";
$del=mysql_query($qry) or die(mysql_error());
 // header(sprintf("Location: %s", $deleteGoTo));
 ?><script language="javascript">document.location.href='?page=login'</script> <?php
}
?>