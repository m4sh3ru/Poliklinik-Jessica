<?php require_once('Connections/koneksi.php'); ?>
<?php
if (isset($_GET['no_resep'])) { 
mysql_select_db($database_koneksi, $koneksi);
$no_resep=$_GET['no_resep'];
$qry="DELETE FROM resep WHERE no_resep='$no_resep'";
$del=mysql_query($qry) or die(mysql_error());
 // header(sprintf("Location: %s", $deleteGoTo));
 ?><script language="javascript">document.location.href='?page=resep'</script> <?php
}
?>