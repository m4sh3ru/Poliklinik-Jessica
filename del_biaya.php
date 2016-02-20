
<?php require_once('Connections/koneksi.php'); ?>
<?php
if (isset($_GET['id_jenisbiaya'])) { 
mysql_select_db($database_koneksi, $koneksi);
$id_jenisbiaya=$_GET['id_jenisbiaya'];
$qry="DELETE FROM jenis_biaya WHERE id_jenisbiaya='$id_jenisbiaya'";
$del=mysql_query($qry) or die(mysql_error());
 // header(sprintf("Location: %s", $deleteGoTo));
 ?><script language="javascript">document.location.href='?page=jenis_biaya'</script> <?php
}
?>