<?php require_once('Connections/koneksi.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$colname_cetak_kartu = "-1";
if (isset($_GET['no_pas'])) {
  $colname_cetak_kartu = $_GET['no_pas'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_cetak_kartu = sprintf("SELECT * FROM pasien WHERE no_pas = %s", GetSQLValueString($colname_cetak_kartu, "text"));
$cetak_kartu = mysql_query($query_cetak_kartu, $koneksi) or die(mysql_error());
$row_cetak_kartu = mysql_fetch_assoc($cetak_kartu);
$totalRows_cetak_kartu = mysql_num_rows($cetak_kartu);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cetak kartu pasien</title>
</head>

<body onload="window.print()">
<table width="200" border="1" align="center">
<thead>
  <tr>
    <td rowspan="3"><img src="images/poliklinik.jpg" width="261" height="193" /></td>
    <td><div align="center"><strong>RSUD Sejahtera</strong></div></td>
  </tr>
  <tr>
    <td><h2 align="center"><?php echo $row_cetak_kartu['nama_pas']; ?></h2></td>
  </tr>
  <tr>
    <td><h1 align="center"><?php echo $row_cetak_kartu['no_pas']; ?></h1></td>
  </tr>
  </table>
</table>
</body>
</html>
<?php
mysql_free_result($cetak_kartu);
?>
