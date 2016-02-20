
<?php require_once('Connections/koneksi.php'); ?>
<?php
if (isset($_GET['no_pemeriksaan'])) { 
mysql_select_db($database_koneksi, $koneksi);
$no_pemeriksaan=$_GET['no_pemeriksaan'];
$qry="DELETE FROM pemeriksaan WHERE no_pemeriksaan='$no_pemeriksaan'";
$del=mysql_query($qry) or die(mysql_error());
 // header(sprintf("Location: %s", $deleteGoTo));
 ?><script language="javascript">document.location.href='?page=pemeriksaan'</script> <?php
}
?>