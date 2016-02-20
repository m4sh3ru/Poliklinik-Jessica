
<?php require_once('Connections/koneksi.php'); ?>
<?php
if (isset($_GET['kode_jadwal'])) { 
mysql_select_db($database_koneksi, $koneksi);
$kode_jadwal=$_GET['kode_jadwal'];
$qry="DELETE FROM jadwal_praktek WHERE kode_jadwal='$kode_jadwal'";
$del=mysql_query($qry) or die(mysql_error());
 // header(sprintf("Location: %s", $deleteGoTo));
 ?><script language="javascript">document.location.href='?page=jadwal_praktek'</script> <?php
}
?>