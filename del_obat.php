<?php require_once('Connections/koneksi.php'); ?>
<?php
if (isset($_GET['kode_obat'])) { 
mysql_select_db($database_koneksi, $koneksi);
$kode_obat=$_GET['kode_obat'];
$qry="DELETE FROM obat WHERE kode_obat='$kode_obat'";
$del=mysql_query($qry) or die(mysql_error());
 // header(sprintf("Location: %s", $deleteGoTo));
 ?><script language="javascript">document.location.href='?page=obat'</script> <?php
}
?>

