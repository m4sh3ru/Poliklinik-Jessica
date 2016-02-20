<?php require_once('Connections/koneksi.php'); ?>
<?php
if (isset($_GET['kode_dokter'])) { 
mysql_select_db($database_koneksi, $koneksi);
$kode_dokter=$_GET['kode_dokter'];
$qry="DELETE FROM dokter WHERE kode_dokter='$kode_dokter'";
$del=mysql_query($qry) or die(mysql_error());
 // header(sprintf("Location: %s", $deleteGoTo));
 ?><script language="javascript">document.location.href='?page=dokter'</script> <?php
}
?>
