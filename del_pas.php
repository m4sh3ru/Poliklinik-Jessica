
<?php require_once('Connections/koneksi.php'); ?>
<?php
if (isset($_GET['no_pas'])) { 
mysql_select_db($database_koneksi, $koneksi);
$no_pas=$_GET['no_pas'];
$qry="DELETE FROM pasien WHERE no_pas='$no_pas'";
$del=mysql_query($qry) or die(mysql_error());
 // header(sprintf("Location: %s", $deleteGoTo));
 ?><script language="javascript">document.location.href='?page=pasien'</script> <?php
}
?>