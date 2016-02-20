<?php require_once('Connections/koneksi.php'); ?>
<?php
if (isset($_GET['nip'])) { 
mysql_select_db($database_koneksi, $koneksi);
$nip=$_GET['nip'];
$qry="DELETE FROM pegawai WHERE nip='$nip'";
$del=mysql_query($qry) or die(mysql_error());
 // header(sprintf("Location: %s", $deleteGoTo));
 ?><script language="javascript">document.location.href='?page=pegawai'</script> <?php
}
?>

