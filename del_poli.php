<?php require_once('Connections/koneksi.php'); ?>
<?php
if (isset($_GET['kode_poli'])) { 
mysql_select_db($database_koneksi, $koneksi);
$kode_poli=$_GET['kode_poli'];
$qry="DELETE FROM poliklinik WHERE kode_poli='$kode_poli'";
$del=mysql_query($qry) or die(mysql_error());
 // header(sprintf("Location: %s", $deleteGoTo));
 ?><script language="javascript">document.location.href='?page=poliklinik'</script> <?php
}
?>